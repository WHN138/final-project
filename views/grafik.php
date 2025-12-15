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
                                            <option value="12">Desember 2024</option>
                                            <option value="11">November 2024</option>
                                            <option value="10">Oktober 2024</option>
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
                                <h5>Grafik Pola Makan Bulanan</h5>
                                <div class="badge badge-light-primary">Desember 2024</div>
                            </div>
                            <div class="card-body">
                                <div id="monthlyChart"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weekly Chart & Summary -->
                <div class="row">
                    <div class="col-xl-8 col-lg-12">
                        <div class="card h-100">
                            <div class="card-header pb-0">
                                <h5>Analisis Mingguan</h5>
                            </div>
                            <div class="card-body">
                                <div id="weeklyChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div class="row">
                            <div class="col-xl-12 col-md-6">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-2">Rata-rata Kalori</h6>
                                                <h3 class="mb-0">1,940 <small class="fs-6">kkal</small></h3>
                                            </div>
                                            <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                                                <i class="icofont icofont-chart-bar-graph fs-3"></i>
                                            </div>
                                        </div>
                                        <hr class="bg-white opacity-25">
                                        <p class="mb-0 small"><i class="fa fa-arrow-up me-1"></i> 5% dari bulan lalu</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0 me-3">
                                                <span class="bg-light-success p-2 rounded-3">
                                                    <i class="fa fa-trophy text-success fs-5"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Capaian Terbaik</h6>
                                                <p class="mb-0 text-muted small">Minggu ke-2 konsisten ssesuai target TDEE</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <span class="bg-light-warning p-2 rounded-3">
                                                    <i class="fa fa-exclamation-triangle text-warning fs-5"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Perlu Perhatian</h6>
                                                <p class="mb-0 text-muted small">Asupan Protein masih dibawah target (80%).</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            name: 'Kalori Harian',
            data: [1800, 2100, 1950, 1700, 2200, 1850, 1900, 2050, 1980, 1750, 1800, 2300, 1900, 1850, 2000, 1950, 1800, 1750, 2100, 2000, 1950, 1850, 1900, 2050, 1980, 1750, 1800, 1900, 2000, 1950, 1850]
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
            categories: Array.from({length: 31}, (_, i) => i + 1), // 1 to 31
            title: { text: 'Tanggal' },
            tickAmount: 10
        },
        yaxis: {
            title: { text: 'Kalori (kkal)' }
        },
        colors: [CubaAdminConfig.primary],
        tooltip: {
            x: { show: true, format: 'dd MMM' },
        }
    };

    var chartMonthly = new ApexCharts(document.querySelector("#monthlyChart"), optionsMonthly);
    chartMonthly.render();


    // Weekly Chart Configuration
    var optionsWeekly = {
        series: [{
            name: 'Konsumsi Actual',
            data: [1800, 2100, 1950, 1700, 2200, 1850, 1900]
        }, {
            name: 'Target TDEE',
            data: [2000, 2000, 2000, 2000, 2000, 2000, 2000]
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded',
                borderRadius: 5
            },
        },
        dataLabels: { enabled: false },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        },
        yaxis: {
            title: { text: 'Kalori (kkal)' }
        },
        fill: { opacity: 1 },
        colors: [CubaAdminConfig.primary, '#e6edef'],
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " kkal"
                }
            }
        }
    };

    var chartWeekly = new ApexCharts(document.querySelector("#weeklyChart"), optionsWeekly);
    chartWeekly.render();
</script>

<?php include('partial/footer-end.php') ?>
