<?php

/**
 * Courses Listing Page
 * Displays all courses from dbcourses.php
 */

require_once __DIR__ .'/config.php';
require_once __DIR__ .'/data/dbcourses.php';

// Optional: group by category
$seo = [
    'title' => 'Our Courses | Cornell Institute of Training',
    'description' => 'Explore Certificate III, Certificate IV, Diploma and Advanced Diploma courses in Hospitality, Construction and Trades at Cornell Institute of Training.',
    'path' => '/courses',
    'breadcrumbs' => [['Home', '/'], ['Courses', '/courses']],
];

$categories = [];
foreach ($courses as $key => $course) {
  $cat = $course['category'] ?? 'Other';
  $categories[$cat][$key] = $course;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <?php require __DIR__ . '/includes/seo.php'; ?>

    <?php include_once('includes/stylesheets.php') ?>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/page/courses.css" />
</head>

<body>
    <?php include_once('includes/navbar.php') ?>

    <!-- Page Header -->
    <section class="courses-header-section">
        <!-- Background image -->
        <img class="courses-header-bg" src="<?= BASE_PATH ?>/assets/images/construction.webp" alt="" />
        <div class="courses-header-overlay"></div>

        <div class="container">
            <!-- Breadcrumb -->
            <nav class="courses-breadcrumb" aria-label="Breadcrumb">
                <a href="<?= BASE_PATH ?>/">Home</a>
                <span>/</span>
                <span>Courses</span>
            </nav>

            <div class="courses-header">
                <span class="courses-label">Explore Our Programs</span>
                <h1 class="heading">Our <span>Courses</span></h1>
                <p>
                    Nationally recognised vocational qualifications designed to give you
                    the practical skills and knowledge needed for a successful career.
                </p>
            </div>
        </div>
    </section>
    <!-- Filter Bar -->
    <section class="courses-filter-bar">
        <div class="container">
            <div class="filter-pills" role="tablist" aria-label="Filter courses by category">
                <button type="button" class="filter-pill active" data-filter="all" aria-pressed="true">
                    All Courses
                </button>
                <button type="button" class="filter-pill" data-filter="Construction" aria-pressed="false">
                    Construction
                </button>
                <button type="button" class="filter-pill" data-filter="Hospitality" aria-pressed="false">
                    Hospitality
                </button>
            </div>
        </div>
    </section>

    <!-- Courses Grid – all cards together -->
    <section class="courses-listing">
        <div class="container">
            <div class="courseCards">
                <?php foreach ($courses as $key => $course): ?>
                <a href="<?= BASE_PATH ?>/course/<?= htmlspecialchars($course['slug']) ?>" class="courseCard"
                    data-category="<?= htmlspecialchars($course['category'] ?? 'Other') ?>">
                    <div class="card-image-wrapper">
                        <img src="<?= BASE_PATH ?>/assets/images/courses/<?= htmlspecialchars($course['hero_image']) ?>"
                            alt="<?= htmlspecialchars($course['title']) ?>" class="card-image" loading="lazy" />
                        <div class="card-gradient"></div>
                    </div>

                    <div class="card-content">
                        <h3 class="main-text">
                            <?= htmlspecialchars($course['code']) ?>
                            <?= htmlspecialchars($course['title']) ?>
                        </h3>
                        <div class="cTags">
                            <div class="ctag"><?= (int)$course['duration_weeks'] ?> weeks</div>
                            <div class="ctag">CRICOS <?= htmlspecialchars($course['cricos']) ?></div>
                            <div class="ctag">Intake open</div>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/scripts.php') ?>

    <script src="<?= BASE_PATH ?>/assets/js/courses-page.js"></script>

</body>

</html>