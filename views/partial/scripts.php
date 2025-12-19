 <!-- latest jquery-->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <!-- Bootstrap js-->
 <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
 <!-- feather icon js-->
 <script src="../assets/js/icons/feather-icon/feather.min.js"></script>
 <script src="../assets/js/icons/feather-icon/feather-icon.js"></script>
 <!-- scrollbar js-->
 <script src="../assets/js/scrollbar/simplebar.js"></script>
 <script src="../assets/js/scrollbar/custom.js"></script>
 <!-- Sidebar jquery-->
 <script src="../assets/js/config.js"></script>
 <!-- Plugins JS start-->
 <script src="../assets/js/chart/apex-chart/apex-chart.js"></script>
 <script src="../assets/js/chart/apex-chart/stock-prices.js"></script>
 <script id="menu" src="../assets/js/sidebar-menu.js"></script>
 <script src="../assets/js/slick/slick.min.js"></script>
 <script src="../assets/js/slick/slick.js"></script>
 <script src="../assets/js/header-slick.js"></script>
 <!-- Plugins JS Ends-->
 <!-- Theme js-->
 <script src="../assets/js/script.js"></script>
 <!-- <script src="../assets/js/theme-customizer/customizer.js"></script> -->

<script>
    <?php if (isset($_SESSION['alert'])): ?>
        Swal.fire({
            icon: '<?php echo $_SESSION['alert']['icon']; ?>',
            title: '<?php echo $_SESSION['alert']['title']; ?>',
            text: '<?php echo $_SESSION['alert']['text']; ?>',
            showConfirmButton: <?php echo isset($_SESSION['alert']['redirect']) ? 'true' : 'false'; ?>,
            timer: <?php echo isset($_SESSION['alert']['redirect']) ? 'null' : '3000'; ?>,
            timerProgressBar: <?php echo isset($_SESSION['alert']['redirect']) ? 'false' : 'true'; ?>,
            toast: <?php echo isset($_SESSION['alert']['redirect']) ? 'false' : 'true'; ?>,
            position: '<?php echo isset($_SESSION['alert']['redirect']) ? 'center' : 'top-end'; ?>'
        }).then((result) => {
            <?php if (isset($_SESSION['alert']['redirect'])): ?>
                window.location.href = '<?php echo $_SESSION['alert']['redirect']; ?>';
            <?php endif; ?>
        });
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo $_SESSION['success']; ?>',
        });
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo $_SESSION['error']; ?>',
        });
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    function logoutConfirm() {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: "Apakah Anda yakin ingin keluar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../process/logout.php";
            }
        })
    }

    // Global Service Worker Registration
    if ('serviceWorker' in navigator && 'PushManager' in window) {
        window.addEventListener('load', () => {
            // Use dynamic path to handle different directory levels
            const swPath = window.location.pathname.includes('/views/') ? '../sw.js' : 'sw.js';
            navigator.serviceWorker.register(swPath)
                .then(registration => {
                    console.log('Service Worker registered successfully');
                })
                .catch(error => {
                    console.error('Service Worker registration failed:', error);
                });
        });
    }
</script>