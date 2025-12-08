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
                                <form class="theme-form">
                                    <div class="input-group m-0">
                                        <input class="form-control-plaintext" type="search"
                                            placeholder="Cari Nutrusi Makanan (Contoh : Lotek)">
                                        <button
                                            class="btn btn-primary input-group-text">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <h4 class="mb-3">Rekomendasi Untukmu</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>

        <?php include('partial/footer.php'); ?>
    </div>
</div>

<?php include('partial/scripts.php'); ?>
<script src="assets/js/photoswipe/photoswipe.min.js"></script>
<script src="assets/js/photoswipe/photoswipe-ui-default.min.js"></script>
<script src="assets/js/photoswipe/photoswipe.js"></script>
<script src="assets/js/tooltip-init.js"></script>
<?php include('partial/footer-end.php'); ?>