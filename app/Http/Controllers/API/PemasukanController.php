<?php
namespace App\Http\Controllers\API;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Pemasukan",
 *     description="API Endpoints for Pemasukan"
 * )
 */
class PemasukanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pemasukan",
     *     tags={"Pemasukan"},
     *     summary="Get list of pemasukan",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Pemasukan::with('user')->get());
    }

    /**
     * @OA\Post(
     *     path="/api/pemasukan",
     *     tags={"Pemasukan"},
     *     summary="Create a new pemasukan",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "jumlah", "tanggal"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="tanggal", type="string", format="date"),
     *             @OA\Property(property="catatan", type="string"),
     *             @OA\Property(property="jumlah", type="number", format="float"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pemasukan created"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'status' => 'nullable|string',
        ]);

        $pemasukan = Pemasukan::create($request->all());
        return response()->json($pemasukan, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/pemasukan/{id}",
     *     tags={"Pemasukan"},
     *     summary="Get a single pemasukan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function show(Pemasukan $pemasukan)
    {
        return response()->json($pemasukan->load('user'));
    }

    /**
     * @OA\Put(
     *     path="/api/pemasukan/{id}",
     *     tags={"Pemasukan"},
     *     summary="Update pemasukan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="tanggal", type="string", format="date"),
     *             @OA\Property(property="catatan", type="string"),
     *             @OA\Property(property="jumlah", type="number", format="float"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pemasukan updated"
     *     )
     * )
     */
    public function update(Request $request, Pemasukan $pemasukan)
    {
        $request->validate([
            'tanggal' => 'date',
            'jumlah' => 'numeric',
            'status' => 'nullable|string',
        ]);

        $pemasukan->update($request->all());
        return response()->json($pemasukan);
    }

    /**
     * @OA\Delete(
     *     path="/api/pemasukan/{id}",
     *     tags={"Pemasukan"},
     *     summary="Delete pemasukan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pemasukan deleted"
     *     )
     * )
     */
    public function destroy(Pemasukan $pemasukan)
    {
        $pemasukan->delete();
        return response()->json(['message' => 'Pemasukan deleted successfully']);
    }
}
