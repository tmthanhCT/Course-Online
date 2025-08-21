<?php
session_start();
include 'header.php';
require_once 'config/database.php';

// Check login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])) {
    header('Location: authentication-login.php');
    exit;
}

// Get user information from database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    // If user not found, log out
    session_destroy();
    header('Location: authentication-login.php');
    exit;
}

// Processing information updates
$update_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $birth_date = $_POST['birth_date'] ?? '';
    
    if ($name) {
        try {
            // Update information into the database according to the current table structure
            $update_stmt = $pdo->prepare('UPDATE users SET name = ?, Phone = ?, Gender = ?, Birth_Day = ? WHERE id = ?');
            $update_stmt->execute([$name, $phone, $gender, $birth_date, $user_id]);

            // Update session
            $_SESSION['name'] = $name;
            
            // Retrieve user information from database to display
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
            
            $update_message = 'Information updated successfully! Data has been saved to the database.';
        } catch (PDOException $e) {
            $update_message = 'An error occurred while updating information: ' . $e->getMessage();
        }
    } else {
        $update_message = 'Please enter your full name!';
    }
}
?>

<!--start page content-->
<div class="page-content">

    <!--start breadcrumb-->
    <div class="py-4 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <!--start product details-->
    <section class="section-padding">
        <div class="container">
            <div class="d-flex align-items-center px-3 py-2 border mb-4">
                <div class="text-start">
                    <h4 class="mb-0 h4 fw-bold">Account - Profile</h4>
                </div>
            </div>

            <?php if ($update_message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i><?php echo $update_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <!-- List of registered courses -->
            <div class="col-12 mb-4">
                <div class="card rounded-0">
                    <div class="card-body p-lg-5">
                        <h5 class="mb-0 fw-bold">Registered courses</h5>
                        <hr>
                        <?php
                            // Get list of registered courses
                            $user_email = $user['email'];
                            $stmt_courses = $pdo->prepare('
                                SELECT c.title, i.name AS instructor_name, uc.enrolled_at, c.price, c.id as course_id
                                FROM user_courses uc
                                JOIN courses c ON uc.course_id = c.id
                                JOIN instructors i ON c.instructor_id = i.id
                                WHERE uc.user_email = ?
                            ');
                            $stmt_courses->execute([$user_email]);
                            $enrolled_courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                        <?php if ($enrolled_courses && count($enrolled_courses) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name course</th>
                                        <th>Instructor</th>
                                        <th>Registration date</th>
                                        <th>Price</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrolled_courses as $ec): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($ec['title']); ?></td>
                                        <td><?php echo htmlspecialchars($ec['instructor_name']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($ec['enrolled_at'])); ?></td>
                                        <td>$<?php echo htmlspecialchars($ec['price']); ?></td>
                                        <td><a href="course-details.php?id=<?php echo $ec['course_id']; ?>"
                                                class="btn btn-sm btn-primary">View</a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info mb-0">You have not registered for any course yet.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-3 filter-column">
                    <nav class="navbar navbar-expand-xl flex-wrap p-0">
                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbarFilter"
                            aria-labelledby="offcanvasNavbarFilterLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title mb-0 fw-bold text-uppercase" id="offcanvasNavbarFilterLabel">
                                    Account</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body account-menu">
                                <div class="list-group w-100 rounded-0">
                                    <a href="index.php" class="list-group-item"><i class="fa fa-home me-2"></i>Home</a>
                                    <a href="authentication-profile.php" class="list-group-item active"><i
                                            class="fa fa-user me-2"></i>Profile</a>
                                    <a href="authentication-profile.php#edit" class="list-group-item"><i
                                            class="fa fa-edit me-2"></i>Edit Profile</a>
                                    <a href="logout.php" class="list-group-item"><i
                                            class="fa fa-sign-out me-2"></i>Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="col-12 col-xl-9">
                    <div class="card rounded-0">
                        <div class="card-body p-lg-5">
                            <h5 class="mb-0 fw-bold">Profile Details</h5>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td><strong>Full name</strong></td>
                                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone</strong></td>
                                            <td><?php echo $user['Phone'] ? htmlspecialchars($user['Phone']) : '<span class="text-muted">Not updated yet</span>'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Gender</strong></td>
                                            <td>
                                                <?php 
                                                if ($user['Gender']) {
                                                    echo $user['Gender'] === 'Male' ? 'Male' : ($user['Gender'] === 'Female' ? 'Female' : 'Other');
                                                } else {
                                                    echo '<span class="text-muted">Not updated yet</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Birth Day</strong></td>
                                            <td><?php echo $user['Birth_Day'] ? date('d/m/Y', strtotime($user['Birth_Day'])) : '<span class="text-muted">Not updated yet</span>'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Role</strong></td>
                                            <td><?php echo $user['role'] === 'admin' ? 'admin' : 'Student'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created At</strong></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <a href="#edit" class="btn btn-outline-dark btn-ecomm px-5">
                                    <i class="fa fa-edit me-2"></i>Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Form update profile-->
                    <div class="card rounded-0 mt-4" id="edit">
                        <div class="card-body p-lg-5">
                            <h5 class="mb-0 fw-bold">Update Profile</h5>
                            <hr>
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone"
                                            value="<?php echo htmlspecialchars($user['Phone'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male"
                                                <?php echo $user['Gender'] === 'Male' ? 'selected' : ''; ?>>Male
                                            </option>
                                            <option value="Female"
                                                <?php echo $user['Gender'] === 'Female' ? 'selected' : ''; ?>>Female
                                            </option>
                                            <option value="Other"
                                                <?php echo $user['Gender'] === 'Other' ? 'selected' : ''; ?>>Other
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="birth_date" class="form-label">Day of Birth</label>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date"
                                            value="<?php echo $user['Birth_Day'] ?? ''; ?>">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" name="update_profile" class="btn btn-dark btn-ecomm px-5">
                                            <i class="fa fa-save me-2"></i>Update Profile
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </section>
    <!--start product details-->

</div>
<!--end page content-->

<?php include 'footer.php'; ?>