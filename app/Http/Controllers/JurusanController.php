<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        return view('jurusan.index', ['jurusan' => Jurusan::all()]);
    }
    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        $v = $request->validate(['kode' => 'required|unique:jurusan', 'nama' => 'required', 'deskripsi' => 'nullable']);
        Jurusan::create($v);
        return redirect()->route('jurusan.index')->with('success', 'Jurusan ditambahkan.');
    }

    public function show(Jurusan $jurusan)
    {
        return redirect()->route('jurusan.index');
    }
    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $jurusan->update($request->validate(['kode' => 'required|unique:jurusan,kode,' . $jurusan->id, 'nama' => 'required', 'deskripsi' => 'nullable']));
        return redirect()->route('jurusan.index')->with('success', 'Jurusan diupdate.');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return redirect()->route('jurusan.index')->with('success', 'Jurusan dihapus.');
    }
}
