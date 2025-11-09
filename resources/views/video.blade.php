<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Box Office | StreamFlix</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #141414;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
    }
    .navbar {
      background: rgba(0,0,0,0.8);
      padding: 1rem 2rem;
    }
    .navbar-brand {
      font-weight: bold;
      color: #e50914 !important;
      font-size: 1.5rem;
    }
    .movie-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 1rem;
      padding: 2rem;
    }
    .movie-card {
      position: relative;
      border-radius: 10px;
      overflow: hidden;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .movie-card:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 25px rgba(255, 255, 255, 0.1);
    }
    .movie-card img {
      width: 100%;
      height: 270px;
      object-fit: cover;
    }
    .movie-overlay {
      position: absolute;
      bottom: 0;
      width: 100%;
      background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
      padding: 0.7rem;
    }
    .movie-title {
      font-size: 0.9rem;
      font-weight: 600;
    }
    .modal-content {
      background-color: #000;
      border: none;
    }
    video {
      width: 100%;
      border-radius: 8px;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-dark">
    <a class="navbar-brand" href="#">StreamFlix</a>
  </nav>

  <div class="container-fluid">
    <h3 class="mt-4 px-4">🎥 Box Office</h3>
    <div class="movie-grid">
      <!-- Daftar Film -->
      @php
        $movies = [
          ['title' => 'Avengers: Endgame', 'poster' => 'https://image.tmdb.org/t/p/w500/ulzhLuWrPK07P1YkdWQLZnQh1JL.jpg', 'file' => 'sample.mp4'],
          ['title' => 'The Batman', 'poster' => 'https://image.tmdb.org/t/p/w500/74xTEgt7R36Fpooo50r9T25onhq.jpg', 'file' => 'sample.mp4'],
          ['title' => 'Interstellar', 'poster' => 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg', 'file' => 'sample.mp4'],
          ['title' => 'Inception', 'poster' => 'https://image.tmdb.org/t/p/w500/qmDpIHrmpJINaRKAfWQfftjCdyi.jpg', 'file' => 'sample.mp4'],
          ['title' => 'Dune', 'poster' => 'https://image.tmdb.org/t/p/w500/d5NXSklXo0qyIYkgV94XAgMIckC.jpg', 'file' => 'sample.mp4'],
        ];
      @endphp

      @foreach($movies as $movie)
        <div class="movie-card" onclick="playMovie('{{ url('/video/'.$movie['file']) }}', '{{ $movie['title'] }}')">
          <img src="{{ $movie['poster'] }}" alt="{{ $movie['title'] }}">
          <div class="movie-overlay">
            <div class="movie-title">{{ $movie['title'] }}</div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Modal Player -->
  <div class="modal fade" id="playerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="movieTitle"></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <video id="videoPlayer" controls autoplay>
            <source id="videoSource" src="" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const playerModal = new bootstrap.Modal(document.getElementById('playerModal'));

    function playMovie(src, title) {
      const video = document.getElementById('videoPlayer');
      const source = document.getElementById('videoSource');
      document.getElementById('movieTitle').innerText = title;

      source.src = src;
      video.load();
      playerModal.show();
      video.play();
    }
  </script>
</body>
</html>
