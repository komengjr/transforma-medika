<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // =========================================================================
    // ROUTE PUBLIK (PENGUNJUNG)
    // =========================================================================

    /**
     * Menampilkan daftar semua artikel/blog (Beranda Blog)
     */
    public function index()
    {
        // Mengambil data blog terbaru, gunakan paginate agar tidak berat jika data banyak
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(9);

        // Return ke view 'blog.index' (silakan buat file view ini nanti)
        return view('blog.index', compact('blogs'));
    }

    /**
     * Menampilkan detail artikel berdasarkan slug dan menambah jumlah view
     */
    public function show($slug)
    {
        // Cari blog berdasarkan slug, jika tidak ada tampilkan 404
        $blog = Blog::where('slug', $slug)->firstOrFail();

        // Tambahkan 1 ke jumlah views setiap kali halaman ini diakses
        $blog->increment('views');

        // Ambil komentar yang statusnya 'approved' dari yang paling baru
        $comments = $blog->comments()->where('status', 'approved')->orderBy('created_at', 'desc')->get();

        // Return ke view 'blog.detail'
        return view('blog.detail', compact('blog', 'comments'));
    }

    /**
     * Menyimpan komentar dari pengunjung
     */
    public function storeComment(Request $request, $slug)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|string'
        ]);

        // Cari blog yang dikomentari
        $blog = Blog::where('slug', $slug)->firstOrFail();

        // Simpan komentar ke database (default status: 'approved' berdasarkan migration)
        // Jika Anda ingin moderasi, bisa ubah default di migration menjadi 'pending'
        Comment::create([
            'blog_id' => $blog->id,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'status' => 'approved',
        ]);

        // Redirect kembali ke halaman blog dengan pesan sukses
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }


    // =========================================================================
    // ROUTE ADMIN (MANAJEMEN KONTEN)
    // =========================================================================

    /**
     * Menampilkan form tambah artikel baru untuk Admin
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Menyimpan artikel baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            // Ini akan otomatis menyimpan file ke: storage/app/blogs
            // Dan mengembalikan path-nya, contoh: "blogs/namafileacak.jpg"
            $thumbnailPath = $request->file('thumbnail')->store('blogs');
        }

        Blog::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'thumbnail' => $thumbnailPath,
        ]);

        return redirect()->route('admin.blog.create')->with('success', 'Artikel berhasil dipublikasikan!');
    }
    /**
     * Menampilkan gambar dari storage/app/blogs
     */
    public function showImage($filename)
    {
        // Arahkan ke path storage/app/blogs
        $path = storage_path('app/blogs/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        // Tampilkan file sebagai response gambar
        return response()->file($path);
    }
}
