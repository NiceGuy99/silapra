<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officers = Officer::all();
        return view('officers.index', compact('officers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Officer::create([
            'name' => $request->name,
            'is_active' => true,
        ]);

        return redirect()->route('officers.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Officer $officer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $officer->update([
            'name' => $request->name,
        ]);

        return redirect()->route('officers.index')->with('success', 'Petugas berhasil diupdate.');
    }

    /**
     * Toggle officer active status.
     */
    public function toggleStatus(Officer $officer)
    {
        $officer->update([
            'is_active' => !$officer->is_active,
        ]);

        $status = $officer->is_active ? 'aktif' : 'non-aktif';
        return redirect()->route('officers.index')->with('success', "Status petugas berhasil diubah menjadi {$status}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Officer $officer)
    {
        $officer->delete();
        return redirect()->route('officers.index')->with('success', 'Petugas berhasil dihapus.');
    }
}
