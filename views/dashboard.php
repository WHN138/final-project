<?php 
session_start();
include('partial/header.php'); 
?>
<?php include('partial/loader.php') ?>

<!-- Custom Styles for Premium Look -->
<style>
    .small-widget {
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }
    .small-widget:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .small-widget .card-body {
        position: relative;
        z-index: 1;
    }
    /* Gradient Backgrounds for Widgets */
    .bg-gradient-primary-soft { background: linear-gradient(135deg, #FFF5F7 0%, #FFF0F3 100%); }
    .bg-gradient-secondary-soft { background: linear-gradient(135deg, #F3F0FF 0%, #EBE5FF 100%); }
    .bg-gradient-success-soft { background: linear-gradient(135deg, #E8F5E9 0%, #E0F2F1 100%); }
    .bg-gradient-warning-soft { background: linear-gradient(135deg, #FFF8E1 0%, #FFF3E0 100%); }

    .widget-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }
</style>

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
                <div class="row widget-grid">
                    
                    <div class="col-xl-3 col-md-6 box-col-6">
                        <div class="card small-widget mb-4 shadow-sm">
                            <div class="card-body bg-gradient-primary-soft"> 
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="f-light f-w-500 text-muted">Kalori Hari ini</span>
                                        <div class="d-flex align-items-end gap-1 mt-2">
                                            <h4 class="mb-0 text-primary">1000 kkal</h4>
                                        </div>
                                    </div>
                                    <div class="widget-icon-box bg-white shadow-sm text-primary">
                                        <svg class="stroke-icon" style="width: 24px; height: 24px;">
                                            <use href="assets/svg/icon-sprite.svg#fill-fire"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 box-col-6">
                        <div class="card small-widget mb-4 shadow-sm">
                            <div class="card-body bg-gradient-secondary-soft"> 
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="f-light f-w-500 text-muted">Target TDEE</span>
                                        <div class="d-flex align-items-end gap-1 mt-2">
                                            <h4 class="mb-0 text-secondary">1500 kkal</h4>
                                        </div>
                                    </div>
                                    <div class="widget-icon-box bg-white shadow-sm text-secondary">
                                        <svg class="stroke-icon" style="width: 24px; height: 24px;">
                                            <use href="assets/svg/icon-sprite.svg#fill-target"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 box-col-6">
                        <div class="card small-widget mb-4 shadow-sm">
                            <div class="card-body bg-gradient-success-soft"> 
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="f-light f-w-500 text-muted">Protein (Hari Ini)</span>
                                        <div class="d-flex align-items-end gap-1 mt-2">
                                            <h4 class="mb-0 text-success">40%</h4>
                                        </div>
                                    </div>
                                    <div class="widget-icon-box bg-white shadow-sm text-success">
                                        <i class="icofont icofont-muscle fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 box-col-6">
                        <div class="card small-widget mb-4 shadow-sm">
                            <div class="card-body bg-gradient-warning-soft"> 
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="f-light f-w-500 text-muted">Karbohidrat (Hari Ini)</span>
                                        <div class="d-flex align-items-end gap-1 mt-2">
                                            <h4 class="mb-0 text-warning">20%</h4>
                                        </div>
                                    </div>
                                    <div class="widget-icon-box bg-white shadow-sm text-warning">
                                        <i class="icofont icofont-wheat fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xl-6 box-col-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-transparent border-bottom-0 pb-0">
                                <h5 class="card-title mb-0">Grafik Asupan Kalori 7 Hari Terakhir</h5>
                            </div>
                            <div class="card-body pt-0">
                                <div id="grafik1"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-12 box-col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-transparent border-bottom-0 pb-0">
                                <h5 class="card-title mb-0">Distribusi Makro Hari Ini (%)</h5>
                            </div>
                            <div class="card-body chart-block chart-vertical-center">
                                <canvas id="myDoughnutGraph" width="300" height="366"></canvas>
                                <div id="chartLegend"></div>
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
<!-- Plugins JS start-->
<script src="../assets/js/clock.js"></script>
<script src="../assets/js/chart/apex-chart/moment.min.js"></script>
<script src="../assets/js/notify/bootstrap-notify.min.js"></script>
<script src="../assets/js/dashboard/default.js"></script>
<script src="../assets/js/notify/index.js"></script>
<script src="../assets/js/typeahead/handlebars.js"></script>
<script src="../assets/js/typeahead/typeahead.bundle.js"></script>
<script src="../assets/js/typeahead/typeahead.custom.js"></script>
<script src="../assets/js/typeahead-search/handlebars.js"></script>
<script src="../assets/js/height-equal.js"></script>
<script src="../assets/js/animation/wow/wow.min.js"></script>
<!-- Plugins JS Ends-->
<!-- Chart JS Start-->
<script src="../assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="../assets/js/chart/apex-chart/stock-prices.js"></script>
<script src="../assets/js/tooltip-init.js"></script>
<script src="../assets/js/chart/chartjs/chart.min.js"></script>
<script src="../assets/js/tooltip-init.js"></script>
<!-- Chart JS End-->
<script>
    new WOW().init();
</script>
<script>
    // area spaline chart
    var options1 = {
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        series: [{
            name: 'Asupan Kalori (kkal)',
            data: [31, 40, 28, 51, 42, 109, 100]
        }, {
            name: 'Teget TDEE',
            data: [11, 32, 45, 32, 34, 52, 41]
        }],

        xaxis: {
            type: 'datetime',
            categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"],
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
        colors: [CubaAdminConfig.primary, CubaAdminConfig.secondary],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.2,
                stops: [0, 90, 100]
            }
        }
    }

    var chart1 = new ApexCharts(
        document.querySelector("#grafik1"),
        options1
    );

    chart1.render();

    // doughnut grafik
    var doughnutData = [{
            value: 300,
            color: CubaAdminConfig.primary,
            highlight: CubaAdminConfig.primary,
            label: "Primary"
        },
        {
            value: 50,
            color: CubaAdminConfig.secondary,
            highlight: CubaAdminConfig.secondary,
            label: "Secondary"
        },
        {
            value: 100,
            color: "#51bb25",
            highlight: "#51bb25",
            label: "Success"
        }
    ];

    var doughnutOptions = {
        segmentShowStroke: true,
        segmentStrokeColor: "#fff",
        segmentStrokeWidth: 2,
        percentageInnerCutout: 50,
        animationSteps: 100,
        animationEasing: "easeOutBounce",
        animateRotate: true,
        animateScale: false,
        legendTemplate: "<ul style='list-style:none; padding:0; margin:0; text-align:center;'>" +
            "<% for (var i=0; i<segments.length; i++){%>" +
            "<li style='display:inline-flex; align-items:center; margin:0 10px; font-size:14px;'>" +
            "<span style='width:14px; height:12px; background-color:<%=segments[i].fillColor%>; display:inline-block; margin-right:6px;'></span>" +
            "<% if (segments[i].label){ %><%= segments[i].label %><% } %>" +
            "</li>" +
            "<% } %>" +
            "</ul>"
    };
    var doughnutCtx = document.getElementById("myDoughnutGraph").getContext("2d");
    var myDoughnutChart = new Chart(doughnutCtx).Doughnut(doughnutData, doughnutOptions);

    // tempel legend ke div
    document.getElementById("chartLegend").innerHTML = myDoughnutChart.generateLegend();
</script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_SESSION['alert'])): ?>
    <script>
        Swal.fire({
            icon: '<?php echo $_SESSION['alert']['icon']; ?>',
            title: '<?php echo $_SESSION['alert']['title']; ?>',
            text: '<?php echo $_SESSION['alert']['text']; ?>',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    </script>
    <?php unset($_SESSION['alert']); ?>
<?php endif; ?>
<?php include('partial/footer-end.php') ?>