<?php
// Ensure session is started before any output
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('partial/header.php');
include('partial/loader.php');
?>
<!-- page-wrapper Start-->
<style>
    .meal-card {
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }
    
    .meal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .meal-header {
        position: relative;
        overflow: hidden;
        padding: 1.5rem;
        border-radius: 15px 15px 0 0;
    }

    .meal-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
    }

    .meal-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        margin-right: 15px;
    }

    .meal-icon {
        width: 24px;
        height: 24px;
        fill: white;
    }

    .bg-morning { background: linear-gradient(135deg, #FF9A9E 0%, #FECFEF 100%); }
    .bg-noon { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }
    .bg-night { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); }
    .bg-snack { background: linear-gradient(135deg, #fccb90 0%, #d57eeb 100%); }

    .food-item {
        border-bottom: 1px dashed #e6e6e6;
        padding: 12px 0;
    }
    .food-item:last-child { border-bottom: none; }
    
    .macro-badge {
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 20px;
        margin-left: 5px;
        background-color: #f8f9fa;
        color: #666;
        border: 1px solid #eee;
    }

    .add-food-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: 0.2s;
    }
    .add-food-btn:hover {
        transform: rotate(90deg);
    }
</style>

<?php
require_once '../app/model/MealLog.php';
require_once '../app/model/User.php'; // Just in case, though usually loaded by header



$userId = $_SESSION['user_id'] ?? null;
$date = date('Y-m-d'); // Default today

// Init Model
$mealLogModel = new MealLog();
$dailyLogs = $mealLogModel->getDailyLogs($userId, $date);

// Calculate Totals
$totalCalories = 0;
$totalProtein = 0;
$totalCarbs = 0;
$totalFat = 0;

foreach ($dailyLogs as $time => $meals) {
    foreach ($meals as $meal) {
        $totalCalories += $meal['calories'] ?? 0;
        $totalProtein += $meal['protein'] ?? 0;
        $totalCarbs += $meal['carbs'] ?? 0;
        $totalFat += $meal['fat'] ?? 0;
    }
}
?>

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
                
                <!-- Summary Widget -->
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-primary text-white overflow-hidden shadow-lg mb-4">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <h3 class="mb-2">Ringkasan Nutrisi Hari Ini</h3>
                                        <p class="opacity-75 mb-0">Total asupan nutrisi Anda tanggal <?php echo date('d M Y', strtotime($date)); ?></p>
                                    </div>
                                    <div class="col-lg-6 mt-3 mt-lg-0">
                                        <div class="d-flex justify-content-around text-center">
                                            <div>
                                                <h5 class="mb-0 fw-bold"><?php echo number_format($totalCalories); ?></h5>
                                                <small class="text-white-50">Kalori</small>
                                            </div>
                                            <div>
                                                <h5 class="mb-0 fw-bold"><?php echo number_format($totalProtein, 1); ?>g</h5>
                                                <small class="text-white-50">Protein</small>
                                            </div>
                                            <div>
                                                <h5 class="mb-0 fw-bold"><?php echo number_format($totalCarbs, 1); ?>g</h5>
                                                <small class="text-white-50">Karbo</small>
                                            </div>
                                            <div>
                                                <h5 class="mb-0 fw-bold"><?php echo number_format($totalFat, 1); ?>g</h5>
                                                <small class="text-white-50">Lemak</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php
                    // Config for cards
                    $mealSections = [
                        'pagi' => ['title' => 'Makan Pagi', 'time' => '06:00 - 10:00', 'bg' => 'bg-morning', 'icon' => 'sun'],
                        'siang' => ['title' => 'Makan Siang', 'time' => '12:00 - 14:00', 'bg' => 'bg-noon', 'icon' => 'clock'],
                        'malam' => ['title' => 'Makan Malam', 'time' => '18:00 - 20:00', 'bg' => 'bg-night', 'icon' => 'moon'],
                        'cemilan' => ['title' => 'Cemilan & Lainnya', 'time' => 'Kapan saja', 'bg' => 'bg-snack', 'icon' => 'heart'],
                    ];

                    foreach ($mealSections as $key => $section) : 
                        $meals = $dailyLogs[$key] ?? [];
                        $sectionCalories = 0;
                        foreach($meals as $m) $sectionCalories += $m['calories'];
                    ?>
                    <!-- <?php echo $section['title']; ?> -->
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card meal-card h-100">
                            <div class="meal-header <?php echo $section['bg']; ?> text-white d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="meal-icon-wrapper">
                                        <svg class="meal-icon"><use href="assets/svg/icon-sprite.svg#<?php echo $section['icon']; ?>"></use></svg>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 text-white"><?php echo $section['title']; ?></h5>
                                        <small class="text-white-50"><?php echo $section['time']; ?></small>
                                    </div>
                                </div>
                                <a href="pola-makan.php" class="btn btn-light add-food-btn text-primary shadow-sm" data-bs-toggle="tooltip" title="Tambah Makanan">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <?php if (empty($meals)): ?>
                                    <div class="text-center text-muted py-4">
                                        <i class="icofont icofont-spoon-and-fork fs-1 mb-2 opacity-25"></i>
                                        <p class="mb-0 small">Belum ada data.</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($meals as $meal): ?>
                                    <div class="food-item d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><?php echo htmlspecialchars($meal['name']); ?></h6>
                                            <div class="d-flex flex-wrap gap-1">
                                                <span class="macro-badge"><?php echo number_format($meal['calories']); ?> kkal</span>
                                                <span class="macro-badge">PRO: <?php echo $meal['protein']; ?>g</span>
                                                <span class="macro-badge">FAT: <?php echo $meal['fat']; ?>g</span>
                                                <span class="macro-badge">CAR: <?php echo $meal['carbs']; ?>g</span>
                                            </div>
                                        </div>
                                        <!-- Delete functionality could be added here -->
                                        <div class="cursor-pointer text-muted hover-danger"><i class="fa fa-trash-o"></i></div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                
                                <div class="mt-3 pt-2 text-end border-top">
                                    <span class="f-w-600 text-muted me-2">Total:</span>
                                    <span class="f-w-700 text-primary"><?php echo number_format($sectionCalories); ?> kkal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <?php include('partial/footer.php') ?>
    </div>
</div>

<?php include('partial/scripts.php') ?>
<script src="../assets/js/tooltip-init.js"></script>

<?php if (isset($_SESSION['notification'])): ?>
<script>
    Swal.fire({
        icon: '<?php echo $_SESSION['notification']['type']; ?>',
        title: '<?php echo $_SESSION['notification']['type'] == "success" ? "Berhasil!" : "Gagal!"; ?>',
        text: '<?php echo $_SESSION['notification']['message']; ?>',
        timer: 3000,
        showConfirmButton: false
    });
</script>
<?php unset($_SESSION['notification']); endif; ?>

<?php include('partial/footer-end.php') ?>
