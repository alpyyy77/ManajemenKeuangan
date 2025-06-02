<?php

namespace App\Http\Controllers\API;

use App\Models\Piutang;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Piutang",
 *     description="Manajemen data Piutang"
 * )
 */
class PiutangController extends Controller
{
    /**
     * @OA\Get(
     *     path="/piutang",
     *     tags={"Piutang"},
     *     summary="Ambil semua data piutang",
     *     @OA\Response(response=200, description="Sukses")
     * )
     */
    public function index()
    {
        return Piutang::with('user')->get();
    }

    /**
     * @OA\Post(
     *     path="/piutang",
     *     tags={"Piutang"},
     *     summary="Buat data piutang",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Piutang")
     *     ),
     *     @OA\Response(response=201, description="Berhasil dibuat")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'debitur' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        $piutang = Piutang::create($validated);
        return response()->json($piutang, 201);
    }

    /**
     * @OA\Get(
     *     path="/piutang/{id}",
     *     tags={"Piutang"},
     *     summary="Ambil piutang berdasarkan ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Berhasil"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function show($id)
    {
        return Piutang::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/piutang/{id}",
     *     tags={"Piutang"},
     *     summary="Update data piutang",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Piutang")),
     *     @OA\Response(response=200, description="Berhasil diupdate"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $piutang = Piutang::findOrFail($id);
        $piutang->update($request->all());
        return response()->json($piutang);
    }

    /**
     * @OA\Delete(
     *     path="/piutang/{id}",
     *     tags={"Piutang"},
     *     summary="Hapus data piutang",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Berhasil dihapus"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $piutang = Piutang::findOrFail($id);
        $piutang->delete();
        return response()->json(null, 204);
    }
}
