<?php
session_start();
include 'header.php';
require_once 'config/database.php';


$course_id = $_GET['id'] ?? 0;
// Fetch course info with instructor and category
$stmt_course = $pdo->prepare("
    SELECT 
        c.id AS course_id,
        c.title,
        c.description,
        c.duration,
        c.price,
        c.instructor_id,
        i.name AS instructor,
        cat.name AS category
    FROM courses c
    JOIN instructors i ON c.instructor_id = i.id
    LEFT JOIN category cat ON c.category_id = cat.id
    WHERE c.id = ?
");
$stmt_course->execute([$course_id]);
$course = $stmt_course->fetch(PDO::FETCH_ASSOC);

// Fetch lessons
$stmt_lessons = $pdo->prepare("SELECT id, title, duration FROM lessons WHERE course_id = ?");
$stmt_lessons->execute([$course_id]);
$lessons = $stmt_lessons->fetchAll(PDO::FETCH_ASSOC);

$course['lessons'] = $lessons;
// Calculate total duration from lessons
$totalDuration = 0;
foreach ($course['lessons'] as $lesson) {
    // Assume duration is in hours or minutes as integer or string like '2h', '45m'
    if (is_numeric($lesson['duration'])) {
        $totalDuration += (int)$lesson['duration'];
    } elseif (preg_match('/(\d+)(h|m)/i', $lesson['duration'], $matches)) {
        if (strtolower($matches[2]) === 'h') {
            $totalDuration += (int)$matches[1] * 60;
        } else {
            $totalDuration += (int)$matches[1];
        }
    }
}
$durationText = $totalDuration > 0 ? ($totalDuration >= 60 ? 
floor($totalDuration/60).'h '.($totalDuration%60).'m' : $totalDuration.'m') : 'Updating...';

$enrolled = false;
$user_email = null;
if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
    $user_email = $_SESSION['user']['email'];
} elseif (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];
}
if ($user_email && $course_id > 0) {
    $stmt = $pdo->prepare('SELECT 1 FROM user_courses WHERE user_email = ? AND course_id = ?');
    $stmt->execute([$user_email, $course_id]);
    if ($stmt->fetch()) {
        $enrolled = true;
    }
}
if (isset($_POST['enrol']) && $user_email && $course_id > 0 && !$enrolled) {
    $stmt = $pdo->prepare('INSERT IGNORE INTO user_courses (user_email, course_id) VALUES (?, ?)');
    $stmt->execute([$user_email, $course_id]);
    $enrolled = true;
}


?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($course['title']); ?></h2>
                        <p class="mb-2"><span
                                class="badge bg-primary"><?php echo htmlspecialchars($category['name'] ?? 'Updating...'); ?></span>
                        </p>
                        <p class="mb-2">Instructor:
                            <strong><?php echo htmlspecialchars($course['instructor'] ?? ($course['instructors'] ?? 'Updating...')); ?></strong>
                        </p>
                        <p class="mb-2">Duration: <span
                                class="text-primary fw-bold"><?php echo htmlspecialchars($course['duration'] ?? 'Updating...'); ?></span>
                        </p>
                        <p class="mb-2">Price: <span
                                class="text-primary fw-bold">$<?php echo number_format($course['price'],2); ?></span>
                        </p>
                        <p class="mb-4">
                            <?php echo htmlspecialchars($course['description'] ?? 'Description updating...'); ?></p>
                        <h5 class="mb-3">Lesson List</h5>
                        <ul class="list-group mb-4">
                            <?php if (!empty($course['lessons'])): foreach ($course['lessons'] as $lesson): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?php echo htmlspecialchars($lesson['title']); ?></span>
                                <span
                                    class="badge bg-secondary"><?php echo htmlspecialchars($lesson['duration']); ?></span>
                            </li>
                            <?php endforeach; else: ?>
                            <li class="list-group-item">No lessons yet.</li>
                            <?php endif; ?>
                        </ul>
                        <?php if (!empty($course['lessons'][0]['video'])): ?>
                        <div class="mb-4">
                            <h5>Preview lesson video:</h5>
                            <div class="ratio ratio-16x9">
                                <iframe src="<?php echo htmlspecialchars($course['lessons'][0]['video']); ?>"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-4 mb-4">
                            <h4 class="mb-3">Course Enrollment</h4>
                            <?php if ($user_email): ?>
                            <?php if ($enrolled): ?>
                            <div class="alert alert-success">You have already enrolled in this course!</div>
                            <?php else: ?>
                            <form method="post">
                                <button type="submit" name="enrol" class="btn btn-primary w-100">Enroll Now</button>
                            </form>
                            <?php endif; ?>
                            <?php else: ?>
                            <div class="alert alert-warning">Please <a href="authentication-login.php">login</a> to
                                enroll in this course.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>