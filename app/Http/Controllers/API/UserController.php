<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

/**
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints for Users"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Get all users",
     *     @OA\Response(
     *         response=200,
     *         description="List of users"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Get a single user with transactions",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User with transactions"
     *     )
     * )
     */
    public function show(User $user)
    {
        return response()->json($user->load('transactions'));
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Create a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password", minLength=6)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json($user, 201);
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Update a user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password", minLength=6)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully"
     *     )
     * )
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|min:6'
        ]);

        if ($request->has('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        $user->update($request->all());
        return response()->json($user);
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Delete a user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully"
     *     )
     * )
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
