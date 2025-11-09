<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">

    <title>Box Office | {{env('APP_LABEL')}} Stream</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #0c0c0c;
            color: #f8f8f8;
            font-family: "Poppins", sans-serif;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(180deg, #000 80%, transparent);
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10;
        }

        .navbar-brand {
            font-weight: 700;
            color: #d4af37 !important;
            font-size: 1.8rem;
            letter-spacing: 1px;
        }

        /* Hero */
        .hero {
            position: relative;
            height: 75vh;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), #0c0c0c),
                url('https://media.istockphoto.com/id/185077766/photo/new-york-city-box-office.jpg?s=612x612&w=0&k=20&c=-kY5d-ObcSsyQhvOOzhXSLWO1RTPcGwTFKecHhuktIw=') center/cover no-repeat;
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

        /* Section title */
        .section-title {
            color: #d4af37;
            font-weight: 600;
            font-size: 1.5rem;
            margin: 2rem 0 1rem 2rem;
            text-transform: uppercase;
            border-left: 4px solid #d4af37;
            padding-left: 10px;
        }

        /* Movie grid */
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

        /* Animation */
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

        footer {
            text-align: center;
            color: #aaa;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
            padding: 1rem;
            font-size: 0.9rem;
        }
    </style>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232"
        crossorigin="anonymous"></script>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark px-4">
        <a class="navbar-brand" href="#">🎞 {{env('APP_LABEL')}} Box Office</a>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>Now Showing</h1>
            <p>Experience cinematic magic — watch top box office movies streaming exclusively here.</p>
            <a href="{{ route('movies.show', 1) }}" class="btn btn-watch"><i class="bi bi-play-fill me-2"></i>Watch
                Trailer</a>
        </div>
    </section>

    <!-- Now Showing -->
    <h3 class="section-title">Now Showing</h3>
    <div class="movie-grid">
        @foreach($movies as $movie)
            <a href="{{ route('movies.show', $movie) }}" class="movie-card text-decoration-none">
                <img src="{{ $movie->poster }}" alt="{{ $movie->title }}">
                <div class="movie-overlay">
                    <div class="movie-title">{{ $movie->title }}</div>
                    <div class="movie-info">🎬 {{ Str::limit($movie->description, 60) }}</div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Coming Soon -->
    <h3 class="section-title">Coming Soon</h3>
    <div class="movie-grid">
        @foreach($movies->shuffle()->take(4) as $movie)
            <div class="movie-card">
                <img src="{{ $movie->poster }}" alt="{{ $movie->title }}">
                <div class="movie-overlay">
                    <div class="movie-title">{{ $movie->title }}</div>
                    <div class="movie-info">Coming this month</div>
                </div>
            </div>
        @endforeach
    </div>

    <footer>
        {{env('APP_LABEL')}} Box Office &copy; {{ date('Y') }} — Enjoy Cinema at Home 🍿
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
