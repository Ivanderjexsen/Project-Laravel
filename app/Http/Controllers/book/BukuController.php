<?php

namespace App\Http\Controllers\book;

use App\Models\Buku;
use App\Http\Controllers\Controller;
use App\Services\OpenLibraryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    protected OpenLibraryService $openLibrary;

    public function __construct(OpenLibraryService $openLibrary)
    {
        $this->openLibrary = $openLibrary;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        if ($keyword) {
            $bukus = Buku::search($keyword)->paginate(10);
        } else {
            $bukus = Buku::orderBy('created_at', 'desc')->paginate(10);
        }

        return view('admin.books.index', compact('bukus', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku' => 'required|string|max:255',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (Buku::isBukuExists($request->judul_buku, $request->pengarang, $request->penerbit)) {
            return redirect()->back()
                ->with('error', 'Buku dengan judul "' . $request->judul_buku . '" oleh "' . $request->pengarang . '" dan penerbit "' . $request->penerbit . '" sudah ada di database!')
                ->withInput();
        }

        Buku::create($validator->validated());

        return redirect()->route('buku.index')
            ->with('success', "Buku '{$request->judul_buku}' berhasil ditambahkan!");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.books.detail', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.books.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku' => 'required|string|max:255',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'stok' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $buku = Buku::findOrFail($id);

        // CEK DUPLIKAT
        if (Buku::isBukuExists($request->judul_buku, $request->pengarang, $request->penerbit, $id)) {
            return redirect()->back()
                ->with('error', 'Buku dengan judul "' . $request->judul_buku . '" oleh "' . $request->pengarang . '" sudah ada di database!')
                ->withInput();
        }

        $buku->update($request->all());

        return redirect()->route('buku.index')
            ->with('success', "Buku '{$buku->judul_buku}' berhasil diperbarui!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $judul = $buku->judul_buku;
        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', "Buku '{$judul}' berhasil dihapus!");
    }

    /**
     * Search books from OpenLibrary API
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (strlen($query) < 2) {
            return response()->json(['docs' => []]);
        }

        // Panggil service OpenLibrary
        $result = $this->openLibrary->searchBooks($query, 5);

        return response()->json($result);
    }
}
