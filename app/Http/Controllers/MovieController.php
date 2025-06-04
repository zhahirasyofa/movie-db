<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MovieController extends Controller
{
    public function index()
    {
        // $movies = Movie::latest() memanggil semua
        $movies = Movie::latest()->paginate(6); // Ambil 6 film terbaru
        return view('homepage', compact('movies'));
        // return view('homepage, ['movie'-> $movies]);
    }

    public function detail_movie($id, $slug)
    {
        $movie = Movie::find($id);
        return view('movie_detail', compact('movie'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('movie_form', compact('categories'));
    }
    public function store(Request $request)
    {
        // Proses upload cover
        $cover = $request->file('cover_image');
        $namaFileCover = time() . '_' . $cover->getClientOriginalName();
        $cover->move(public_path('covers'), $namaFileCover);

        Movie::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'synopsis' => $request->synopsis,
            'category_id' => $request->category_id,
            'year' => $request->year,
            'actors' => $request->actors,
            'cover_image' => 'covers/' . $namaFileCover, // simpan folder + nama file
        ]);

        return redirect('/')->with('success', 'Movie berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:movies,slug,' . $id,
            'synopsis' => 'nullable|string',
            'category_id' => 'required|integer',
            'year' => 'required|integer',
            'actors' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $movie = Movie::findOrFail($id);
        $movie->title = $request->title;
        $movie->slug = $request->slug;
        $movie->synopsis = $request->synopsis;
        $movie->category_id = $request->category_id;
        $movie->year = $request->year;
        $movie->actors = $request->actors;

        if ($request->hasFile('cover_image')) {
            $oldPath = public_path('covers/' . $movie->cover_image);

            if ($movie->cover_image && file_exists($oldPath)) {
                unlink($oldPath);
            }

            // Simpan file baru (opsional, jika bagian ini belum kamu buat)
            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('covers'), $filename);

            // Simpan nama file ke database
            $movie->cover_image = $filename;
        }

        $movie->save();

        return redirect()->route('admin.movies.list')->with('success', 'Movie updated successfully!');
    }

    public function showMovies()
    {
        $movies = Movie::with('category')->paginate(10);
        $categories = Category::all();
        return view('admin.list_movie', compact('movies', 'categories'));
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.edit_movie', compact('movie'));
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);

        // Hapus file cover_image jika ada
        if ($movie->cover_image) {
            $coverPath = public_path('covers/' . $movie->cover_image);

            if (file_exists($coverPath)) {
                unlink($coverPath);
            }
        }

        // Hapus data dari database
        $movie->delete();

        return redirect()->route('admin.movies.list')->with('success', 'Data film berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Query pencarian berdasarkan title
        $movies = Movie::where('title', 'LIKE', "%{$query}%")->paginate(6);

        return view('homepage', compact('movies'));
    }
}
