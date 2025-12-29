<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class TugasController extends Controller
{
    public function index()
    {
        try {
            $response = Http::timeout(3)->get('http://worldtimeapi.org/api/timezone/Asia/Jakarta');
            $currentTime = $response->successful() ? $response->json()['datetime'] : now();
        } catch (\Exception $e) {
            $currentTime = now(); 
        }

        $tasks = Tugas::orderBy('deadline', 'asc')->get();

        return view('tugas.index', compact('tasks', 'currentTime'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_name'      => 'required|string|max:150',
            'task_category'  => 'required|in:Akademik,Organisasi',
            'deadline'       => 'required|date',
            'progres_status' => 'required|in:Belum Selesai,Sedang Dikerjakan,Selesai',
            'catatan'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Tugas::create([
           
            'task_name'      => $request->task_name,
            'task_category'  => $request->task_category,
            'deadline'       => $request->deadline,
            'progres_status' => $request->progres_status,
            'catatan'        => $request->catatan, 
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $task = Tugas::findOrFail($id);
        return view('tugas.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = Tugas::findOrFail($id);
        
        $task->update($request->only(['task_name', 'task_category', 'deadline', 'progres_status', 'catatan']));

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $task = Tugas::findOrFail($id);
        $task->delete();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus!');
    }

    public function exportPdf()
    {
        $tasks = Tugas::all(); 
        $pdf = Pdf::loadView('tugas.pdf', compact('tasks'));
        return $pdf->stream('Laporan_Manajemen_Tugas.pdf');
    }
}