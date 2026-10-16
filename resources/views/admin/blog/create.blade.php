<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artikel / Informasi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <!-- Library CKEditor 5 untuk Rich Text Editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'PT Sans', sans-serif;
        }

        /* Modifikasi tampilan CKEditor agar menyatu dengan desain Tailwind */
        .ck-editor__editable_inline {
            min-height: 300px;
            border-bottom-left-radius: 0.75rem !important;
            border-bottom-right-radius: 0.75rem !important;
        }

        .ck.ck-toolbar {
            border-top-left-radius: 0.75rem !important;
            border-top-right-radius: 0.75rem !important;
            background-color: #f8fafc !important;
        }
    </style>
</head>

<body class="bg-zinc-50 text-zinc-900">

    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="mb-8">
            <a href="/admin/dashboard" class="text-sm text-sky-600 hover:underline">← Kembali ke Dashboard</a>
            <h1 class="font-display font-bold text-3xl mt-4">Tulis Informasi Baru</h1>
            <p class="text-zinc-500 mt-2">Tambahkan artikel, berita, atau pembaruan informasi sistem.</p>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-zinc-200">
            <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-zinc-700 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" required placeholder="Masukkan judul yang menarik..."
                        class="w-full border border-zinc-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-colors">
                </div>

                <!-- Thumbnail/Gambar -->
                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-zinc-700 mb-2">Gambar Utama (Thumbnail)</label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                        class="w-full border border-zinc-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-sky-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                </div>

                <!-- Konten Blog -->
                <div>
                    <label for="content" class="block text-sm font-medium text-zinc-700 mb-2">Isi Konten <span class="text-red-500">*</span></label>
                    <!-- Atribut 'required' dilepas di HTML karena validasi akan ditangani oleh sistem backend / CKEditor -->
                    <textarea id="content" name="content" placeholder="Tuliskan isi informasi di sini..."></textarea>
                </div>

                <div class="flex justify-end pt-4 border-t border-zinc-100">
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-medium px-8 py-3 rounded-xl shadow-md transition-colors">
                        Publikasikan Informasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Inisialisasi CKEditor -->
    <script>
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>
