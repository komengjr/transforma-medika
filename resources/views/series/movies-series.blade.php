<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Retro Games Collection</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(180deg, #f2f2f2, #dcdcdc);
      color: #333;
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      background-color: #343a40 !important;
    }
    .navbar-brand {
      font-weight: bold;
      color: #f8f9fa !important;
    }
    .game-card {
      border: none;
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
      background-color: #fff;
    }
    .game-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    .game-card img {
      height: 220px;
      object-fit: cover;
    }
    .card-body {
      padding: 15px;
    }
    .btn-detail {
      background-color: #555;
      color: #fff;
      border-radius: 8px;
      transition: 0.3s;
    }
    .btn-detail:hover {
      background-color: #333;
    }
    footer {
      text-align: center;
      margin-top: 50px;
      padding: 20px 0;
      background-color: #343a40;
      color: #fff;
    }
    .filter-bar {
      margin-bottom: 30px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">🕹️ Retro Games Collection</a>
    </div>
  </nav>

  <div class="container py-5">
    <h2 class="text-center mb-4">Koleksi Game Retro Berdasarkan Platform</h2>

    <!-- Filter -->
    <div class="filter-bar text-center mb-4">
      <select id="platformFilter" class="form-select w-auto d-inline-block">
        <option value="all">Semua Platform</option>
        <option value="ps1">PlayStation 1</option>
        <option value="ps2">PlayStation 2</option>
        <option value="ps3">PlayStation 3</option>
        <option value="ps4">PlayStation 4</option>
        <option value="pc">PC</option>
        <option value="ppsspp">PPSSPP (PSP)</option>
      </select>
    </div>

    <div class="row g-4" id="gameList"></div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      <nav>
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
        </ul>
      </nav>
    </div>
  </div>

  <footer>
    &copy; 2025 Retro Games & Apps | All Rights Reserved
  </footer>

  <script>
    const games = [
      // 🎮 PS1
      { id: 1, title: "Crash Bandicoot", platform: "ps1", image: "https://upload.wikimedia.org/wikipedia/en/8/8b/Crash_Bandicoot_Cover.png", description: "Petualangan ikonik dari Naughty Dog di konsol PS1." },
      { id: 2, title: "Resident Evil 2", platform: "ps1", image: "https://upload.wikimedia.org/wikipedia/en/3/3d/Resident_Evil_2_Cover_Art.jpg", description: "Game survival horror klasik yang memperkenalkan Leon S. Kennedy." },

      // 🎮 PS2
      { id: 3, title: "God of War II", platform: "ps2", image: "https://upload.wikimedia.org/wikipedia/en/1/15/God_of_War_II_cover.jpg", description: "Kratos kembali dengan petualangan penuh aksi di mitologi Yunani." },
      { id: 4, title: "GTA: San Andreas", platform: "ps2", image: "https://upload.wikimedia.org/wikipedia/en/c/c4/GTASABOX.jpg", description: "Game open-world legendaris dengan kisah Carl Johnson di Los Santos." },

      // 🎮 PS3
      { id: 5, title: "Uncharted 2", platform: "ps3", image: "https://upload.wikimedia.org/wikipedia/en/b/bd/Uncharted_2_box_artwork.png", description: "Petualangan epik Nathan Drake dalam dunia pencarian harta karun." },
      { id: 6, title: "The Last of Us", platform: "ps3", image: "https://upload.wikimedia.org/wikipedia/en/8/8b/The_Last_of_Us_cover.jpg", description: "Game post-apocalyptic dengan kisah mendalam antara Joel dan Ellie." },

      // 🎮 PS4
      { id: 7, title: "God of War (2018)", platform: "ps4", image: "https://upload.wikimedia.org/wikipedia/en/a/a7/God_of_War_4_cover.jpg", description: "Kratos kembali, kini dengan atmosfer Norse dan kisah tentang ayah dan anak." },
      { id: 8, title: "Spider-Man PS4", platform: "ps4", image: "https://upload.wikimedia.org/wikipedia/en/8/8e/Spider-Man_PS4_cover.jpg", description: "Rasakan sensasi menjadi Spider-Man di dunia terbuka New York." },

      // 💻 PC
      { id: 9, title: "Half-Life 2", platform: "pc", image: "https://upload.wikimedia.org/wikipedia/en/2/25/Half-Life_2_cover.jpg", description: "FPS revolusioner dengan grafis dan fisika yang inovatif." },
      { id: 10, title: "StarCraft", platform: "pc", image: "https://upload.wikimedia.org/wikipedia/en/9/9c/StarCraft_box_art.jpg", description: "Game strategi real-time legendaris yang mendunia." },

      // 🎮 PPSSPP
      { id: 11, title: "God of War: Chains of Olympus", platform: "ppsspp", image: "https://upload.wikimedia.org/wikipedia/en/3/33/God_of_War_Chains_of_Olympus_cover.jpg", description: "Petualangan Kratos di PSP dengan aksi brutal khas GoW." },
      { id: 12, title: "Crisis Core: Final Fantasy VII", platform: "ppsspp", image: "https://upload.wikimedia.org/wikipedia/en/6/6a/Crisis_Core_Final_Fantasy_VII_Box_Art.jpg", description: "Prekuel dari Final Fantasy VII dengan kisah tragis Zack Fair." },
    ];

    const gameList = document.getElementById('gameList');
    const platformFilter = document.getElementById('platformFilter');

    function renderGames(platform = "all") {
      gameList.innerHTML = "";
      const filtered = platform === "all" ? games : games.filter(g => g.platform === platform);
      filtered.forEach(game => {
        const col = document.createElement('div');
        col.className = 'col-md-3';
        col.innerHTML = `
          <div class="card game-card">
            <img src="${game.image}" class="card-img-top" alt="${game.title}">
            <div class="card-body">
              <h6 class="card-title">${game.title}</h6>
              <span class="badge bg-secondary text-light">${game.platform.toUpperCase()}</span>
              <button class="btn btn-detail w-100 mt-2" onclick="showDetail(${game.id})">Lihat Detail</button>
            </div>
          </div>
        `;
        gameList.appendChild(col);
      });
    }

    platformFilter.addEventListener('change', (e) => {
      renderGames(e.target.value);
    });

    function showDetail(id) {
      const game = games.find(g => g.id === id);
      localStorage.setItem('selectedGame', JSON.stringify(game));
      window.location.href = 'retro-detail.html';
    }

    // Render awal
    renderGames();
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
