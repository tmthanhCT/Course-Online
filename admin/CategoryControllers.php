<?php
// Connect to database via config/database.php (PDO)
require_once __DIR__ . '/../config/database.php';

// Handle add category
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("INSERT INTO category (name) VALUES (?)");
    $stmt->execute([$name]);
    header("Location: CategoryControllers.php");
    exit;
}

// Handle edit category
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $stmt = $pdo->prepare("UPDATE category SET name=? WHERE id=?");
    $stmt->execute([$name, $id]);
    header("Location: CategoryControllers.php");
    exit;
}

// Handle delete category
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM category WHERE id=?");
    $stmt->execute([$id]);
    header("Location: CategoryControllers.php");
    exit;
}

// Get category list
$stmt = $pdo->query("SELECT * FROM category");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get category data for editing
$editCategory = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM category WHERE id=?");
    $stmt->execute([$id]);
    $editCategory = $stmt->fetch(PDO::FETCH_ASSOC);
}

include 'admin_header.php';
?>


<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-list-alt"></i> Category Management</h1>
    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-plus-circle"></i> <?= $editCategory ? 'Edit Category' : 'Add New Category' ?>
                </div>
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="id" value="<?= $editCategory['id'] ?? '' ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter category name" required value="<?= $editCategory['name'] ?? '' ?>">
                            <div class="invalid-feedback">Please enter a category name.</div>
                        </div>
                        <div>
                            <?php if ($editCategory): ?>
                            <button type="submit" name="edit" class="btn btn-warning"><i class="fas fa-save"></i>
                                Update</button>
                            <a href="CategoryControllers.php" class="btn btn-secondary"><i class="fas fa-times"></i>
                                Cancel</a>
                            <?php else: ?>
                            <button type="submit" name="add" class="btn btn-success"><i class="fas fa-plus"></i> Add
                                New</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-list"></i> Category List
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:60px;">ID</th>
                                    <th><i class="fas fa-tag"></i> Name</th>
                                    <th style="width:140px;"><i class="fas fa-cogs"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td><?= $cat['id'] ?></td>
                                    <td><?= htmlspecialchars($cat['name']) ?></td>
                                    <td>
                                        <a href="?edit=<?= $cat['id'] ?>" class="btn btn-sm btn-info" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="?delete=<?= $cat['id'] ?>" class="btn btn-sm btn-danger" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this category?')"><i
                                                class="fas fa-trash-alt"></i></a>
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

<script>
// Bootstrap validation
(function() {
    'use strict';
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php include 'admin_footer.php'; ?>