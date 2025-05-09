<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Tampilkan semua data pengeluaran.
     */
    public function index()
    {
        $pengeluaran = Pengeluaran::with('user')->get();
        return response()->json($pengeluaran);
    }

    /**
     * Simpan data pengeluaran baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $pengeluaran = Pengeluaran::create($validated);
        return response()->json($pengeluaran, 201);
    }

    /**
     * Tampilkan detail pengeluaran tertentu.
     */
    public function show($id)
    {
        $pengeluaran = Pengeluaran::with('user')->findOrFail($id);
        return response()->json($pengeluaran);
    }

    /**
     * Perbarui data pengeluaran tertentu.
     */
    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);

        $validated = $request->validate([
            'tanggal' => 'sometimes|required|date',
            'catatan' => 'nullable|string',
            'jumlah' => 'sometimes|required|numeric',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $pengeluaran->update($validated);
        return response()->json($pengeluaran);
    }

    /**
     * Hapus data pengeluaran tertentu.
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return response()->json(['message' => 'Data pengeluaran berhasil dihapus']);
    }
}
