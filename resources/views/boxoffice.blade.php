<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Box Office | {{ env('APP_LABEL') }} Stream</title>
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232"
        crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="{{ asset('img/box-office.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #0c0c0c;
            color: #f8f8f8;
            font-family: "Poppins", sans-serif;
            overflow-x: hidden;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.4);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            padding: 0.7rem 2rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: #d4af37 !important;
            font-size: 1.7rem;
            letter-spacing: 1px;
            text-shadow: 0 0 6px rgba(212, 175, 55, 0.5);
        }

        .navbar-nav .nav-link {
            color: #f1f1f1 !important;
            margin-right: 1.5rem;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #d4af37 !important;
        }

        .search-box {
            position: relative;
            width: 250px;
        }

        .search-box input {
            background-color: #1a1a1a;
            color: #fff;
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 20px;
            padding: 0.4rem 2.5rem 0.4rem 1rem;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            background-color: #000;
            border-color: #d4af37;
            outline: none;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
        }

        .search-box i {
            position: absolute;
            right: 12px;
            top: 8px;
            color: #d4af37;
        }

        .hero {
            margin-top: 65px;
            position: relative;
            height: 65vh;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), #0c0c0c),
                url("{{ asset('img/box.jpg') }}") center/cover no-repeat;
            display: flex;
            align-items: flex-end;
            padding: 4rem;
            margin-bottom: 2rem;
        }

        .hero-content {
            max-width: 600px;
            animation: fadeInUp 1s ease;
        }

        .hero h1 {
            font-size: 3rem;
            color: #d4af37;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
        }

        .hero p {
            color: #ccc;
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .btn-watch {
            background: #d4af37;
            color: #000;
            border: none;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            border-radius: 6px;
            margin-top: 1.2rem;
            transition: 0.3s;
        }

        .btn-watch:hover {
            background: #f2ce5e;
            transform: scale(1.05);
        }

        .section-title {
            color: #d4af37;
            font-weight: 600;
            font-size: 1.5rem;
            margin: 2rem 0 1rem 2rem;
            text-transform: uppercase;
            border-left: 4px solid #d4af37;
            padding-left: 10px;
        }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
            gap: 1.5rem;
            padding: 0 2rem 3rem;
        }

        .movie-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #111;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .movie-card img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .movie-card:hover img {
            filter: brightness(1.1);
            transform: scale(1.05);
        }

        .movie-overlay {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
            padding: 0.8rem;
        }

        .movie-title {
            font-size: 1rem;
            font-weight: 600;
            color: #d4af37;
        }

        .movie-info {
            font-size: 0.85rem;
            color: #bbb;
        }

        footer {
            text-align: center;
            color: #aaa;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
            padding: 1rem;
            font-size: 0.9rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pagination .page-link {
            background-color: #111;
            color: #d4af37;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .pagination .page-link:hover {
            background-color: #d4af37;
            color: #000;
        }

        .pagination .active .page-link {
            background-color: #d4af37;
            color: #000;
            border-color: #d4af37;
        }

        /* Search result dropdown */
        .search-results {
            position: absolute;
            top: 40px;
            left: 0;
            width: 100%;
            background-color: #111;
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 10px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 200;
            display: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
        }

        .search-result-item {
            padding: 10px 15px;
            color: #f1f1f1;
            cursor: pointer;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.2s;
        }

        .search-result-item img {
            width: 40px;
            height: 55px;
            object-fit: cover;
            border-radius: 5px;
        }

        .search-result-item:hover {
            background-color: rgba(212, 175, 55, 0.1);
            color: #d4af37;
        }

        /* 🌟 Animasi dropdown */
        .dropdown-menu {
            display: block;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Hover efek item */
        .dropdown-item {
            transition: all 0.25s ease;
        }

        .dropdown-item:hover {
            background-color: #198754;
            color: #fff;
            transform: translateX(5px);
        }

        /* 🌈 Search box */
        .search-box {
            position: relative;
            width: 220px;
        }

        .search-box input {
            border-radius: 30px;
            padding-right: 35px;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            box-shadow: 0 0 10px rgba(25, 135, 84, 0.4);
            border-color: #198754;
        }

        .bi-search {
            cursor: pointer;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #aaa;
            transition: all 0.2s ease;
        }

        .bi-search:hover {
            color: #198754;
            transform: translateY(-50%) scale(1.1);
        }

        /* 🌙 Responsif untuk mobile */
        @media (max-width: 991px) {
            .navbar-nav {
                text-align: center;
            }

            .search-box {
                width: 100%;
                margin-top: 10px;
            }

            /* 🌟 Dropdown auto fit layar */
            .dropdown-menu {
                background-color: #212529;
                border: none;
                max-height: calc(100vh - 180px);
                overflow-y: auto;
                margin-bottom: 10px;
                scrollbar-width: thin;
                display: none;
                /* tertutup default */
            }

            .dropdown-menu.active {
                display: block;
                /* tampil ketika aktif */
            }

            .dropdown-item {
                color: #ddd;
            }

            .dropdown-item:hover {
                background-color: #198754;
                color: #fff;
                transform: none;
            }

            /* Scrollbar halus */
            .dropdown-menu::-webkit-scrollbar {
                width: 6px;
            }

            .dropdown-menu::-webkit-scrollbar-thumb {
                background-color: #198754;
                border-radius: 3px;
            }

            .dropdown-menu::-webkit-scrollbar-track {
                background: transparent;
            }
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">🎬 {{ env('APP_LABEL') }} Movie</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('live.tv')}}">Nonton Tv</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Coming Soon</a>
                    </li>

                    <!-- Dropdown Genre -->
                    <li class="nav-item dropdown dropdown-animate">
                        <a class="nav-link dropdown-toggle" href="#" id="genreDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Genre
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="genreDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Comedy</a></li>
                            <li><a class="dropdown-item" href="#">Drama</a></li>
                            <li><a class="dropdown-item" href="#">Horror</a></li>
                            <li><a class="dropdown-item" href="#">Romance</a></li>
                            <li><a class="dropdown-item" href="#">Sci-Fi</a></li>
                            <li><a class="dropdown-item" href="#">Animation</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Tahun -->
                    <li class="nav-item dropdown dropdown-animate">
                        <a class="nav-link dropdown-toggle" href="#" id="yearDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Tahun
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="yearDropdown">
                            @for ($year = date('Y'); $year >= 2024; $year--)
                                <li><a class="dropdown-item" href="#">{{ $year }}</a></li>
                            @endfor
                        </ul>
                    </li>
                </ul>

                <!-- Search Box -->
                <div class="search-box position-relative">
                    <input id="searchInput" class="form-control" type="text" placeholder="Search movies...">
                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-secondary"></i>
                    <div id="searchResults" class="search-results"></div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Innoventra Box Office</h1>
            <p>Make sure the connection and network are smooth because the quality of the film is Full HD and above..
            </p>
            <a href="#" onclick="window.open('https://saweria.co/agusraharjo', '_blank').focus();"
                class="btn btn-watch">
                <i class="bi bi-play-fill me-2"></i>Subscribe Now
            </a>
        </div>
    </section>

    <!-- Now Showing -->
    <h3 class="section-title">Now Showing</h3>

    <div class="movie-grid" id="movieGrid">
        @foreach($movies as $movie)
            <a href="{{ route('movies.show', $movie) }}" class="movie-card text-decoration-none movie-item"
                data-title="{{ strtolower($movie->title) }}">
                <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" loading="lazy">
                <div class="movie-overlay">
                    <div class="movie-title">{{ $movie->title }}</div>
                    <div class="movie-info">🎬 {{ Str::limit($movie->description, 60) }}</div>
                </div>
            </a>
        @endforeach
    </div>
    @php
        $no = mt_rand(100000000, 9999999999)
    @endphp
    <!-- Pagination -->
    <div class="d-flex justify-content-center mb-5">
        {{ $movies->links('pagination::bootstrap-4') }}
    </div>
    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4154628728879232" data-ad-slot="{{$no}}"
        data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <!-- Coming Soon -->
    <!-- <h3 class="section-title">Coming Soon</h3>
    <div class="movie-grid">
        @foreach($movies->shuffle()->take(4) as $movie)
            <div class="movie-card">
                <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" loading="lazy">
                <div class="movie-overlay">
                    <div class="movie-title">{{ $movie->title }}</div>
                    <div class="movie-info">Coming this month</div>
                </div>
            </div>
        @endforeach
    </div> -->

    <footer>
        {{ env('APP_LABEL') }} Box Office &copy; {{ date('Y') }} — Enjoy Cinema at Home 🍿
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        // Ambil data movie dari elemen HTML (dibuat dari Blade)
        const movies = Array.from(document.querySelectorAll('.movie-item')).map(item => ({
            id: item.getAttribute('href').split('/').pop(),
            title: item.querySelector('.movie-title').innerText,
            poster: item.querySelector('img').src,
            description: item.querySelector('.movie-info').innerText
        }));

        // Ketika user mengetik
        searchInput.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();
            searchResults.innerHTML = '';

            if (term === '') {
                searchResults.style.display = 'none';
                return;
            }

            // Filter hasil pencarian
            const filtered = movies.filter(movie =>
                movie.title.toLowerCase().includes(term)
            );

            if (filtered.length === 0) {
                searchResults.innerHTML = '<div class="p-3 text-center text-muted">No results found</div>';
            } else {
                filtered.forEach(movie => {
                    const item = document.createElement('div');
                    item.classList.add('search-result-item');
                    item.innerHTML = `
                    <img src="${movie.poster}" alt="${movie.title}">
                    <div>
                        <div style="font-weight:600;color:#d4af37;">${movie.title}</div>
                        <div style="font-size:0.8rem;color:#aaa;">${movie.description.substring(0, 50)}...</div>
                    </div>
                `;
                    item.addEventListener('click', () => {
                        window.location.href = '/movie/' + movie.id;
                    });
                    searchResults.appendChild(item);
                });
            }

            searchResults.style.display = 'block';
        });

        // Tutup dropdown ketika klik di luar
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
    </script>
    <script>
        function isMobile() {
            return window.innerWidth <= 991;
        }

        document.querySelectorAll('.nav-item.dropdown').forEach(drop => {
            const toggle = drop.querySelector('.dropdown-toggle');
            const menu = drop.querySelector('.dropdown-menu');

            toggle.addEventListener('click', (e) => {
                if (isMobile()) {
                    e.preventDefault();

                    // Tutup semua dropdown lain
                    document.querySelectorAll('.dropdown-menu.active').forEach(other => {
                        if (other !== menu) other.classList.remove('active');
                    });

                    // Toggle aktif
                    menu.classList.toggle('active');
                }
            });
        });

        // Jika resize ke desktop → reset semua state dropdown
        window.addEventListener('resize', () => {
            if (!isMobile()) {
                document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('active'));
            }
        });

    </script>

</body>

</html>
