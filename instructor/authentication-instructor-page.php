<?php
require_once __DIR__ . '/../../config/database.php';
session_start();

// Check if user is logged in and is instructor
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'instructor') {
    header('Location: ../../authentication-login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

// Handle add course
if (isset($_POST['add_course'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $duration = $_POST['duration'];
    $url_id = !empty($_POST['url_id']) ? $_POST['url_id'] : null;
    $stmt = $pdo->prepare("INSERT INTO courses (instructor_id, title, description, price, category_id, duration, url_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $title, $description, $price, $category_id, $duration, $url_id]);
    header('Location: authentication-instructor-page.php');
    exit;
}

// Get instructor's courses
$stmt = $pdo->prepare("SELECT c.*, cat.name as category_name FROM courses c LEFT JOIN category cat ON c.category_id = cat.id WHERE c.instructor_id = ?");
$stmt->execute([$user_id]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get categories
$cat_stmt = $pdo->query("SELECT * FROM category");
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

// Get media
$media_stmt = $pdo->query("SELECT * FROM videos_images_url");
$media = $media_stmt->fetchAll(PDO::FETCH_ASSOC);

include 'instructor_header.php';
?>
<div class="container-fluid">
    </h2>
    <div class="form-section mb-4 p-4 bg-white rounded shadow">
        <form method="post" class="form-inline justify-content-center flex-wrap needs-validation" novalidate>
            <input type="text" class="form-control mb-2 mr-sm-2" name="title" placeholder="Course Title" required>
            <input type="text" class="form-control mb-2 mr-sm-2" name="description" placeholder="Description" required>
            <input type="number" class="form-control mb-2 mr-sm-2" name="price" placeholder="Price" min="0" step="0.01"
                required>
            <select class="form-control mb-2 mr-sm-2" name="category_id" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" class="form-control mb-2 mr-sm-2" name="duration" placeholder="Duration (e.g. 10h)"
                required>
            <select class="form-control mb-2 mr-sm-2" name="url_id">
                <option value="">Select Media (optional)</option>
                <?php foreach ($media as $m): ?>
                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['url']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary mb-2" name="add_course"><i class="fas fa-plus"></i> Add
                Course</button>
        </form>
    </div>
    <div class="table-section p-4 bg-white rounded shadow">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Duration</th>
                    <th>Media</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= $course['id'] ?></td>
                    <td><?= htmlspecialchars($course['title']) ?></td>
                    <td><?= htmlspecialchars($course['description']) ?></td>
                    <td><?= htmlspecialchars($course['price']) ?></td>
                    <td><?= htmlspecialchars($course['category_name']) ?></td>
                    <td><?= htmlspecialchars($course['duration']) ?></td>
                    <td>
                        <?php if (!empty($course['url_id'])): ?>
                        <?php $media_url = null; foreach ($media as $m) { if ($m['id'] == $course['url_id']) { $media_url = $m['url']; break; } } ?>
                        <?php if ($media_url): ?>
                        <?php if (preg_match('/\\.(jpg|jpeg|png|gif)$/i', $media_url)): ?>
                        <img src="<?= $media_url ?>" style="max-width:40px;max-height:40px;">
                        <?php elseif (preg_match('/\\.(mp4|webm|ogg)$/i', $media_url)): ?>
                        <video src="<?= $media_url ?>" style="max-width:40px;max-height:40px;" controls></video>
                        <?php else: ?>
                        <a href="<?= $media_url ?>" target="_blank">View</a>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($course['created_at']) ?></td>
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
</script>
<?php include 'admin/admin_footer.php'; ?>
<?php include 'footer.php'; ?>