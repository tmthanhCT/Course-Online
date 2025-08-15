<?php
include 'header.php';
require_once 'config/database.php';


// Lấy danh sách instructors từ bảng instructors
$stmt = $pdo->prepare("SELECT * FROM instructors");
$stmt->execute();
$instructors = $stmt->fetchAll();


?>

<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_2.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i
                                class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor
                        <i class="fa fa-chevron-right"></i></span></p>
                <h1 class="mb-0 bread">Certified Instructor</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            <?php if ($instructors && count($instructors) > 0): ?>
            <?php foreach ($instructors as $ins): ?>
            <div class="col-md-6 col-lg-3 ftco-animate d-flex align-items-stretch">
                <div class="staff">
                    <div class="img-wrap d-flex align-items-stretch">
                        <?php
                        $avatar = 'images/teacher-1.jpg';
                        if (!empty($ins['avt_img'])) {
                            $avatarPath = htmlspecialchars($ins['avt_img']);
                            // If it's a valid URL, use it directly
                            if (filter_var($ins['avt_img'], FILTER_VALIDATE_URL)) {
                                $avatar = $avatarPath;
                            } else {
                                // Otherwise, treat as relative path from web root
                                if (file_exists(__DIR__ . '/../' . ltrim($ins['avt_img'], '/'))) {
                                    $avatar = ltrim($ins['avt_img'], '/');
                                }
                            }
                        }
                        ?>
                        <div class="img align-self-stretch" style="background-image: url('<?= $avatar ?>');">
                        </div>
                    </div>
                    <div class="text pt-3">
                        <h3><a href="#"><?php echo htmlspecialchars($ins['name']); ?></a></h3>
                        <span class="position mb-2">
                            <?= !empty($ins['position']) ? htmlspecialchars($ins['position']) : 'Instructor' ?>
                        </span>
                        <div class="faded">
                            <p><?= !empty($ins['bio']) ? htmlspecialchars($ins['bio']) : 'Instructor at StudyHub.' ?>
                            </p>
                            <?php if (!empty($ins['expertise'])): ?>
                            <p><strong>Expertise:</strong> <?= htmlspecialchars($ins['expertise']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($ins['email'])): ?>
                            <p><strong>Email:</strong> <?= htmlspecialchars($ins['email']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($ins['phone'])): ?>
                            <p><strong>Phone:</strong> <?= htmlspecialchars($ins['phone']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($ins['facebook'])): ?>
                            <p><strong>Facebook:</strong> <a href="<?= htmlspecialchars($ins['facebook']) ?>"
                                    target="_blank">Profile</a></p>
                            <?php endif; ?>
                            <?php if (!empty($ins['linkedin'])): ?>
                            <p><strong>LinkedIn:</strong> <a href="<?= htmlspecialchars($ins['linkedin']) ?>"
                                    target="_blank">Profile</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">No instructors found in the system.</div>
            </div>
            <?php endif; ?>
        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
                    <ul>
                        <li><a href="#">&lt;</a></li>
                        <li class="active"><span>1</span></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&gt;</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
            stroke="#F96D00" />
    </svg></div>

<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="js/google-map.js"></script>
<script src="js/main.js"></script>

<?php include 'footer.php'; ?>