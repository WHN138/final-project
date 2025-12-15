<?php include('partial/header.php') ?>
<?php include('partial/loader.php') ?>

<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <?php include('partial/topbar.php') ?>
    <!-- Page Header Ends-->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php include('partial/sidebar.php') ?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <?php include('partial/breadcrumb.php') ?>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title mb-0">Input Pola Makan Harian</h4>
                                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">
                                <form id="polaMakanForm">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal</label>
                                                <input class="form-control" type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Waktu Makan</label>
                                                <select class="form-select" name="meal_time" required>
                                                    <option value="" selected disabled>Pilih Waktu...</option>
                                                    <option value="pagi">Sarapan (Pagi)</option>
                                                    <option value="siang">Makan Siang</option>
                                                    <option value="malam">Makan Malam</option>
                                                    <option value="cemilan">Cemilan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Makanan</label>
                                                <input class="form-control" type="text" name="food_name" placeholder="Contoh: Nasi Goreng Spesial" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi & Catatan (Opsional)</label>
                                                <textarea class="form-control" name="description" rows="3" placeholder="Tambahkan catatan tentang porsi atau bahan khusus..."></textarea>
                                            </div>
                                        </div>
                                    
                                        <!-- Macros Section -->
                                        <div class="col-md-12">
                                            <h6 class="align-items-center mt-3 mb-3 d-flex gap-2">
                                                <i class="icofont icofont-chart-pie text-primary fs-5"></i> 
                                                Informasi Nutrisi 
                                                <span class="badge bg-light-info text-info f-12 f-w-400">per porsi</span>
                                            </h6>
                                            <div class="row bg-light rounded-3 p-3 mx-1 mb-4">
                                                <div class="col-sm-6 col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label small text-muted">Kalori (kkal)</label>
                                                        <div class="input-group input-group-sm">
                                                            <input class="form-control" type="number" step="0.1" name="calories" placeholder="0">
                                                            <span class="input-group-text bg-white">kkal</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label small text-muted">Protein (g)</label>
                                                        <div class="input-group input-group-sm">
                                                            <input class="form-control" type="number" step="0.1" name="protein" placeholder="0">
                                                            <span class="input-group-text bg-white">g</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label small text-muted">Lemak (g)</label>
                                                        <div class="input-group input-group-sm">
                                                            <input class="form-control" type="number" step="0.1" name="fat" placeholder="0">
                                                            <span class="input-group-text bg-white">g</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label small text-muted">Karbohidrat (g)</label>
                                                        <div class="input-group input-group-sm">
                                                            <input class="form-control" type="number" step="0.1" name="carbs" placeholder="0">
                                                            <span class="input-group-text bg-white">g</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end pt-0 border-0">
                                        <button class="btn btn-primary" type="submit" id="submitPolaMakanBtn">
                                            <span class="btn-text">Simpan Data</span>
                                            <span class="btn-loading d-none">
                                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                Menyimpan...
                                            </span>
                                        </button>
                                        <button class="btn btn-light" type="reset">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <?php include('partial/footer.php') ?>
    </div>
</div>

<?php include('partial/scripts.php') ?>
<script>
    // Handle form submission with AJAX
    document.getElementById('polaMakanForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitPolaMakanBtn');
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
                // Reset form
                document.getElementById('polaMakanForm').reset();
                
                // Show success popup
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Data makanan berhasil disimpan!',
                    showConfirmButton: true,
                    confirmButtonText: 'Lihat Log Harian',
                    showCancelButton: true,
                    cancelButtonText: 'Input Lagi',
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
<?php include('partial/footer-end.php') ?>
