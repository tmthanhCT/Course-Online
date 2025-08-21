<?php
include 'admin_header.php';
require_once '../config/database.php';

$stmt = $pdo->query('SELECT * FROM users ORDER BY id DESC');
$users = $stmt->fetchAll();
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-users-cog"></i> User Management</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users"></i> User List</h6>
            <a href="#" class="btn btn-success btn-sm"><i class="fas fa-user-plus"></i> Add User</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th><i class="fas fa-user"></i> Username</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-user-tag"></i> Role</th>
                            <th><i class="fas fa-calendar"></i> Created At</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <select name="role" class="form-control form-control-sm d-inline w-auto">
                                        <option value="student" <?= $user['role']==='student'?'selected':'' ?>>student
                                        </option>
                                        <option value="instructor" <?= $user['role']==='instructor'?'selected':'' ?>>
                                            instructor</option>
                                        <option value="admin" <?= $user['role']==='admin'?'selected':'' ?>>admin
                                        </option>
                                    </select>
                                    <button type="submit" name="update_role"
                                        class="btn btn-sm btn-primary">Save</button>
                                </form>
                            </td>
                            <td><?= htmlspecialchars($user['created_at'] ?? '') ?></td>
                            <td>
                                <a href="#" class="btn btn-danger btn-sm" title="Delete"
                                    onclick="return confirm('Delete this user?')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'admin_footer.php'; ?>