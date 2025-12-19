<?php
session_start();
// Security check should go here
include('partial/header.php');
?>
<?php include('partial/loader.php') ?>

<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <?php include('partial/topbar.php') ?>
    <!-- Page Header Ends-->
    
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php include('partial/sidebar-admin.php') ?>
        <!-- Page Sidebar Ends-->
        
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-6">
                            <h3>Laporan & Analitik</h3>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard-admin.php">                                       
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                                <li class="breadcrumb-item">Admin</li>
                                <li class="breadcrumb-item active">Laporan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-center py-5">
                                <div class="mb-4">
                                    <svg class="stroke-icon text-muted" style="width: 64px; height: 64px;">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-charts"></use>
                                    </svg>
                                </div>
                                <h4>Fitur Dalam Pengembangan</h4>
                                <p class="text-muted">Halaman ini akan menampilkan laporan detail dan analitik mendalam tentang penggunaan aplikasi.</p>
                                <button class="btn btn-primary mt-3" onclick="history.back()">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        
        <?php include('partial/footer.php') ?>
    </div>
</div>

<?php include('partial/scripts.php') ?>
<script>
    feather.replace();
</script>
<?php include('partial/footer-end.php') ?>
