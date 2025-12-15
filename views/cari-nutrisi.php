<?php include('partial/header.php'); ?>

<link rel="stylesheet" type="text/css" href="assets/css/vendors/photoswipe.css">

<?php include('partial/loader.php'); ?>

<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <?php include('partial/topbar.php'); ?>
    <!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php include('partial/sidebar.php'); ?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <?php include('partial/breadcrumb.php'); ?>
            <!-- Container-fluid starts-->
            <div class="container-fluid search-page">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-3">Cari Nutrisi Makanan</h4>
                                <form class="theme-form" id="searchForm">
                                    <div class="input-group m-0">
                                        <input class="form-control-plaintext" type="search" id="searchInput"
                                            placeholder="Cari Nutrisi Makanan (Contoh : 100g Chicken)">
                                        <button type="submit"
                                            class="btn btn-primary input-group-text">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Results Container -->
                <div id="resultsContainer" class="row"></div>
            </div>
            <!-- Container-fluid Ends-->
        </div>

        <?php include('partial/footer.php'); ?>
    </div>
</div>

<!-- Modal Add to Log -->
<div class="modal fade" id="addLogModal" tabindex="-1" role="dialog" aria-labelledby="addLogModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="addLogModalLabel">Tambah ke Log Harian</h5>
                <button class="btn-close theme-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addMealForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input class="form-control" type="date" name="date" id="modalDate" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Waktu Makan</label>
                        <select class="form-select" name="meal_time" id="modalMealTime" required>
                            <option value="" selected disabled>Pilih Waktu...</option>
                            <option value="pagi">Sarapan (Pagi)</option>
                            <option value="siang">Makan Siang</option>
                            <option value="malam">Makan Malam</option>
                            <option value="cemilan">Cemilan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Makanan</label>
                        <input class="form-control" type="text" name="food_name" id="modalFoodName" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Kalori (kcal)</label>
                            <input class="form-control" type="number" step="0.1" name="calories" id="modalCalories" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Protein (g)</label>
                            <input class="form-control" type="number" step="0.1" name="protein" id="modalProtein">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Lemak (g)</label>
                            <input class="form-control" type="number" step="0.1" name="fat" id="modalFat">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Karbo (g)</label>
                            <input class="form-control" type="number" step="0.1" name="carbs" id="modalCarbs">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit" id="submitMealBtn">
                        <span class="btn-text">Simpan</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('partial/scripts.php'); ?>
