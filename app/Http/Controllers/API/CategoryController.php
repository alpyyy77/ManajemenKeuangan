<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get all categories",
     *     tags={"Category"},
     *     operationId="getCategories",
     *     @OA\Response(
     *         response=200,
     *         description="List of categories retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Fiction")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Create a new category",
     *     tags={"Category"},
     *     operationId="createCategory",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Fiction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Fiction")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories']);
        $category = Category::create($request->only('name'));
        return response()->json($category, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Get a specific category by ID",
     *     tags={"Category"},
     *     operationId="getCategoryById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Fiction")
     *         )
     *     )
     * )
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Update a category",
     *     tags={"Category"},
     *     operationId="updateCategory",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Updated Fiction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Updated Fiction")
     *         )
     *     )
     * )
     */
    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|unique:categories,name,' . $category->id]);
        $category->update($request->only('name'));
        return response()->json($category);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Delete a category",
     *     tags={"Category"},
     *     operationId="deleteCategory",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Category deleted successfully")
     *         )
     *     )
     * )
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
