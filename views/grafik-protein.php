<?php 
include('partial/header.php');
include('partial/loader.php');
require_once '../app/model/MealLog.php';

$userId = $_SESSION['user_id'] ?? 0;
$mealLog = new MealLog();
$currentMonth = date('n'); // 1-12
$currentYear = date('Y');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
$monthNameIndo = '';

// Mapping nama bulan ke Indonesia (Duplicate logic, could be in helper but okay for now)
$bulanIndo = [
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember'
];
$monthNameIndo = $bulanIndo[date('F')] . ' ' . $currentYear;

$stats = $mealLog->getMonthlyStats($userId, $currentMonth, $currentYear);

// Prepare data for chart
$chartData = array_fill(1, $daysInMonth, 0); // Initialize all days with 0
foreach ($stats as $stat) {
    $chartData[(int)$stat['day']] = (float)$stat['total_protein'];
}
$chartDataValues = array_values($chartData);
?>

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
                
                <!-- Filter Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-3">
                                <form class="d-flex align-items-center gap-3 flex-wrap">
                                    <h5 class="mb-0 text-primary me-auto"><i class="fa fa-filter me-2"></i>Filter Data</h5>
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="form-label mb-0 text-muted">Bulan:</label>
                                        <select class="form-select form-select-sm" style="width: 150px;">
                                            <option value="<?php echo $currentMonth; ?>"><?php echo $monthNameIndo; ?></option>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm rounded-pill px-4">Tampilkan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Chart Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h5>Grafik Protein Bulanan</h5>
                                <div class="badge badge-light-primary"><?php echo $monthNameIndo; ?></div>
                            </div>
                            <div class="card-body">
                                <div id="monthlyChart"></div>
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
<!-- Apex Chart JS -->
<script src="../assets/js/chart/apex-chart/apex-chart.js"></script>

<script>
    // Monthly Chart Configuration
    var optionsMonthly = {
        series: [{
            name: 'Protein Harian',
            data: <?php echo json_encode($chartDataValues); ?>
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.4,
                stops: [0, 90, 100]
            }
        },
        xaxis: {
            type: 'category',
            categories: <?php echo json_encode(range(1, $daysInMonth)); ?>,
            title: { text: 'Tanggal' }
        },
        yaxis: {
            title: { text: 'Protein (g)' }
        },
        colors: [CubaAdminConfig.primary],
        tooltip: {
            x: { show: true, format: 'dd MMM' },
        }
    };

    var chartMonthly = new ApexCharts(document.querySelector("#monthlyChart"), optionsMonthly);
    chartMonthly.render();
</script>

<?php include('partial/footer-end.php') ?>