<script>
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const query = document.getElementById('searchInput').value;
        const resultsContainer = document.getElementById('resultsContainer');

        if (!query) return;

        resultsContainer.innerHTML = '<div class="col-12 text-center"><div class="loader-box"><div class="loader-3"></div></div></div>';

        fetch('../process/search-nutrition.php?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {

                resultsContainer.innerHTML = '';

                // Edamam returns data in 'hints' array
                if (data.hints && data.hints.length > 0) {
                    let totalCalories = 0;
                    let html = '';

                    // Limit to top 8 results for better UI
                    const items = data.hints.slice(0, 8);

                    items.forEach(hint => {
                        const item = hint.food;
                        const nutrients = item.nutrients || {};
                        const calories = nutrients.ENERC_KCAL ? nutrients.ENERC_KCAL.toFixed(0) : 0;
                        const protein = nutrients.PROCNT ? nutrients.PROCNT.toFixed(1) : 0;
                        const fat = nutrients.FAT ? nutrients.FAT.toFixed(1) : 0;
                        const carbs = nutrients.CHOCDF ? nutrients.CHOCDF.toFixed(1) : 0;

                        // Edamam doesn't always provide serving size in g directly in the same way, but let's try to find a measure if available
                        // For simplyicity, we'll omit serving size or just show 'Per Serving' if not precise

                        totalCalories += parseFloat(calories);

                        // Use image if available, otherwise placeholder
                        const image = item.image ? `<img src="${item.image}" alt="${item.label}" class="img-fluid rounded-circle mb-3" style="width: 60px; height: 60px; object-fit: cover;">` : '';
                        
                        // Prepare data for modal
                        const safeLabel = item.label.replace(/'/g, "&apos;").replace(/"/g, "&quot;");

                        html += `
                        <div class="col-xl-3 col-md-6">
                            <div class="card shadow-sm border-0 mb-4 h-100">
                                <div class="card-body p-4 text-center">
                                    ${image}
                                    <h6 class="fw-bold text-primary mb-2 text-capitalize text-truncate" title="${safeLabel}">${safeLabel}</h6>
                                    <span class="badge badge-light-primary rounded-pill px-3 py-1 mb-3">
                                        ${calories} kcal
                                    </span>
                                    
                                    <div class="row g-2 small mb-3">
                                        <div class="col-4">
                                            <div class="p-1 rounded bg-light">
                                                <div class="fw-bold text-dark">${protein}g</div>
                                                <span class="text-muted" style="font-size: 10px;">PRO</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="p-1 rounded bg-light">
                                                <div class="fw-bold text-dark">${fat}g</div>
                                                <span class="text-muted" style="font-size: 10px;">FAT</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="p-1 rounded bg-light">
                                                <div class="fw-bold text-dark">${carbs}g</div>
                                                <span class="text-muted" style="font-size: 10px;">CARB</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button class="btn btn-sm btn-outline-primary w-100" 
                                        onclick='openAddModal("${safeLabel}", ${calories}, ${protein}, ${fat}, ${carbs})'>
                                        <i class="fa fa-plus-circle me-1"></i> Tambah ke Log
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    });

                    // Add a summary card
                    html = `
                    <div class="col-12 mb-4">
                        <div class="card bg-primary text-white border-0 shadow-lg">
                            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-1 text-white">Search Results</h4>
                                    <p class="mb-0 text-white-50">Found ${data.hints.length} items for "${query}"</p>
                                </div>
                                <div class="text-end">
                                    <small class="d-block text-white-50">Top items shown</small>
                                </div>
                            </div>
                        </div>
                    </div>
                ` + html;

                    resultsContainer.innerHTML = html;
                } else if (data.error) {
                     resultsContainer.innerHTML = `<div class="col-12 text-center">
                        <div class="alert alert-danger shadow-sm border-0" role="alert">
                            <h4 class="alert-heading">Terjadi Masalah!</h4>
                            <p>${data.error}</p>
                            ${data.details ? '<hr><p class="mb-0 small">' + JSON.stringify(data.details) + '</p>' : ''}
                        </div>
                     </div>`;
                } else {
                    resultsContainer.innerHTML = '<div class="col-12 text-center"><h5>Data tidak ditemukan atau limit API habis.</h5></div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultsContainer.innerHTML = '<div class="col-12 text-center"><h5>Terjadi kesalahan jaringan</h5><p class="text-danger small">' + error + '</p></div>';
            });
    });

    function openAddModal(name, cal, pro, fat, carb) {
        document.getElementById('modalFoodName').value = name;
        document.getElementById('modalCalories').value = cal;
        document.getElementById('modalProtein').value = pro;
        document.getElementById('modalFat').value = fat;
        document.getElementById('modalCarbs').value = carb;
        
        var myModal = new bootstrap.Modal(document.getElementById('addLogModal'));
        myModal.show();
    }

    // Handle form submission with AJAX
    document.getElementById('addMealForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitMealBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');
        
        // Show loading state
        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
        
        // Prepare form data
        const formData = new FormData(this);
        
        // Send AJAX request
        fetch('../process/add-meal.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Hide loading state
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            btnLoading.classList.add('d-none');
            
            if (data.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addLogModal'));
                modal.hide();
                
                // Reset form
                document.getElementById('addMealForm').reset();
                
                // Show success popup
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Makanan berhasil ditambahkan ke log harian!',
                    showConfirmButton: true,
                    confirmButtonText: 'Lihat Log Harian',
                    showCancelButton: true,
                    cancelButtonText: 'Tetap di sini',
                    confirmButtonColor: '#7366ff',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to log-harian.php
                        window.location.href = 'log-harian.php';
                    }
                });
            } else {
                // Show error popup
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan saat menyimpan data.',
                    confirmButtonColor: '#7366ff'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Hide loading state
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            btnLoading.classList.add('d-none');
            
            // Show error popup
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan!',
                text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                confirmButtonColor: '#7366ff'
            });
        });
    });

</script>


<script src="assets/js/photoswipe/photoswipe.min.js"></script>
<script src="assets/js/photoswipe/photoswipe-ui-default.min.js"></script>
<script src="assets/js/photoswipe/photoswipe.js"></script>
<script src="assets/js/tooltip-init.js"></script>
<?php include('partial/footer-end.php'); ?>