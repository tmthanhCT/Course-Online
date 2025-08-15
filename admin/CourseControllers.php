<?php
include 'admin_header.php';
require_once '../config/database.php';

// Handle add course
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $instructor_id = $_POST['instructor_id'];
    $category_id = $_POST['category_id'] !== '' ? $_POST['category_id'] : null;
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $url_id = isset($_POST['url_id']) && $_POST['url_id'] !== '' ? $_POST['url_id'] : null;
    $stmt = $pdo->prepare("INSERT INTO courses (title, instructor_id, category_id, description, price, duration, url_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$title, $instructor_id, $category_id, $description, $price, $duration, $url_id]);
    header("Location: CourseControllers.php?status=success");
    exit;
}

// Handle edit course
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $instructor_id = $_POST['instructor_id'];
    $category_id = $_POST['category_id'] !== '' ? $_POST['category_id'] : null;
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $url_id = isset($_POST['url_id']) && $_POST['url_id'] !== '' ? $_POST['url_id'] : null;
    $stmt = $pdo->prepare("UPDATE courses SET title=?, instructor_id=?, category_id=?, description=?, price=?, duration=?, url_id=? WHERE id=?");
    $stmt->execute([$title, $instructor_id, $category_id, $description, $price, $duration, $url_id, $id]);
    header("Location: CourseControllers.php");
    exit;
}

// Handle delete course
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM courses WHERE id=?");
    $stmt->execute([$id]);
    header("Location: CourseControllers.php");
    exit;
}

