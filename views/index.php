<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Food Health App | Hidup Sehat Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 70px;
            padding-bottom: 70px;
        }
        .nav-link { cursor: pointer; }
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.9s ease;
        }
        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
        .hero-overlay {
            background: rgba(0,0,0,0.55);
            color: #fff;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
        }
        .hero-text h1 { font-size: 3rem; }
        .icon-box {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            height: 100%;
        }
        .icon-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            background: #198754;
            color: #fff;
            margin-bottom: 15px;
        }
        .cta-box {
            background: linear-gradient(135deg, #198754, #20c997);
            color: #fff;
            border-radius: 20px;
            padding: 50px;
        }
    </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="70" tabindex="0">

<!-- NAVBAR -->
<nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#home">🥗 Food Health</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#healthy">Makanan Sehat</a></li>
        <li class="nav-item"><a class="nav-link" href="#nutrition">Nutrisi</a></li>
        <li class="nav-item"><a class="nav-link" href="#lifestyle">Gaya Hidup</a></li>
        <li class="nav-item"><a class="nav-link btn btn-light text-success ms-2" href="login.php">Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HOME -->
<section id="home" class="p-0">
  <div id="heroCarousel" class="carousel slide carousel-fade w-100" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active" style="background:url('https://images.unsplash.com/photo-1498837167922-ddd27525d352') center/cover no-repeat; height:100vh;">
        <div class="hero-overlay">
          <div class="container hero-text fade-in">
            <h1 class="fw-bold">Hidup Sehat Bukan Tren,<br>Tapi Kebutuhan</h1>
            <p class="lead mt-3">Mulai dari apa yang kamu makan hari ini. Kami bantu kamu melangkah perlahan menuju hidup lebih sehat.</p>
            <div class="mt-4">
              <a href="#healthy" class="btn btn-success btn-lg me-2">Pelajari Sekarang</a>
              <a href="register.php" class="btn btn-outline-light btn-lg">Mulai Gratis</a>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item" style="background:url('https://images.unsplash.com/photo-1506086679525-9b5c69b1b5b4') center/cover no-repeat; height:100vh;">
        <div class="hero-overlay">
          <div class="container hero-text">
            <h1 class="fw-bold">Mahasiswa Sehat,<br>Prestasi Meningkat</h1>
            <p class="lead">Tubuh yang sehat membantu fokus belajar dan produktivitas harian.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MAKANAN SEHAT -->
<section id="healthy" class="bg-light">
  <div class="container fade-in">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Makan Sehat Itu Bisa Dimulai dari Hal Kecil</h2>
      <p class="lead">Bukan soal mahal atau ribet, tapi soal konsistensi dan kesadaran.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="icon-box text-center">
          <div class="icon-circle mx-auto">🍚</div>
          <h5>Karbohidrat Seimbang</h5>
          <p>Pilih karbohidrat kompleks agar energi lebih tahan lama dan tidak cepat lelah.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box text-center">
          <div class="icon-circle mx-auto">🍳</div>
          <h5>Protein Harian</h5>
          <p>Protein membantu memperbaiki jaringan tubuh dan menjaga stamina.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box text-center">
          <div class="icon-circle mx-auto">🥦</div>
          <h5>Sayur & Buah</h5>
          <p>Sumber vitamin dan serat untuk daya tahan tubuh yang lebih baik.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- NUTRISI -->
<section id="nutrition">
  <div class="container fade-in">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Nutrisi yang Tepat Membentuk Versi Terbaik Dirimu</h2>
      <p class="lead">Apa yang kamu konsumsi hari ini akan memengaruhi fokus, energi, dan kesehatanmu ke depan.</p>
    </div>
    <div class="row align-items-center mb-5">
      <div class="col-md-6">
        <img src="https://images.unsplash.com/photo-1514996937319-344454492b37" class="img-fluid rounded shadow" alt="Nutrisi Seimbang">
      </div>
      <div class="col-md-6">
        <h4 class="fw-bold mb-3">Kenapa Nutrisi Itu Penting?</h4>
        <p class="fs-5">Tubuh manusia bekerja seperti sistem. Tanpa nutrisi yang seimbang, performa tubuh dan otak akan menurun.</p>
        <ul class="fs-5">
          <li>⚡ Energi stabil sepanjang hari</li>
          <li>🧠 Fokus belajar lebih lama</li>
          <li>💪 Daya tahan tubuh meningkat</li>
        </ul>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-md-3"><div class="icon-box text-center">🍞<h6 class="mt-3">Karbohidrat<br><small>Energi utama</small></h6></div></div>
      <div class="col-md-3"><div class="icon-box text-center">🥩<h6 class="mt-3">Protein<br><small>Pemulihan tubuh</small></h6></div></div>
      <div class="col-md-3"><div class="icon-box text-center">🥑<h6 class="mt-3">Lemak Sehat<br><small>Fungsi otak</small></h6></div></div>
      <div class="col-md-3"><div class="icon-box text-center">🥗<h6 class="mt-3">Serat<br><small>Pencernaan</small></h6></div></div>
    </div>
  </div>
</section>

<!-- GAYA HIDUP -->
<section id="lifestyle" class="bg-light">
  <div class="container fade-in">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Gaya Hidup Sehat Dimulai dari Kebiasaan Harian</h2>
      <p class="lead">Bukan perubahan besar, tapi konsistensi kecil yang dilakukan setiap hari.</p>
    </div>

    <div class="row align-items-center gy-4 mb-5">
      <div class="col-lg-6">
        <h4 class="fw-bold mb-3">Mahasiswa Sehat Lebih Siap Menghadapi Tantangan</h4>
        <p class="fs-5">Kuliah, tugas, dan aktivitas organisasi membutuhkan kondisi fisik dan mental yang prima.</p>
        <ul class="fs-5">
          <li>😴 Tidur cukup meningkatkan konsentrasi</li>
          <li>💧 Minum air menjaga metabolisme</li>
          <li>🏃 Bergerak aktif mengurangi stres</li>
        </ul>
      </div>
      <div class="col-lg-6 text-center">
        <img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773" class="img-fluid rounded shadow" alt="Gaya Hidup Sehat">
      </div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="icon-box text-center h-100">
          😴
          <h6 class="mt-3">Tidur Berkualitas</h6>
          <p>7–8 jam tidur membantu pemulihan tubuh dan stabilitas emosi.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box text-center h-100">
          💧
          <h6 class="mt-3">Hidrasi Cukup</h6>
          <p>Asupan cairan cukup menjaga fokus dan fungsi organ.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box text-center h-100">
          🏃
          <h6 class="mt-3">Aktif Bergerak</h6>
          <p>Aktivitas ringan rutin mampu menurunkan stres akademik.</p>
        </div>
      </div>
    </div>

    <div class="cta-box text-center">
      <h3 class="fw-bold mb-3">Saatnya Mengubah Kebiasaan, Bukan Sekadar Membaca</h3>
      <p class="mb-4 fs-5">Daftar sekarang dan jadikan hidup sehat sebagai bagian dari rutinitasmu.</p>
      <a href="register.php" class="btn btn-light btn-lg">Mulai Perjalanan Sehat</a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-success text-white text-center py-3">
  <p class="mb-0">© 2025 Food Health App | Edukasi Pola Hidup Sehat Mahasiswa</p>
</footer>

<script>
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
      }
    });
  }, { threshold: 0.2 });

  document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
