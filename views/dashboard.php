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
                <div class="row widget-grid">
                    <div class="col-3">
                        <div class="card small-widget">
                            <div class="card-body primary"> <span class="f-light">Kalori Hari ini</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4>1000 kkal</h4>
                                </div>
                                <div class="bg-gradient">
                                    <svg class="stroke-icon svg-fill">
                                        <use href="assets/svg/icon-sprite.svg#new-order"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card small-widget">
                            <div class="card-body primary"> <span class="f-light">Terget TDEE</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4>1500 kkal</h4>
                                </div>
                                <div class="bg-gradient">
                                    <svg class="stroke-icon svg-fill">
                                        <use href="assets/svg/icon-sprite.svg#new-order"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card small-widget">
                            <div class="card-body primary"> <span class="f-light">Protein (Hari Ini)</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4>40%</h4>
                                </div>
                                <div class="bg-gradient">
                                    <svg class="stroke-icon svg-fill">
                                        <use href="assets/svg/icon-sprite.svg#new-order"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card small-widget">
                            <div class="card-body primary"> <span class="f-light">Karbohidrat (Hari Ini)</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4>20%</h4>
                                </div>
                                <div class="bg-gradient">
                                    <svg class="stroke-icon svg-fill">
                                        <use href="assets/svg/icon-sprite.svg#new-order"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6 box-col-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Grafik Asupan Kalori 7 Hari Terakhir </h5>
                            </div>
                            <div class="card-body">
                                <div id="grafik1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 box-col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Distribusi Makri Hari Ini (%)</h5>
                            </div>
                            <div class="card-body chart-block chart-vertical-center">
                                <canvas id="myDoughnutGraph" width="300" height="366"></canvas>
                                <div id="chartLegend"></div>
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
<!-- <script src="../assets/js/typeahead-search/typeahead-custom.js"></script> -->
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
        colors: [CubaAdminConfig.primary, CubaAdminConfig.secondary]
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
<?php include('partial/footer-end.php') ?>