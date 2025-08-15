<?php
require_once __DIR__ . '/../config/database.php';

// Ensure uploads directory exists
$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

function handle_upload($fileInput) {
    global $uploadDir;
    if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES[$fileInput]['name'], PATHINFO_EXTENSION);
        $filename = uniqid('media_', true) . '.' . $ext;
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $target)) {
            return 'uploads/' . $filename;
        }
    }
    return null;
}

// Handle add
if (isset($_POST['add'])) {
    $id_lession = !empty($_POST['id_lession']) ? $_POST['id_lession'] : null;
    $id_course = !empty($_POST['id_course']) ? $_POST['id_course'] : null;
    $url = $_POST['url'];
    $uploaded = handle_upload('media_file');
    if ($uploaded) {
        $url = $uploaded;
    }
    $stmt = $pdo->prepare("INSERT INTO Videos_images_Url (id_lession, id_course, url) VALUES (?, ?, ?)");
    $stmt->execute([$id_lession, $id_course, $url]);
}

// Handle edit
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $id_lession = !empty($_POST['id_lession']) ? $_POST['id_lession'] : null;
    $id_course = !empty($_POST['id_course']) ? $_POST['id_course'] : null;
    $url = $_POST['url'];
    $uploaded = handle_upload('media_file');
    if ($uploaded) {
        $url = $uploaded;
    }
    $stmt = $pdo->prepare("UPDATE Videos_images_Url SET id_lession=?, id_course=?, url=? WHERE id=?");
    $stmt->execute([$id_lession, $id_course, $url, $id]);
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM Videos_images_Url WHERE id=?");
    $stmt->execute([$id]);
}
include 'admin_header.php';

// Get all records
$stmt = $pdo->query("SELECT v.*, l.title AS lession_title, c.title AS course_title FROM Videos_images_Url v
    LEFT JOIN lessons l ON v.id_lession = l.id
    LEFT JOIN courses c ON v.id_course = c.id
    ORDER BY v.id DESC");
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get all lessons and courses for select boxes
$lessons = $pdo->query("SELECT id, title FROM lessons")->fetchAll(PDO::FETCH_ASSOC);
$courses = $pdo->query("SELECT id, title FROM courses")->fetchAll(PDO::FETCH_ASSOC);

// Get record to edit
$editRecord = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM Videos_images_Url WHERE id=?");
    $stmt->execute([$id]);
    $editRecord = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="container" style="max-width: 950px; margin-top: 40px;">
    <h2 class="mb-4"><i class="fas fa-photo-video text-primary"></i> Lesson & Course Images/Videos Management</h2>
    <!-- Add/Edit Form -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data" class="row g-2 align-items-end">
                <input type="hidden" name="id" value="<?= $editRecord['id'] ?? '' ?>">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Lesson</label>
                    <select name="id_lession" class="form-select">
                        <option value="">-- Select Lesson (optional) --</option>
                        <?php foreach ($lessons as $l): ?>
                        <option value="<?= $l['id'] ?>"
                            <?= (isset($editRecord['id_lession']) && $editRecord['id_lession'] == $l['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($l['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Course</label>
                    <select name="id_course" class="form-select">
                        <option value="">-- Select Course (optional) --</option>
                        <?php foreach ($courses as $c): ?>
                        <option value="<?= $c['id'] ?>"
                            <?= (isset($editRecord['id_course']) && $editRecord['id_course'] == $c['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Image/Video URL</label>
                    <input type="text" class="form-control mb-2" name="url" placeholder="Image/Video URL"
                        value="<?= $editRecord['url'] ?? '' ?>">
                    <input type="file" class="form-control" name="media_file" accept="image/*,video/*">
                    <small class="text-muted">You can upload an image/video file or enter a URL above.</small>
                </div>
                <div class="col-md-12 mt-2">
                    <?php if ($editRecord): ?>
                    <button type="submit" class="btn btn-success me-2" name="edit"><i class="fas fa-save"></i>
                        Update</button>
                    <a href="image_videoController.php" class="btn btn-secondary"><i class="fas fa-times"></i>
                        Cancel</a>
                    <?php else: ?>
                    <button type="submit" class="btn btn-primary" name="add"><i class="fas fa-plus"></i> Add
                        New</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:40px;">ID</th>
                        <th style="width:180px;">Lesson</th>
                        <th style="width:180px;">Course</th>
                        <th style="width:220px;">URL</th>
                        <th style="width:120px;">Preview</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $rec): ?>
                    <tr>
                        <td><?= $rec['id'] ?></td>
                        <td><?= htmlspecialchars($rec['lession_title'] ?? '') ?></td>
                        <td><?= htmlspecialchars($rec['course_title'] ?? '') ?></td>
                        <td style="word-break: break-all; max-width: 220px;">
                            <a href="<?= htmlspecialchars($rec['url']) ?>" target="_blank"><i class="fas fa-link"></i>
                                <?= htmlspecialchars($rec['url']) ?></a>
                        </td>
                        <td>
                            <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $rec['url'])): ?>
                            <img src="<?= htmlspecialchars($rec['url']) ?>" alt="Image" class="img-thumbnail"
                                style="max-width: 80px; max-height: 60px;">
                            <?php elseif (preg_match('/(youtube.com|youtu.be)/i', $rec['url'])): ?>
                            <a href="<?= htmlspecialchars($rec['url']) ?>" target="_blank"
                                class="btn btn-outline-danger btn-sm"><i class="fab fa-youtube"></i> YouTube</a>
                            <?php elseif (preg_match('/\.(mp4|webm)$/i', $rec['url'])): ?>
                            <video src="<?= htmlspecialchars($rec['url']) ?>" class="img-thumbnail"
                                style="max-width: 100px; max-height: 60px;" controls></video>
                            <?php else: ?>
                            <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?edit=<?= $rec['id'] ?>" class="btn btn-sm btn-success mb-1"><i
                                    class="fas fa-edit"></i> Edit</a>
                            <a href="?delete=<?= $rec['id'] ?>" class="btn btn-sm btn-danger mb-1"
                                onclick="return confirm('Are you sure you want to delete this record?')"><i
                                    class="fas fa-trash-alt"></i> Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'admin_footer.php'; ?>