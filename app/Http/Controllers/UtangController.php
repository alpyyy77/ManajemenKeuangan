<?php

namespace App\Http\Controllers;

use App\Models\Utang;
use Illuminate\Http\Request;

class UtangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $utangs = Utang::with('user')->get();
        return response()->json($utangs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Jika API, biasanya tidak perlu create form.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'kreditur' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $utang = Utang::create($request->all());

        return response()->json($utang, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $utang = Utang::with('user')->findOrFail($id);
        return response()->json($utang);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Jika API, biasanya tidak perlu edit form.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'kreditur' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $utang = Utang::findOrFail($id);
        $utang->update($request->all());

        return response()->json($utang);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $utang = Utang::findOrFail($id);
        $utang->delete();

        return response()->json(['message' => 'Utang deleted']);
    }
}
