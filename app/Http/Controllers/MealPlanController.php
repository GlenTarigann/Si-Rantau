<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class MealPlanController extends Controller
{
    public function index(Request $request)
    {
        $meals = \App\Models\Meal::orderBy('planned_date', 'asc')->get();
        $search = $request->query('search');

        if ($search) {
            $apiUrl = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($search);
        } else {
            $apiUrl = "https://www.themealdb.com/api/json/v1/1/filter.php?c=Seafood";
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()->get($apiUrl);
            $res = $response->json();

            $rawRecipes = $res['meals'] ?? [];

            $recipes = collect($rawRecipes)->map(function ($item) {
                return [
                    'title' => $item['strMeal'],
                    'thumb' => $item['strMealThumb'],
                    'key'   => $item['idMeal']
                ];
            })->toArray();
        } catch (\Exception $e) {
            $recipes = [];
        }

        return view('mealplan', compact('meals', 'recipes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'planned_date' => 'required|date',
            'meal_time'    => 'required|in:Pagi,Siang,Malam',
            'recipe_name'  => 'required|string',
            'recipe_api_id' => 'nullable|string',
        ]);

        Meal::create($request->all());
        return redirect()->back()->with('success', 'Meal Plan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $meal = \App\Models\Meal::findOrFail($id);
        return view('mealplan_edit', compact('meal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'planned_date' => 'required|date',
            'meal_time'    => 'required|in:Pagi,Siang,Malam',
            'recipe_name'  => 'required|string',
            'notes'        => 'nullable|string',
        ]);

        $meal = \App\Models\Meal::findOrFail($id);
        $meal->update($request->all());

        return redirect()->route('mealplan.index')->with('success', 'Meal Plan berhasil diperbarui!');
    }

    public function showRecipe($id)
    {
        try {
            $response = Http::withoutVerifying()->get("https://food-recipe-api.vercel.app/api/recipe/" . $id);

            $recipe = $response->json()['results'] ?? null;

            if (!$recipe) return redirect()->back()->with('error', 'Resep tidak ditemukan.');

            return view('recipe_detail', compact('recipe'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat detail resep.');
        }
    }

    public function destroy($id)
    {
        $meal = Meal::findOrFail($id);
        $meal->delete();
        return redirect()->back()->with('success', 'Meal Plan berhasil dihapus!');
    }

    public function cetak(Request $request)
    {
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        $meals = Meal::whereBetween('planned_date', [$start, $end])
            ->orderBy('planned_date', 'asc')
            ->get();

        if ($meals->isEmpty()) {
            return back()->with('error', 'Tidak ada rencana makan pada rentang tanggal tersebut.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('cetak', compact('meals', 'start', 'end'));

        return $pdf->stream('Meal-Plan-' . $start . '-to-' . $end . '.pdf');
    }
}
