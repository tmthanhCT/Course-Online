<!DOCTYPE html>
<html lang="en">

<head>
    <title>StudyLab - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
</head>
<link rel="stylesheet" href="css/style.css">
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php"><span>Study</span>Lab</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <?php
    $current = basename($_SERVER['PHP_SELF']);
?>
                    <li class="nav-item<?php if($current=='index.php') echo ' active';?>"><a href="index.php"
                            class="nav-link">Home</a></li>
                    <li class="nav-item<?php if($current=='about.php') echo ' active';?>"><a href="about.php"
                            class="nav-link">About</a></li>
                    <li class="nav-item<?php if($current=='course.php') echo ' active';?>"><a href="course.php"
                            class="nav-link">Course</a></li>
                    <li class="nav-item<?php if($current=='instructor.php') echo ' active';?>"><a href="instructor.php"
                            class="nav-link">Instructor</a></li>
                    <li class="nav-item<?php if($current=='blog.php') echo ' active';?>"><a href="blog.php"
                            class="nav-link">Blog</a></li>
                    <li class="nav-item<?php if($current=='contact.php') echo ' active';?>"><a href="contact.php"
                            class="nav-link">Contact</a></li>
                </ul>
                <?php
                        if (session_status() === PHP_SESSION_NONE) session_start();
                        if (isset($_SESSION['user_id']) && isset($_SESSION['name'])): ?>
                <span class="me-3 text-light"><i class="fa fa-user me-2"></i>Hi,
                    <b><?= htmlspecialchars($_SESSION['name']) ?></b></span>
                <a href="authentication-profile.php" class="me-3 text-light"><i class="fa fa-home me-2"></i>Profile</a>
                <a href="logout.php" class="text-light"><i class="fa fa-sign-out me-2"></i>Logout</a>
                <?php else: ?>
                <a href="authentication-register.php"><small class="me-3 text-light"><i
                            class="fa fa-user me-2"></i>Register</small></a>
                <a href="authentication-login.php"><small class="me-3 text-light"><i
                            class="fa fa-sign-in-alt me-2"></i>Login</small></a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <!-- END nav -->
    <div class="hero-wrap js-fullheight" style="background-image: url('images/bg_1.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <span class="subheading">Welcome to StudyLab</span>
                    <h1 class="mb-4">We Are Online Platform For Make Learn</h1>
                    <p class="caps">Far far away, behind the word mountains, far from the countries Vokalia and
                        Consonantia
                    </p>
                    <p class="mb-0"><a href="#" class="btn btn-primary">Our Course</a> <a href="#"
                            class="btn btn-white">Learn More</a></p>
                </div>
            </div>
        </div>
    </div>