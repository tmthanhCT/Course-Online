<?php
session_start();
include 'header.php';
require_once 'config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');
    if (!$email || !$password || !$confirm) {
        $error = 'Please enter email, password and confirm password!';
    } elseif ($password !== $confirm) {
        $error = 'Password confirmation does not match!';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email already exists!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
            $stmt->execute([$email, $hash]);
            $_SESSION['user'] = [
                'email' => $email
            ];
            header('Location: index.php');
            exit;
        }
    }
}
?>
<div class="page-content">
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-5 col-xxl-5 mx-auto">
                    <div class="card rounded-0">
                        <div class="card-body p-4">
                            <h4 class="mb-0 fw-bold text-center">Registration</h4>
                            <hr>
                            <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>
                            <form method="post" autocomplete="off">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="Name" class="form-label">Name</label>
                                        <input type="text" class="form-control rounded-0" id="Name" name="name"
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <label for="exampleEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control rounded-0" id="exampleEmail"
                                            name="email" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="examplePassword" class="form-label">Password</label>
                                        <input type="password" class="form-control rounded-0" id="examplePassword"
                                            name="password" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="exampleConfirm" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control rounded-0" id="exampleConfirm"
                                            name="confirm_password" required>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-dark rounded-0 btn-ecomm w-100">Sign
                                            Up</button>
                                    </div>
                                    <div class="col-12 text-center">
                                        <p class="mb-0 rounded-0 w-100">Already have an account? <a
                                                href="authentication-login.php" class="text-danger">Sign In</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php'; ?>