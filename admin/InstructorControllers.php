<?php
require_once __DIR__ . '/../config/database.php';
include 'admin_header.php';

// Handle add instructor
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $user_id = $_POST['user_id'];
    $avt_img = $_POST['avt_img'];
    $bio = $_POST['bio'];
    $expertise = $_POST['expertise'];
    $stmt = $pdo->prepare("INSERT INTO instructors (name, user_id, avt_img, bio, expertise, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$name, $user_id, $avt_img, $bio, $expertise]);
    header("Location: InstructorControllers.php");
    exit;
}

// Handle edit instructor
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $user_id = $_POST['user_id'];
    $avt_img = $_POST['avt_img'];
    $bio = $_POST['bio'];
    $expertise = $_POST['expertise'];
    $stmt = $pdo->prepare("UPDATE instructors SET name=?, user_id=?, avt_img=?, bio=?, expertise=? WHERE id=?");
    $stmt->execute([$name, $user_id, $avt_img, $bio, $expertise, $id]);
    header("Location: InstructorControllers.php");
    exit;
}

// Handle delete instructor
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM instructors WHERE id=?");
    $stmt->execute([$id]);
    header("Location: InstructorControllers.php");
    exit;
}

// Get all instructors
$stmt = $pdo->query("SELECT * FROM instructors");
$instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get instructor for editing
$editInstructor = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM instructors WHERE id=?");
    $stmt->execute([$id]);
    $editInstructor = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="container" style="max-width: 1000px; margin-top: 40px;">
    <h2 class="text-primary text-center mb-4"><i class="fas fa-chalkboard-teacher"></i> Instructor Management</h2>
    <!-- Add/Edit Form -->
    <div class="form-section mb-4 p-4 bg-white rounded shadow">
        <form method="post" class="form-inline justify-content-center flex-wrap needs-validation" novalidate>
            <input type="hidden" name="id" value="<?= $editInstructor['id'] ?? '' ?>">
            <input type="text" class="form-control mb-2 mr-sm-2" name="name" placeholder="Instructor Name" required
                value="<?= $editInstructor['name'] ?? '' ?>">
            <input type="number" class="form-control mb-2 mr-sm-2" name="user_id" placeholder="User ID" min="1"
                value="<?= $editInstructor['user_id'] ?? '' ?>">
            <input type="text" class="form-control mb-2 mr-sm-2" name="avt_img" placeholder="Avatar Image URL"
                value="<?= $editInstructor['avt_img'] ?? '' ?>">
            <input type="text" class="form-control mb-2 mr-sm-2" name="bio" placeholder="Bio"
                value="<?= $editInstructor['bio'] ?? '' ?>">
            <input type="text" class="form-control mb-2 mr-sm-2" name="expertise" placeholder="Expertise"
                value="<?= $editInstructor['expertise'] ?? '' ?>">
            <?php if ($editInstructor): ?>
            <button type="submit" class="btn btn-success mb-2" name="edit"><i class="fas fa-save"></i> Update</button>
            <a href="InstructorControllers.php" class="btn btn-secondary mb-2"><i class="fas fa-times"></i> Cancel</a>
            <?php else: ?>
            <button type="submit" class="btn btn-primary mb-2" name="add"><i class="fas fa-plus"></i> Add New</button>
            <?php endif; ?>
        </form>
    </div>
    <!-- Instructor List Table -->
    <div class="table-section p-4 bg-white rounded shadow">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><i class="fas fa-user"></i> Name</th>
                    <th><i class="fas fa-user-tag"></i> User ID</th>
                    <th><i class="fas fa-image"></i> Avatar</th>
                    <th><i class="fas fa-info-circle"></i> Bio</th>
                    <th><i class="fas fa-certificate"></i> Expertise</th>
                    <th><i class="fas fa-calendar"></i> Created At</th>
                    <th><i class="fas fa-cogs"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($instructors as $ins): ?>
                <tr>
                    <td><?= $ins['id'] ?></td>
                    <td><?= htmlspecialchars($ins['name']) ?></td>
                    <td><?= htmlspecialchars($ins['user_id']) ?></td>
                    <td>
                        <?php if (!empty($ins['avt_img'])): ?>
                        <img src="<?= htmlspecialchars($ins['avt_img']) ?>" class="avt-img-preview" alt="avt">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($ins['bio']) ?></td>
                    <td><?= htmlspecialchars($ins['expertise']) ?></td>
                    <td><?= htmlspecialchars($ins['created_at']) ?></td>
                    <td>
                        <a href="?edit=<?= $ins['id'] ?>" class="btn btn-sm btn-info" title="Edit"><i
                                class="fas fa-edit"></i></a>
                        <a href="?delete=<?= $ins['id'] ?>" class="btn btn-sm btn-danger" title="Delete"
                            onclick="return confirm('Are you sure you want to delete this instructor?')"><i
                                class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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