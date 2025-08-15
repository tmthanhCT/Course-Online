<?php
require_once __DIR__ . '/../config/database.php';
include 'admin_header.php';

// Handle add lesson
if (isset($_POST['add'])) {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $content = $_POST['content'];
    $url_id = !empty($_POST['url_id']) ? $_POST['url_id'] : null;
    $stmt = $pdo->prepare("INSERT INTO lessons (course_id, title, duration, content, url_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$course_id, $title, $duration, $content, $url_id]);
}

// Handle edit lesson
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $content = $_POST['content'];
    $url_id = !empty($_POST['url_id']) ? $_POST['url_id'] : null;
    $stmt = $pdo->prepare("UPDATE lessons SET course_id=?, title=?, duration=?, content=?, url_id=? WHERE id=?");
    $stmt->execute([$course_id, $title, $duration, $content, $url_id, $id]);
}

// Handle delete lesson
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM lessons WHERE id=?");
    $stmt->execute([$id]);
}

// Get all media for select box
$media = $pdo->query("SELECT id, url FROM videos_images_url ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Get all lessons
$stmt = $pdo->query("SELECT lessons.*, courses.title AS course_title FROM lessons LEFT JOIN courses ON lessons.course_id = courses.id");
$lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get all courses for select box
$courses = $pdo->query("SELECT * FROM courses")->fetchAll(PDO::FETCH_ASSOC);

// Get lesson to edit
$editLesson = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM lessons WHERE id=?");
    $stmt->execute([$id]);
    $editLesson = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="container" style="max-width: 900px; margin-top: 40px;">
    <h2 class="text-primary text-center mb-4"><i class="fas fa-book-open"></i> Lesson Management</h2>
    <!-- Add/Edit Lesson Form -->
    <div class="form-section mb-4 p-4 bg-white rounded shadow">
        <form method="post" class="form-inline flex-wrap needs-validation" novalidate>
            <input type="hidden" name="id" value="<?= $editLesson['id'] ?? '' ?>">
            <select name="course_id" class="form-control mb-2 mr-sm-2" required>
                <option value="">-- Select Course --</option>
                <?php foreach ($courses as $course): ?>
                <option value="<?= $course['id'] ?>"
                    <?= (isset($editLesson['course_id']) && $editLesson['course_id'] == $course['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($course['title']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" class="form-control mb-2 mr-sm-2" name="title" placeholder="Lesson Title" required
                value="<?= $editLesson['title'] ?? '' ?>">
            <input type="text" class="form-control mb-2 mr-sm-2" name="duration" placeholder="Duration (e.g. 45m, 1h)"
                value="<?= $editLesson['duration'] ?? '' ?>">
            <input type="text" class="form-control mb-2 mr-sm-2" name="content" placeholder="Content/Link"
                value="<?= $editLesson['content'] ?? '' ?>">
            <select name="url_id" class="form-control mb-2 mr-sm-2">
                <option value="">-- Select Media (optional) --</option>
                <?php foreach ($media as $m): ?>
                <option value="<?= $m['id'] ?>"
                    <?= (isset($editLesson['url_id']) && $editLesson['url_id'] == $m['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m['url']) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if ($editLesson): ?>
            <button type="submit" class="btn btn-success mb-2" name="edit"><i class="fas fa-save"></i> Update</button>
            <a href="LessionControllers.php" class="btn btn-secondary mb-2"><i class="fas fa-times"></i> Cancel</a>
            <?php else: ?>
            <button type="submit" class="btn btn-primary mb-2" name="add"><i class="fas fa-plus"></i> Add New</button>
            <?php endif; ?>
        </form>
    </div>
    <!-- Lessons Table -->
    <div class="table-section p-4 bg-white rounded shadow">
        <table class="table table-bordered table-hover align-middle">
            <thead class="thead-light">
                <tr>
                    <th style="width:40px;">ID</th>
                    <th style="width:160px;"><i class="fas fa-book"></i> Course</th>
                    <th style="width:160px;"><i class="fas fa-heading"></i> Title</th>
                    <th style="width:70px;"><i class="fas fa-clock"></i> Duration</th>
                    <th style="width:220px;"><i class="fas fa-align-left"></i> Content</th>
                    <th style="width:200px;"><i class="fas fa-photo-video"></i> Media</th>
                    <th style="width:110px;"><i class="fas fa-cogs"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                <tr>
                    <td><?= $lesson['id'] ?></td>
                    <td><?= htmlspecialchars($lesson['course_title'] ?? '') ?></td>
                    <td><?= htmlspecialchars($lesson['title']) ?></td>
                    <td><?= htmlspecialchars($lesson['duration']) ?></td>
                    <td class="wrap-content"><?= nl2br(htmlspecialchars($lesson['content'])) ?></td>
                    <td class="wrap-url">
                        <?php
                        $media_url = '';
                        if (!empty($lesson['url_id'])) {
                            foreach ($media as $m) {
                                if ($m['id'] == $lesson['url_id']) {
                                    $media_url = $m['url'];
                                    break;
                                }
                            }
                        }
                        ?>
                        <?php if (!empty($media_url)): ?>
                        <?php if (preg_match('/\.(mp4|webm)$/i', $media_url)): ?>
                        <video src="<?= htmlspecialchars($media_url) ?>" style="max-width: 120px; max-height: 80px;"
                            controls></video>
                        <br>
                        <a href="<?= htmlspecialchars($media_url) ?>" download
                            class="btn btn-sm btn-outline-primary mt-1">Download</a>
                        <?php elseif (preg_match('/(youtube.com|youtu.be)/i', $media_url)): ?>
                        <a href="<?= htmlspecialchars($media_url) ?>" target="_blank"
                            class="btn btn-sm btn-danger mb-1">Watch on YouTube</a>
                        <?php elseif (preg_match('/\.(jpg|jpeg|png|gif)$/i', $media_url)): ?>
                        <img src="<?= htmlspecialchars($media_url) ?>" alt="Lesson Media"
                            style="max-width: 120px; max-height: 80px;">
                        <br>
                        <a href="<?= htmlspecialchars($media_url) ?>" download
                            class="btn btn-sm btn-outline-primary mt-1">Download</a>
                        <?php else: ?>
                        <a href="<?= htmlspecialchars($media_url) ?>" target="_blank" style="word-break: break-all;">
                            <?= htmlspecialchars($media_url) ?>
                        </a>
                        <br>
                        <a href="<?= htmlspecialchars($media_url) ?>" download
                            class="btn btn-sm btn-outline-primary mt-1">Download</a>
                        <?php endif; ?>
                        <?php else: ?>
                        <span class="text-muted">None</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?edit=<?= $lesson['id'] ?>" class="btn btn-sm btn-info mb-1" title="Edit"><i
                                class="fas fa-edit"></i></a>
                        <a href="?delete=<?= $lesson['id'] ?>" class="btn btn-sm btn-danger mb-1" title="Delete"
                            onclick="return confirm('Are you sure you want to delete this lesson?')"><i
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