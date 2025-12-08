<?php include('partial/header.php'); ?>

<!-- NAVBAR TOP LIKE NETFLIX -->
<nav class="position-absolute top-0 w-100 d-flex justify-content-end p-3" style="z-index:10;">
    <a href="auth-login.php" class="btn btn-danger px-4 fw-semibold">Masuk</a>
</nav>


<!-- HERO SECTION -->
<section class="hero mb-5">
    <div class="hero-content text-white" text-white>
        <h1 class="fw-bold display-5">Rekomendasi Makanan Sehat</h1>
        <p class="mt-3 fs-5">Temukan makanan terbaik untuk pola hidup sehatmu.</p>
    </div>
</section>
<!-- REKOMENDASI MINGGU INI -->
<div class="container mb-4">
    <h2 class="fw-semibold mb-3">Rekomendasi Terbaik Minggu Ini</h2>
    <div class="row g-3">
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card card-food">
                <img src="https://images.unsplash.com/photo-1506801310323-534be5e7caa9?auto=format&fit=crop&w=600&q=80" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Brokoli</h5>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-4 col-lg-3">
            <div class="card card-food">
                <img src="https://images.unsplash.com/photo-1567306226416-28f0efdc88ce?auto=format&fit=crop&w=600&q=80" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Tomat</h5>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-4 col-lg-3">
            <div class="card card-food">
                <img src="https://images.unsplash.com/photo-1476718406336-bb5a9690ee2a?auto=format&fit=crop&w=600&q=80" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Bayam</h5>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- SECTION BUAH -->
<div class="container mb-5">
    <h2 class="fw-semibold mb-3">Buah-Buahan</h2>
    <div class="row g-3">


        <div class="col-6 col-md-4 col-lg-3">
            <div class="card card-food">
                <img src="https://images.unsplash.com/photo-1574226516831-e1dff420e12c?auto=format&fit=crop&w=600&q=80" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Apel</h5>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-4 col-lg-3">
            <div class="card card-food">
                <img src="https://images.unsplash.com/photo-1571047399553-5b36d0aaa1a3?auto=format&fit=crop&w=600&q=80" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Jeruk</h5>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-4 col-lg-3">
            <div class="card card-food">
                <img src="https://images.unsplash.com/photo-1508747703725-719777637510?auto=format&fit=crop&w=600&q=80" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Pisang</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('partial/scripts.php'); ?>
</div>

<?php include('partial/footer-end.php'); ?>