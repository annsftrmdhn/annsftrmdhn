<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        if ($status) {
            $pengaduans = Pengaduan::where('status', $status)->get();
        } else {
            $pengaduans = Pengaduan::all();
        }
        return response()->json($pengaduans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $pengaduan = Pengaduan::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'status' => 'menunggu',
        ]);

        return response()->json($pengaduan, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return response()->json($pengaduan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'sometimes|required|string|max:255',
            'isi' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:menunggu,diproses,selesai',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update($request->all());

        return response()->json($pengaduan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pengaduan::destroy($id);
        return response()->json(null, 204);
    }
}
