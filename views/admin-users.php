<?php
session_start();
// Security check should go here
include('partial/header.php');
require_once '../app/model/User.php';

$userModel = new User();

// Handle Post Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_user'])) {
        $id = $_POST['user_id'];
        $username = $_POST['username'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        
        if ($userModel->updateUser($id, $username, $nama, $email, $role)) {
            $_SESSION['alert'] = [
                'icon' => 'success',
                'title' => 'Berhasil!',
                'text' => 'Data user berhasil diperbarui.'
            ];
        } else {
            $_SESSION['alert'] = [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'Terjadi kesalahan saat memperbarui data.'
            ];
        }
        header("Location: admin-users.php");
        exit;
    }

    if (isset($_POST['delete_user'])) {
        $id = $_POST['user_id'];
        if ($userModel->deleteUser($id)) {
            $_SESSION['alert'] = [
                'icon' => 'success',
                'title' => 'Terhapus!',
                'text' => 'User telah dihapus dari sistem.'
            ];
        } else {
            $_SESSION['alert'] = [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'Gagal menghapus user.'
            ];
        }
        header("Location: admin-users.php");
        exit;
    }
}

$users = $userModel->getAllUsers();
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
                            <h3>Manajemen User</h3>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard-admin.php">                                       
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                                <li class="breadcrumb-item">Admin</li>
                                <li class="breadcrumb-item active">Users</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <!-- Users Table -->
                    <div class="col-sm-12">
                        <div class="card shadow-sm border-0">
                             <div class="card-header bg-transparent border-bottom-0 pb-0 d-flex justify-content-between align-items-center">
                                <h5>Daftar Pengguna</h5>
                                <button class="btn btn-primary btn-sm"><i class="fa fa-plus me-2"></i>Tambah User</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" id="basic-1">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Info User</th>
                                                <th>Email</th>
                                                <th>Peran</th>
                                                <th>Status</th>
                                                <th>Terdaftar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user): ?>
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
                                                                <h6 class="mb-0"><?php echo htmlspecialchars($user['username'] ?? 'No Name'); ?></h6>
                                                                <small class="text-muted"><?php echo htmlspecialchars($user['nama'] ?? '-'); ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                    <td>
                                                        <?php if(($user['role'] ?? '') == 'admin'): ?>
                                                            <span class="badge badge-light-primary">Admin</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-light-secondary">User</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><span class="badge bg-success rounded-pill">Active</span></td>
                                                    <td><?php echo isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : '-'; ?></td>
                                                    <td>
                                                        <button class="btn btn-xs btn-outline-primary btn-edit" type="button" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editUserModal"
                                                            data-id="<?php echo $user['id']; ?>"
                                                            data-username="<?php echo htmlspecialchars($user['username']); ?>"
                                                            data-nama="<?php echo htmlspecialchars($user['nama'] ?? ''); ?>"
                                                            data-email="<?php echo htmlspecialchars($user['email']); ?>"
                                                            data-role="<?php echo $user['role']; ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-xs btn-outline-danger" type="button" onclick="confirmDelete(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['username']); ?>')">
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

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button class="btn-close theme-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input class="form-control" type="text" name="username" id="edit_username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input class="form-control" type="text" name="nama" id="edit_nama">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" id="edit_email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" id="edit_role">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit" name="update_user">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden Form for Delete -->
<form id="delete-form" action="" method="POST" style="display:none;">
    <input type="hidden" name="user_id" id="delete_user_id">
    <input type="hidden" name="delete_user" value="1">
</form>

<?php include('partial/scripts.php') ?>
<script>
    feather.replace();

    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            const id = $(this).data('id');
            const username = $(this).data('username');
            const nama = $(this).data('nama');
            const email = $(this).data('email');
            const role = $(this).data('role');

            $('#edit_user_id').val(id);
            $('#edit_username').val(username);
            $('#edit_nama').val(nama);
            $('#edit_email').val(email);
            $('#edit_role').val(role);
        });
    });

    function confirmDelete(id, username) {
        Swal.fire({
            title: 'Hapus User?',
            text: "Anda yakin ingin menghapus user '" + username + "'? Tindakan ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete_user_id').val(id);
                $('#delete-form').submit();
            }
        });
    }
</script>
<?php include('partial/footer-end.php') ?>

