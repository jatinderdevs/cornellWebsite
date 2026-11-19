<?php
require_once __DIR__ . '/config.php';
http_response_code(404);

$seo = [
    'title'       => 'Page Not Found | Cornell Institute of Training',
    'description' => 'The page you are looking for could not be found. Browse our courses or contact Cornell Institute of Training.',
    'path'        => '/404',
    'robots'      => 'noindex, follow',
];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php require __DIR__ . '/includes/seo.php'; ?>
    <?php include_once __DIR__ . '/includes/stylesheets.php' ?>
</head>

<body>
    <?php include_once __DIR__ . '/includes/navbar.php' ?>

    <main class="container" style="padding: 9rem 1rem 6rem; text-align: center;">
        <h1 class="heading">Page <span>not found</span></h1>
        <p style="max-width: 36rem; margin: 1rem auto 2rem;">
            Sorry, we couldn&rsquo;t find the page you were looking for. It may have moved, or the
            course you want may have a new address.
        </p>
        <div class="cta-actions" style="justify-content: center;">
            <a href="<?= BASE_PATH ?>/courses" class="btn-pill btn-pill-accent">
                View Courses <span class="btn-icon">&rarr;</span>
            </a>
            <a href="<?= BASE_PATH ?>/" class="btn-pill btn-pill-secondary">
                Back to Home <span class="btn-icon">&rarr;</span>
            </a>
            <a href="<?= BASE_PATH ?>/contact" class="btn-pill btn-pill-secondary">
                Contact Us <span class="btn-icon">&rarr;</span>
            </a>
        </div>
    </main>

    <?php include_once __DIR__ . '/includes/footer.php' ?>
    <?php include_once __DIR__ . '/includes/scripts.php' ?>
</body>

</html>
