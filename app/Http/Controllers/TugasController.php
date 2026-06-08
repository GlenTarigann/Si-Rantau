<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TugasController extends Controller
{
    public function index()
    {
        $tasks = Tugas::where('user_id', Auth::id())
                    ->orderBy('deadline', 'asc')
                    ->get();

        $today = Carbon::now('Asia/Jakarta');

        // Pengingat: tugas yang belum selesai & deadlinenya belum lewat
        // Jika deadline sudah lewat, dianggap selesai dan tidak diikutkan
        $closestTask = Tugas::where('user_id', Auth::id())
                    ->where('progres_status', '!=', 'Selesai')
                    ->where('deadline', '>=', $today->toDateTimeString())
                    ->orderBy('deadline', 'asc')
                    ->first();

        try {
            $response = Http::timeout(3)->get("https://api-harilibur.vercel.app/api?year=" . $today->year);
            $libur = collect($response->json())->firstWhere('holiday_date', $today->format('Y-m-d'));
        } catch (\Exception $e) {
            $libur = null;
        }

        return view('tugas.index', compact('tasks', 'today', 'libur', 'closestTask'));
    }


    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'task_name'      => 'required|string|max:150',
            'task_category'  => 'required|in:Akademik,Organisasi',
            'deadline'       => 'required|date',
            'progres_status' => 'required|in:Belum Selesai,Sedang Dikerjakan,Selesai',
            'catatan'        => 'nullable|string',
        ])->validate();

        Tugas::create([
            'user_id'        => Auth::id(),
            'task_name'      => $request->task_name,
            'task_category'  => $request->task_category,
            'deadline'       => $request->deadline,
            'progres_status' => $request->progres_status,
            'catatan'        => $request->catatan,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $task = Tugas::where('user_id', Auth::id())->findOrFail($id);

        $task->update($request->only(['task_name', 'task_category', 'deadline', 'progres_status', 'catatan']));

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Tugas::where('user_id', Auth::id())->findOrFail($id)->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus!');
    }

    public function exportPdf()
    {
        $tasks = Tugas::where('user_id', Auth::id())->orderBy('deadline')->get();
        $user  = Auth::user();

        $pdf = Pdf::loadView('tugas.pdf', compact('tasks', 'user'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_Manajemen_Tugas.pdf');
    }
}
