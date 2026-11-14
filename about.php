<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>About Us | Cornell Institute of Training</title>
    <meta name="description"
        content="Learn about Cornell Institute of Training – a nationally recognised RTO (TOID 6074 | CRICOS 03892A) delivering practical, industry-focused vocational education in Melbourne and Brisbane." />
    <link rel="canonical" href="https://www.cornell.vic.edu.au/about.php" />

    <!-- Open Graph -->
    <meta property="og:title" content="About Us | Cornell Institute of Training" />
    <meta property="og:description"
        content="Empowering students through high-quality vocational education and training." />
    <meta property="og:url" content="https://www.cornell.vic.edu.au/about.php" />
    <meta property="og:type" content="website" />

    <?php include_once('includes/stylesheets.php') ?>
    <link rel="stylesheet" href="assets/css/page/about.css" />
    <link rel="stylesheet" href="assets/css/sections/campuses.css" />
    <link rel="stylesheet" href="assets/css/sections/reviews.css">
    <link rel="stylesheet" href="assets/css/sections/cta.css">

</head>

<body>
    <?php include_once('includes/navbar.php') ?>

    <!-- ===================== PAGE HEADER ===================== -->
    <section class="page-header">
        <img class="page-header-bg" src="https://shorturl.at/rGwlB" alt="" />
        <div class="page-header-overlay"></div>

        <div class="container">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="index.php">Home</a>
                <span>/</span>
                <span>About Us</span>
            </nav>

            <div class="page-header-content">
                <!-- <span class="page-label">Who We Are</span> -->
                <h1 class="heading">About <span>Cornell</span></h1>
                <p>
                    Empowering students through high-quality vocational education and training.
                    Building futures with industry-aligned courses and professional excellence.
                </p>
            </div>
        </div>
    </section>

    <!-- ===================== INTRO ===================== -->
    <section class="about-intro">
        <div class="container">
            <div class="about-intro-grid">
                <img src="assets/images/courses/about.svg" alt="">
                <div class="about-intro-text">
                    <h2 class="heading">Achieve Your Goals</h2>
                    <p>
                        At the Cornell Institute of Training, we believe that education is the key to unlocking your
                        full
                        potential. That’s why we offer a diverse range of training courses, workshops, and programs
                        designed to help
                        you develop the skills, knowledge, and expertise you need to succeed in today’s rapidly changing
                        world.
                    </p>
                    <p>
                        Established with a vision to empower individuals, we deliver industry-focused courses in
                        commercial
                        cookery, cabinet making, building & construction, and more — all tailored to meet the needs of
                        today’s
                        workforce.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-img">
        <div class="about-img-inner">
            <video src="assets/images/videos/about.mp4" autoplay muted loop playsinline
                poster="assets/images/campus/campus.jpg"></video>
        </div>
    </section>
    <?php
$reviewsOpts = [
  'json'       => __DIR__ . '/reviews/reviews-cache.json',
  'title'      => 'What our students say',
  'limit'      => 6,
  'min_rating' => 4,
  'exclude'    => [],   // author names to hide
];
include 'includes/reviews.php';
?>

    <?php include_once('includes/campuses.php') ?>


    <?php include_once('includes/cta.php') ?>



    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/scripts.php') ?>
    <script src="assets/js/about.js"></script>
    <script src="assets/js/reviews.js" defer></script>
</body>

</html>