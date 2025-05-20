<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use Illuminate\Http\Request;

class PiutangController extends Controller
{
    // List semua piutang
    public function index()
    {
        return Piutang::with('user')->get();
    }

    // Tambah piutang
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'debitur' => 'required|string',
            'user_id' => 'required|exists:users,user_id'
        ]);

        $piutang = Piutang::create($request->all());

        return response()->json($piutang, 201);
    }

    // Tampilkan 1 data
    public function show($id)
    {
        $piutang = Piutang::with('user')->findOrFail($id);
        return response()->json($piutang);
    }

    // Update data
    public function update(Request $request, $id)
    {
        $piutang = Piutang::findOrFail($id);

        $piutang->update($request->all());

        return response()->json($piutang);
    }

    // Hapus data
    public function destroy($id)
    {
        $piutang = Piutang::findOrFail($id);
        $piutang->delete();

        return response()->json(null, 204);
    }
}