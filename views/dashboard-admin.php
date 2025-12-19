<?php
session_start();
// Security check would go here (e.g. if !$_SESSION['is_admin'])
include('partial/header.php');
require_once '../app/model/User.php';
require_once '../app/model/Food.php';

$userModel = new User();
$foodModel = new Food();

$totalUsers = $userModel->getAllUsersCount();
$totalFoods = $foodModel->getAllFoodsCount();
$recentUsers = $userModel->getRecentUsers(5);

// Simulated data for charts
$userGrowthData = [10, 15, 25, 30, 42, 50, $totalUsers];
$dates = [];
for ($i = 6; $i >= 0; $i--) {
    $dates[] = date('d M', strtotime("-$i days"));
}
?>
<?php include('partial/loader.php') ?>

<style>
    /* Admin Specific Styles */
    .admin-card {
        border-radius: 15px;
        overflow: hidden;
        border: none;
        transition: transform 0.3s;
    }
    .admin-card:hover {
        transform: translateY(-5px);
    }
    .bg-gradient-purple {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .bg-gradient-blue {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
    }
    .bg-gradient-orange {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    .bg-gradient-green {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: #333;
    }
    .icon-box {
        width: 48px;
        height: 48px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table-admin th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
</style>

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
                            <h3>Dashboard Admin</h3>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard-admin.php">                                       
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item active">Admin</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row widget-grid">
                    
                    <!-- Stats Widgets -->
                    <div class="col-xl-3 col-md-6 box-col-6">
                        <div class="card admin-card bg-gradient-purple shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 opacity-75">Total Pengguna</p>
                                        <h2 class="mb-0 text-white"><?php echo $totalUsers; ?></h2>
                                    </div>
                                    <div class="icon-box">
                                        <i data-feather="users" class="text-white"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-white text-primary rounded-pill">+5% week</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 box-col-6">
                        <div class="card admin-card bg-gradient-blue shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 opacity-75">Total Item Makanan</p>
                                        <h2 class="mb-0 text-white"><?php echo $totalFoods; ?></h2>
                                    </div>
                                    <div class="icon-box">
                                        <i data-feather="database" class="text-white"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-white text-primary rounded-pill">Updated</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 box-col-6">
                        <div class="card admin-card bg-gradient-orange shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 opacity-75">Laporan Baru</p>
                                        <h2 class="mb-0 text-white">0</h2>
                                    </div>
                                    <div class="icon-box">
                                        <i data-feather="file-text" class="text-white"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-white text-danger rounded-pill">Action needed</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 box-col-6">
                        <div class="card admin-card bg-gradient-green shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 opacity-75 text-dark">Status Sistem</p>
                                        <h2 class="mb-0 text-dark">Active</h2>
                                    </div>
                                    <div class="icon-box bg-dark bg-opacity-10">
                                        <i data-feather="activity" class="text-dark"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-dark text-white rounded-pill">Good</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Charts & Tables -->
                    <div class="col-xl-8 col-md-12 box-col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-transparent border-bottom-0">
                                <h5>Pertumbuhan Pengguna Baru</h5>
                            </div>
                            <div class="card-body pt-0">
                                <div id="userGrowthChart"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-12 box-col-12">
                         <div class="card shadow-sm border-0">
                            <div class="card-header bg-transparent border-bottom-0">
                                <h5>Aktivitas Terakhir</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-light-primary rounded-circle p-2">
                                                    <i data-feather="user-plus" class="text-primary" style="width: 16px; height: 16px;"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">User Baru Terdaftar</h6>
                                                <small class="text-muted">Desember 18, 2025</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-light-success rounded-circle p-2">
                                                    <i data-feather="database" class="text-success" style="width: 16px; height: 16px;"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Update Data Makanan</h6>
                                                <small class="text-muted">Desember 17, 2025</small>
                                            </div>
                                        </div>
                                    </li>
                                     <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-light-warning rounded-circle p-2">
                                                    <i data-feather="server" class="text-warning" style="width: 16px; height: 16px;"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">System Backup</h6>
                                                <small class="text-muted">Desember 16, 2025</small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Users Table -->
                    <div class="col-sm-12">
                        <div class="card shadow-sm border-0">
                             <div class="card-header bg-transparent border-bottom-0 pb-0">
                                <h5>Pengguna Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-admin">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama / Username</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentUsers as $user): ?>
                                                <tr>
                                                    <td>#<?php echo $user['id']; ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-2">
                                                                <span class="avatar rounded-circle bg-light-primary px-2 py-1 text-primary fw-bold">
                                                                    <?php echo substr($user['username'] ?? 'U', 0, 1); ?>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0"><?php echo $user['username'] ?? 'No Name'; ?></h6>
                                                                <small class="text-muted"><?php echo $user['nama'] ?? '-'; ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $user['email']; ?></td>
                                                     <td><?php echo $user['gender'] ?? '-'; ?></td>
                                                    <td><span class="badge bg-success rounded-pill">Active</span></td>
                                                    <td>
                                                        <button class="btn btn-xs btn-outline-primary" type="button"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-xs btn-outline-danger" type="button"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if(empty($recentUsers)): ?>
                                                <tr><td colspan="6" class="text-center">Belum ada pengguna data.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
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
<!-- Plugins JS start-->
<script src="../assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="../assets/js/tooltip-init.js"></script>
<script>
    // Initialize Feather Icons
    feather.replace();

    // User Growth Chart
    var options = {
        series: [{
            name: "Users",
            data: <?php echo json_encode($userGrowthData); ?>
        }],
        chart: {
            height: 350,
            type: 'line',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ['#6a11cb'],
        xaxis: {
            categories: <?php echo json_encode($dates); ?>,
        },
        grid: {
            borderColor: '#f1f1f1',
        }
    };

    var chart = new ApexCharts(document.querySelector("#userGrowthChart"), options);
    chart.render();
</script>
<?php include('partial/footer-end.php') ?>
