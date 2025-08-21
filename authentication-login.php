<?php
require_once 'config/app.php';
include 'header.php';
require_once 'config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (!$email || !$password) {
        $error = 'Please enter email and password!';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'] ?? $user['email'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = $user['role'] ?? '';


            $_SESSION['welcome_message'] = "Welcome back, " . ($user['name'] ?? $user['email']) . "!";

            // Redirect based on role    
            if (isset($user['role']) && $user['role'] === 'admin') {
                header('Location: admin/index.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $error = 'Email or password is incorrect!';
        }
    }
}
?>

<?php if (isset($error)) : ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Login Failed',
    text: '<?php echo $error; ?>',
    confirmButtonText: 'Try Again'
});
</script>
<?php endif; ?>

<!--end top header-->

<!--start page content-->
<div class="page-content">

    <!--start product details-->
    <section class="section-padding">
        <div class="container">

            <div class="row">
                <div class="col-12 col-lg-6 col-xl-5 col-xxl-5 mx-auto">
                    <div class="card rounded-0">
                        <div class="card-body p-4">
                            <h4 class="mb-0 fw-bold text-center">Login</h4>
                            <hr>
                            <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>
                            <form method="post" autocomplete="off">
                                <div class="row g-4">
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
                                        <button type="submit" class="btn btn-dark rounded-0 btn-ecomm w-100">Sign
                                            In</button>
                                    </div>
                                    <div class="col-12 text-center">
                                        <p class="mb-0 rounded-0 w-100">Don't have an account? <a
                                                href="authentication-register.php" class="text-danger">Register</a></p>
                                    </div>
                                    <!---<p>email: thanh@user.com <br> password: user</p>-->
                                </div>
                                <!---end row-->
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