<?php
session_start();
// Security check should go here
include('partial/header.php');
require_once '../app/model/Food.php';

$foodModel = new Food();

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_food'])) {
        $nama = $_POST['nama'];
        $kalori = $_POST['kalori'];
        $protein = $_POST['protein'];
        $lemak = $_POST['lemak'];
        $karbo = $_POST['karbo'];
        
        if($foodModel->addFood($nama, $kalori, $protein, $lemak, $karbo)){
            $_SESSION['alert'] = [
                'icon' => 'success',
                'title' => 'Berhasil!',
                'text' => 'Makanan ' . $nama . ' berhasil ditambahkan.'
            ];
        } else {
             $_SESSION['alert'] = [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'Gagal menambahkan makanan.'
            ];
        }
        header("Location: admin-food.php");
        exit;
    }
    
    if (isset($_POST['delete_food'])) {
        $id = $_POST['food_id'];
        if($foodModel->deleteFood($id)){
             $_SESSION['alert'] = [
                'icon' => 'success',
                'title' => 'Terhapus!',
                'text' => 'Data makanan berhasil dihapus.'
            ];
        } else {
             $_SESSION['alert'] = [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'Gagal menghapus makanan.'
            ];
        }
        header("Location: admin-food.php");
        exit;
    }
}

$foods = $foodModel->getAllFoods();
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
                            <h3>Database Makanan</h3>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard-admin.php">                                       
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                                <li class="breadcrumb-item">Admin</li>
                                <li class="breadcrumb-item active">Makanan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <!-- Add Food Card -->
                    <div class="col-xl-4 col-lg-5">
                         <div class="card shadow-sm border-0">
                            <div class="card-header bg-transparent border-bottom-0">
                                <h5>Tambah Makanan Baru</h5>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Makanan</label>
                                        <input class="form-control" type="text" name="nama" required placeholder="Contoh: Nasi Goreng">
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label class="form-label">Kalori (kcal)</label>
                                            <input class="form-control" type="number" step="0.01" name="kalori" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label">Protein (g)</label>
                                            <input class="form-control" type="number" step="0.01" name="protein" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label">Lemak (g)</label>
                                            <input class="form-control" type="number" step="0.01" name="lemak" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label">Karbohidrat (g)</label>
                                            <input class="form-control" type="number" step="0.01" name="karbo" required>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary w-100" type="submit" name="add_food">Simpan Data</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Food List -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-transparent border-bottom-0">
                                <h5>Daftar Makanan</h5>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="basic-1">
                                        <thead>
                                            <tr>
                                                <th>Nama Makanan</th>
                                                <th>Kalori</th>
                                                <th>P/L/K (g)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($foods as $food): ?>
                                                <tr>
                                                    <td>
                                                        <span class="fw-bold"><?php echo htmlspecialchars($food['nama_makanan']); ?></span>
                                                    </td>
                                                    <td><?php echo $food['kalori']; ?> kcal</td>
                                                    <td>
                                                        <small title="Protein" class="text-success fw-bold"><?php echo $food['protein']; ?>p</small> / 
                                                        <small title="Lemak" class="text-warning fw-bold"><?php echo $food['lemak']; ?>l</small> / 
                                                        <small title="Karbo" class="text-info fw-bold"><?php echo $food['karbo']; ?>k</small>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-xs btn-outline-danger" onclick="confirmDeleteFood(<?php echo $food['id']; ?>, '<?php echo htmlspecialchars($food['nama_makanan']); ?>')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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

<!-- Hidden Form for Delete -->
<form id="delete-food-form" action="" method="POST" style="display:none;">
    <input type="hidden" name="food_id" id="delete_food_id">
    <input type="hidden" name="delete_food" value="1">
</form>

<?php include('partial/scripts.php') ?>
<script src="../assets/js/tooltip-init.js"></script>
<script>
    feather.replace();

    function confirmDeleteFood(id, name) {
        Swal.fire({
            title: 'Hapus Makanan?',
            text: "Hapus '" + name + "' dari database? Data yang sudah dihapus tidak bisa dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete_food_id').val(id);
                $('#delete-food-form').submit();
            }
        });
    }
</script>
<?php include('partial/footer-end.php') ?>