// Get all courses with instructor and category name, and media url if any
$stmt = $pdo->query("SELECT courses.*, instructors.name AS instructor_name, category.name AS category_name, videos_images_url.url AS media_url
FROM courses
LEFT JOIN instructors ON courses.instructor_id = instructors.id
LEFT JOIN category ON courses.category_id = category.id
LEFT JOIN videos_images_url ON courses.url_id = videos_images_url.id
ORDER BY courses.created_at DESC");
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get all categories
$catStmt = $pdo->query("SELECT * FROM category");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

// Get all instructors
$insStmt = $pdo->query("SELECT * FROM instructors");
$instructors = $insStmt->fetchAll(PDO::FETCH_ASSOC);

// Get all media for select box
$mediaStmt = $pdo->query("SELECT id, url FROM videos_images_url");
$mediaList = $mediaStmt->fetchAll(PDO::FETCH_ASSOC);

// Get course for editing
$editCourse = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id=?");
    $stmt->execute([$id]);
    $editCourse = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<div class="container" style="max-width: 1200px; margin-top: 40px;">
    <h2 class="text-primary text-center mb-4"><i class="fas fa-book"></i> Course Management</h2>
    <!-- Add/Edit Form -->
    <div class="form-section mb-4 p-4 bg-white rounded shadow">
        <?php if (!isset($editCourse)) $editCourse = null; ?>
        <form method="post" class="form-inline justify-content-center flex-wrap needs-validation" novalidate>
            <input type="hidden" name="id" value="<?= $editCourse['id'] ?? '' ?>">
            <input type="text" class="form-control mb-2 mr-sm-2" name="title" placeholder="Course Title" required
                value="<?= $editCourse['title'] ?? '' ?>">
            <select name="instructor_id" class="form-control mb-2 mr-sm-2" required>
                <option value="">--Select Instructor--</option>
                <?php foreach ($instructors as $ins): ?>
                <option value="<?= $ins['id'] ?>"
                    <?= (isset($editCourse['instructor_id']) && $editCourse['instructor_id'] == $ins['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($ins['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="category_id" class="form-control mb-2 mr-sm-2">
                <option value="">--Select Category--</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"
                    <?= (isset($editCourse['category_id']) && $editCourse['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="url_id" class="form-control mb-2 mr-sm-2">
                <option value="">--Select Media (optional)--</option>
                <?php foreach ($mediaList as $media): ?>
                <option value="<?= $media['id'] ?>"
                    <?= (isset($editCourse['url_id']) && $editCourse['url_id'] == $media['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($media['url']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" class="form-control mb-2 mr-sm-2" name="description" placeholder="Description"
                value="<?= $editCourse['description'] ?? '' ?>">
            <input type="number" class="form-control mb-2 mr-sm-2" name="price" placeholder="Price" min="0"
                value="<?= $editCourse['price'] ?? '' ?>">
            <input type="text" class="form-control mb-2 mr-sm-2" name="duration" placeholder="Duration (e.g. 10h, 90m)"
                value="<?= $editCourse['duration'] ?? '' ?>">
            <?php if ($editCourse): ?>
            <button type="submit" class="btn btn-success mb-2" name="edit"><i class="fas fa-save"></i> Update</button>
            <a href="CourseControllers.php" class="btn btn-secondary mb-2"><i class="fas fa-times"></i> Cancel</a>
            <?php else: ?>
            <button type="submit" class="btn btn-primary mb-2" name="add"><i class="fas fa-plus"></i> Add New</button>
            <?php endif; ?>
        </form>
    </div>
    <!-- Course List Table -->
    <div class="table-section p-4 bg-white rounded shadow">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><i class="fas fa-chalkboard-teacher"></i> Instructor</th>
                    <th><i class="fas fa-heading"></i> Title</th>
                    <th><i class="fas fa-align-left"></i> Description</th>
                    <th><i class="fas fa-dollar-sign"></i> Price</th>
                    <th><i class="fas fa-clock"></i> Duration</th>
                    <th><i class="fas fa-list-alt"></i> Category</th>
                    <th><i class="fas fa-calendar"></i> Created At</th>
                    <th><i class="fas fa-cogs"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= $course['id'] ?></td>
                    <td>
                        <?php
                        $insName = '';
                        foreach ($instructors as $ins) {
                            if ($ins['id'] == $course['instructor_id']) {
                                $insName = $ins['name'];
                                break;
                            }
                        }
                        echo htmlspecialchars($insName);
                        ?>
                    </td>
                    <td><?= htmlspecialchars($course['title']) ?></td>
                    <td><?= htmlspecialchars($course['description']) ?></td>
                    <td>$<?= htmlspecialchars($course['price']) ?></td>
                    <td><?= htmlspecialchars($course['duration'] ?? 'Updating...') ?></td>
                    <td><?= htmlspecialchars($course['category_name'] ?? '') ?></td>
                    <td>
                        <?php if (!empty($course['media_url'])): ?>
                        <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $course['media_url'])): ?>
                        <img src="../<?= htmlspecialchars($course['media_url']) ?>" alt="media"
                            style="max-width:60px;max-height:40px;">
                        <?php elseif (preg_match('/\.(mp4|webm|ogg)$/i', $course['media_url'])): ?>
                        <video src="../<?= htmlspecialchars($course['media_url']) ?>"
                            style="max-width:60px;max-height:40px;" controls></video>
                        <?php elseif (strpos($course['media_url'], 'youtube.com') !== false || strpos($course['media_url'], 'youtu.be') !== false): ?>
                        <a href="<?= htmlspecialchars($course['media_url']) ?>" target="_blank">YouTube</a>
                        <?php else: ?>
                        <a href="../<?= htmlspecialchars($course['media_url']) ?>" target="_blank">Download</a>
                        <?php endif; ?>
                        <?php else: ?>
                        <span class="text-muted">None</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($course['created_at']) ?></td>
                    <td>
                        <a href="?edit=<?= $course['id'] ?>" class="btn btn-sm btn-info" title="Edit"><i
                                class="fas fa-edit"></i></a>
                        <a href="?delete=<?= $course['id'] ?>" class="btn btn-sm btn-danger" title="Delete"
                            onclick="return confirm('Are you sure you want to delete this course?')"><i
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