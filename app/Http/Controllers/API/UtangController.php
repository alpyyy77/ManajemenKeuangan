<?php

namespace App\Http\Controllers\Api;

use App\Models\Utang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Utwang",
 *     description="Manajemen data Utang"
 * )
 */
class UtangController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/utang",
     *      operationId="getUtangList",
     *      tags={"Utang"},
     *      summary="Menampilkan semua data utang",
     *      @OA\Response(
     *          response=200,
     *          description="Berhasil",
     *      )
     * )
     */
    public function index()
    {
        return response()->json(Utang::all(), 200);
    }

    /**
     * @OA\Post(
     *      path="/api/utang",
     *      operationId="storeUtang",
     *      tags={"Utang"},
     *      summary="Membuat data utang baru",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"tanggal","jumlah","kreditur","user_id"},
     *              @OA\Property(property="tanggal", type="string", format="date"),
     *              @OA\Property(property="catatan", type="string"),
     *              @OA\Property(property="jumlah", type="number", format="decimal"),
     *              @OA\Property(property="kreditur", type="string"),
     *              @OA\Property(property="user_id", type="integer")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Data utang berhasil dibuat",
     *      )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'kreditur' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $utang = Utang::create($validated);

        return response()->json($utang, 201);
    }

    /**
     * @OA\Get(
     *      path="/api/utang/{id}",
     *      operationId="getUtangById",
     *      tags={"Utang"},
     *      summary="Menampilkan detail utang berdasarkan ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID Utang",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Berhasil",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Tidak ditemukan",
     *      )
     * )
     */
    public function show($id)
    {
        $utang = Utang::find($id);
        if (!$utang) {
            return response()->json(['message' => 'Utang tidak ditemukan'], 404);
        }
        return response()->json($utang, 200);
    }

    /**
     * @OA\Put(
     *      path="/api/utang/{id}",
     *      operationId="updateUtang",
     *      tags={"Utang"},
     *      summary="Update data utang berdasarkan ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID Utang",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="tanggal", type="string", format="date"),
     *              @OA\Property(property="catatan", type="string"),
     *              @OA\Property(property="jumlah", type="number", format="decimal"),
     *              @OA\Property(property="kreditur", type="string"),
     *              @OA\Property(property="user_id", type="integer")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Berhasil diupdate",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Tidak ditemukan",
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $utang = Utang::find($id);
        if (!$utang) {
            return response()->json(['message' => 'Utang tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'tanggal' => 'sometimes|date',
            'catatan' => 'nullable|string',
            'jumlah' => 'sometimes|numeric',
            'kreditur' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $utang->update($validated);

        return response()->json($utang, 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/utang/{id}",
     *      operationId="deleteUtang",
     *      tags={"Utang"},
     *      summary="Hapus data utang berdasarkan ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID Utang",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Berhasil dihapus",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Tidak ditemukan",
     *      )
     * )
     */
    public function destroy($id)
    {
        $utang = Utang::find($id);
        if (!$utang) {
            return response()->json(['message' => 'Utang tidak ditemukan'], 404);
        }

        $utang->delete();

        return response()->json(['message' => 'Utang berhasil dihapus'], 200);
    }
}