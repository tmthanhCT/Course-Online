<?php 
session_start();
include 'header.php'; 
require_once 'config/database.php';


$stmt = $pdo->query('SELECT courses.*, instructors.name AS instructor_name, category.name AS category_name FROM courses 
    LEFT JOIN instructors ON courses.instructor_id = instructors.id 
    LEFT JOIN category ON courses.category_id = category.id 
    ORDER BY courses.created_at DESC');
$courses = $stmt->fetchAll();

?>

<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_2.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home<i
                                class="fa fa-chevron-right"></i></a></span> <span>List of Courses<i
                            class="fa fa-chevron-right"></i></span></p>
                <h1 class="mb-0 bread">List of Courses</h1>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 sidebar">
            <div class="sidebar-box bg-white rounded-4 shadow-sm p-4 mb-4">
                <form action="#" class="search-form mb-4">
                    <div class="form-group position-relative">
                        <span class="icon fa fa-search position-absolute"
                            style="left: 12px; top: 50%; transform: translateY(-50%); color: #aaa;"></span>
                        <input type="text" class="form-control rounded-pill ps-5" placeholder="Search...">
                    </div>
                </form>
                <h5 class="mb-3 fw-bold">Course Category</h5>
                <form action="#" class="browse-form mb-4">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-category-1" checked>
                        <label class="form-check-label" for="option-category-1">Design & Illustration</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-category-2">
                        <label class="form-check-label" for="option-category-2">Web Development</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-category-3">
                        <label class="form-check-label" for="option-category-3">Programming</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-category-4">
                        <label class="form-check-label" for="option-category-4">Music & Entertainment</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-category-5">
                        <label class="form-check-label" for="option-category-5">Photography</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-category-6">
                        <label class="form-check-label" for="option-category-6">Health & Fitness</label>
                    </div>
                </form>
                <h5 class="mb-3 fw-bold">Course Instructor</h5>
                <form action="#" class="browse-form mb-4">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-instructor-1" checked>
                        <label class="form-check-label" for="option-instructor-1">Ronald Jackson</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-instructor-2">
                        <label class="form-check-label" for="option-instructor-2">John Dee</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-instructor-3">
                        <label class="form-check-label" for="option-instructor-3">Nathan Messy</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-instructor-4">
                        <label class="form-check-label" for="option-instructor-4">Tony Griffin</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-instructor-5">
                        <label class="form-check-label" for="option-instructor-5">Ben Howard</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-instructor-6">
                        <label class="form-check-label" for="option-instructor-6">Harry Potter</label>
                    </div>
                </form>
                <h5 class="mb-3 fw-bold">Course Type</h5>
                <form action="#" class="browse-form mb-4">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-course-type-1" checked>
                        <label class="form-check-label" for="option-course-type-1">Basic</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-course-type-2">
                        <label class="form-check-label" for="option-course-type-2">Intermediate</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-course-type-3">
                        <label class="form-check-label" for="option-course-type-3">Advanced</label>
                    </div>
                </form>
                <h5 class="mb-3 fw-bold">Software</h5>
                <form action="#" class="browse-form">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-software-1" checked>
                        <label class="form-check-label" for="option-software-1">Adobe Photoshop</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-software-2">
                        <label class="form-check-label" for="option-software-2">Adobe Illustrator</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-software-3">
                        <label class="form-check-label" for="option-software-3">Sketch</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-software-4">
                        <label class="form-check-label" for="option-software-4">WordPress</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="option-software-5">
                        <label class="form-check-label" for="option-software-5">HTML & CSS</label>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row g-4">
                <?php 
        $image_count = 9;
        $i = 0;
        foreach ($courses as $course): 
          $img_index = ($i % $image_count) + 1;
          $img_path = "images/work-$img_index.jpg";
        ?>
                <div class="col-md-6 col-xl-4 d-flex align-items-stretch">
                    <div class="course-card bg-white rounded-4 shadow-sm mb-4 w-100 d-flex flex-column">
                        <div class="course-thumb position-relative"
                            style="background-image: url('<?php echo $img_path; ?>'); height: 200px; background-size: cover; background-position: center; border-radius: 16px 16px 0 0;">
                            <span
                                class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2 fs-6 fw-semibold"
                                style="border-radius: 8px;">
                                <?php echo htmlspecialchars($course['category_name'] ?? 'Updating...'); ?>
                            </span>
                        </div>
                        <div class="p-4 flex-fill d-flex flex-column">
                            <h3 class="fs-5 fw-bold mb-2" style="min-height: 48px;"><a
                                    href="course-details.php?id=<?php echo $course['id']; ?>"
                                    class="text-dark text-decoration-none">
                                    <?php echo htmlspecialchars($course['title']); ?> </a></h3>
                            <p class="mb-2 text-uppercase" style="font-size: 13px; color: #888;">
                                INSTRUCTOR
                                <span class="text-primary fw-semibold">
                                    <?php echo htmlspecialchars($course['instructor_name'] ?? 'Updating...'); ?>
                                </span>
                            </p>

                            <ul class="d-flex justify-content-between align-items-center mb-3 ps-0"
                                style="list-style: none; border-top: 1px solid #f0f0f0; padding-top: 10px;">
                                <li style="font-size: 15px; color: #888;"><span
                                        class="flaticon-shower text-primary me-2"></span><?php echo htmlspecialchars($course['duration'] ?? 'Đang cập nhật'); ?>
                                </li>
                                <li class="price fs-5 fw-bold text-primary">
                                    $<?php echo number_format($course['price'], 2); ?></li>
                            </ul>
                            <a href="course-details.php?id=<?php echo $course['id']; ?>"
                                class="btn btn-primary w-100 rounded-pill fw-semibold mt-auto">More details</a>
                        </div>
                    </div>
                </div>
                <?php $i++; endforeach; ?>
            </div>
            <div class="row mt-4">
                <div class="col d-flex justify-content-center">
                    <nav>
                        <ul class="pagination pagination-lg mb-0">
                            <li class="page-item"><a class="page-link rounded-circle mx-1" href="#">&lt;</a></li>
                            <li class="page-item active"><span
                                    class="page-link rounded-circle mx-1 bg-primary border-0 text-white">1</span></li>
                            <li class="page-item"><a class="page-link rounded-circle mx-1" href="#">2</a></li>
                            <li class="page-item"><a class="page-link rounded-circle mx-1" href="#">3</a></li>
                            <li class="page-item"><a class="page-link rounded-circle mx-1" href="#">4</a></li>
                            <li class="page-item"><a class="page-link rounded-circle mx-1" href="#">5</a></li>
                            <li class="page-item"><a class="page-link rounded-circle mx-1" href="#">&gt;</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>


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