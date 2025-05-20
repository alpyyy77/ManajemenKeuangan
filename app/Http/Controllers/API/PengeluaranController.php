<?php

namespace App\Http\Controllers\Api;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use OpenApi\Annotations as OA;


/**
 * @OA\Tag(
 *     name="Pengeluaran",
 *     description="Manajemen data pengeluaran"
 * )
 */
class PengeluaranController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pengeluaran",
     *     tags={"Pengeluaran"},
     *     summary="Tampilkan semua data pengeluaran",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil menampilkan daftar pengeluaran",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Pengeluaran"))
     *     )
     * )
     */
    public function index()
    {
        $pengeluaran = Pengeluaran::with('user')->get();
        return response()->json($pengeluaran);
    }

    /**
     * @OA\Post(
     *     path="/api/pengeluaran",
     *     tags={"Pengeluaran"},
     *     summary="Simpan data pengeluaran baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"tanggal", "jumlah", "user_id"},
     *             @OA\Property(property="tanggal", type="string", format="date", example="2025-05-01"),
     *             @OA\Property(property="catatan", type="string", example="Belanja bahan"),
     *             @OA\Property(property="jumlah", type="number", example=150000),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data pengeluaran berhasil dibuat",
     *         @OA\JsonContent(ref="#/components/schemas/Pengeluaran")
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/pengeluaran/{id}",
     *     tags={"Pengeluaran"},
     *     summary="Tampilkan detail pengeluaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pengeluaran",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail pengeluaran ditemukan",
     *         @OA\JsonContent(ref="#/components/schemas/Pengeluaran")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $pengeluaran = Pengeluaran::with('user')->findOrFail($id);
        return response()->json($pengeluaran);
    }

    /**
     * @OA\Put(
     *     path="/api/pengeluaran/{id}",
     *     tags={"Pengeluaran"},
     *     summary="Perbarui data pengeluaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pengeluaran",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="tanggal", type="string", format="date", example="2025-05-02"),
     *             @OA\Property(property="catatan", type="string", example="Update catatan"),
     *             @OA\Property(property="jumlah", type="number", example=200000),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data berhasil diperbarui",
     *         @OA\JsonContent(ref="#/components/schemas/Pengeluaran")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/pengeluaran/{id}",
     *     tags={"Pengeluaran"},
     *     summary="Hapus data pengeluaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pengeluaran",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data pengeluaran berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return response()->json(['message' => 'Data pengeluaran berhasil dihapus']);
    }
}