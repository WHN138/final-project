<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: auth-login.php");
    exit;
}

require_once '../app/services/AnalyticsService.php';

$analyticsService = new AnalyticsService();
$userId = $_SESSION['user']['id'];

if (isset($_GET['action']) && $_GET['action'] == 'download_csv') {
    $analyticsService->generateCSV($userId);
}

$data = $analyticsService->getAnalyticsData($userId);

include('partial/header.php');
include('partial/loader.php');
?>
<!-- Custom Styles -->
<style>
    .analytics-card {
        transition: transform 0.3s;
    }
    .analytics-card:hover {
        transform: translateY(-5px);
    }
    .bg-gradient-purple-soft {
        background: linear-gradient(135deg, #F3E5F5 0%, #E1BEE7 100%);
    }
    .text-purple {
        color: #9C27B0 !important;
    }
</style>

<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <?php include('partial/topbar.php') ?>
    <div class="page-body-wrapper">
        <?php include('partial/sidebar.php') ?>
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-6">
                            <h3>Analitik Kesehatan</h3>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">                                      
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                                <li class="breadcrumb-item active">Analitik</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <!-- Action Bar -->
                <div class="row mb-4">
                    <div class="col-12 text-end">
                        <a href="?action=download_csv" class="btn btn-primary">
                            <i class="fa fa-download me-2"></i>Unduh Laporan CSV
                        </a>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="row">
                    <div class="col-xl-3 col-sm-6 box-col-6">
                        <div class="card analytics-card">
                            <div class="card-body bg-gradient-primary-soft border-start border-primary border-5">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="text-muted f-w-500">Target Harian (TDEE)</span>
                                        <h4 class="mb-0 mt-2 text-primary">2,150 kkal</h4>
                                    </div>
                                    <div class="align-self-center text-center">
                                        <i class="icofont icofont-target fs-1 text-primary opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 box-col-6">
                        <div class="card analytics-card">
                            <div class="card-body bg-gradient-secondary-soft border-start border-secondary border-5">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="text-muted f-w-500">Konsumsi Hari Ini</span>
                                        <h4 class="mb-0 mt-2 text-secondary"><?php echo number_format($data['today_calories']); ?> kkal</h4>
                                    </div>
                                    <div class="align-self-center text-center">
                                        <i class="icofont icofont-fire-burn fs-1 text-secondary opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 box-col-6">
                        <div class="card analytics-card">
                            <div class="card-body bg-gradient-success-soft border-start border-success border-5">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="text-muted f-w-500">Rata-rata Mingguan</span>
                                        <h4 class="mb-0 mt-2 text-success"><?php echo number_format($data['weekly_avg']); ?> kkal</h4>
                                    </div>
                                    <div class="align-self-center text-center">
                                        <i class="icofont icofont-chart-line fs-1 text-success opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-sm-6 box-col-6">
                        <div class="card analytics-card">
                            <div class="card-body bg-gradient-purple-soft border-start border-info border-5">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="text-muted f-w-500">Status</span>
                                        <h5 class="mb-0 mt-2 text-purple">
                                            <?php 
                                                $pct = ($data['tdee'] > 0) ? ($data['today_calories'] / $data['tdee']) * 100 : 0;
                                                echo number_format($pct, 1) . "%";
                                            ?>
                                        </h5>
                                    </div>
                                    <div class="align-self-center text-center">
                                        <i class="icofont icofont-info-circle fs-1 text-purple opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendation & Chart -->
                <div class="row">
                    <div class="col-xl-8 box-col-8">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5>Tren Asupan Kalori Mingguan</h5>
                            </div>
                            <div class="card-body">
                                <div id="weeklyChart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 box-col-4">
                        <div class="card h-100">
                            <div class="card-header pb-0">
                                <h5>Rekomendasi Hari Ini</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-light-primary" role="alert">
                                    <h4 class="alert-heading f-w-600">Halo, <?php echo htmlspecialchars($_SESSION['user']['username'] ?? 'User'); ?>!</h4>
                                    <p class="mb-0 mt-3 f-w-500 text-dark">
                                        <?php echo htmlspecialchars($data['recommendation']); ?>
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <h6 class="text-muted">Tips Cepat:</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-transparent"><i class="icofont icofont-water-drop text-primary me-2"></i> Minum 8 gelas air/hari.</li>
                                        <li class="list-group-item bg-transparent"><i class="icofont icofont-fruits text-success me-2"></i> Perbanyak serat dari sayuran.</li>
                                        <li class="list-group-item bg-transparent"><i class="icofont icofont-runner-alt-1 text-warning me-2"></i> Sempatkan olahraga 30 menit.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('partial/footer.php') ?>
    </div>
</div>

<?php include('partial/scripts.php') ?>
<script src="../assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="../assets/js/chart/apex-chart/series.js"></script>
<script>
    var options = {
        series: [{
            name: 'Kalori',
            data: <?php echo json_encode($data['chart_data']); ?>
        }],
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                dataLabels: {
                    position: 'top',
                },
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val + " kkal";
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
        xaxis: {
            categories: <?php echo json_encode($data['chart_labels']); ?>,
            position: 'bottom',
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            tooltip: {
                enabled: true,
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return val + " kkal";
                }
            }
        },
        colors: [CubaAdminConfig.primary],
        title: {
            text: 'Asupan Kalori vs Hari',
            floating: true,
            offsetY: 330,
            align: 'center',
            style: {
                color: '#444'
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#weeklyChart"), options);
    chart.render();
</script>
<?php include('partial/footer-end.php') ?>
