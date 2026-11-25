<?php
/**
 * SEO <head> partial: title, meta description, canonical, Open Graph,
 * Twitter cards and JSON-LD (Organization + BreadcrumbList).
 *
 * Usage - at the top of a page (after requiring config.php):
 *
 *   $seo = [
 *       'title'       => 'About Us | Cornell Institute of Training',
 *       'description' => 'Plain-text description, ~150 characters.',
 *       'path'        => '/about',                        // clean path: no .php, no host
 *       'image'       => '/assets/images/campus/campus.jpg', // optional, root-relative
 *       'robots'      => 'index, follow',                 // optional
 *       'breadcrumbs' => [['Home', '/'], ['About', '/about']], // optional
 *       'org'         => true,                            // optional: Organization JSON-LD
 *   ];
 *
 * and inside <head>:   <?php require __DIR__ . '/includes/seo.php'; ?>
 *
 * Canonical / og:url / og:image use BASE_URL (https://cornell.vic.edu.au on live).
 */

if (!function_exists('cn_e')) {
    function cn_e($v): string
    {
        return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
    }
}

$seo         = $seo ?? [];
$seoBase     = rtrim(BASE_URL, '/');
$seoTitle    = $seo['title'] ?? SITE_NAME;
$seoDesc     = $seo['description'] ?? '';
$seoPath     = $seo['path'] ?? '/';
$seoUrl      = $seoBase . $seoPath;
$seoImage    = $seoBase . ($seo['image'] ?? '/assets/images/campus/campus.jpg');
$seoRobots   = $seo['robots'] ?? 'index, follow, max-image-preview:large';
$seoNoindex  = stripos($seoRobots, 'noindex') !== false;
$seoJson     = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG;
?>
    <title><?= cn_e($seoTitle) ?></title>
<?php if ($seoDesc !== ''): ?>
    <meta name="description" content="<?= cn_e($seoDesc) ?>" />
<?php endif; ?>
    <meta name="robots" content="<?= cn_e($seoRobots) ?>" />
<?php if (!$seoNoindex): ?>
    <link rel="canonical" href="<?= cn_e($seoUrl) ?>" />
<?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:type" content="<?= cn_e($seo['type'] ?? 'website') ?>" />
    <meta property="og:site_name" content="<?= cn_e(SITE_NAME) ?>" />
    <meta property="og:locale" content="en_AU" />
    <meta property="og:title" content="<?= cn_e($seoTitle) ?>" />
<?php if ($seoDesc !== ''): ?>
    <meta property="og:description" content="<?= cn_e($seoDesc) ?>" />
<?php endif; ?>
    <meta property="og:url" content="<?= cn_e($seoUrl) ?>" />
    <meta property="og:image" content="<?= cn_e($seoImage) ?>" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= cn_e($seoTitle) ?>" />
<?php if ($seoDesc !== ''): ?>
    <meta name="twitter:description" content="<?= cn_e($seoDesc) ?>" />
<?php endif; ?>
    <meta name="twitter:image" content="<?= cn_e($seoImage) ?>" />
<?php if (!empty($seo['org'])):
    $seoAddr = function (string $street, string $city, string $region, string $zip): array {
        return [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $street,
            'addressLocality' => $city,
            'addressRegion'   => $region,
            'postalCode'      => $zip,
            'addressCountry'  => 'AU',
        ];
    };
    $seoOrg = [
        '@context'   => 'https://schema.org',
        '@type'      => 'EducationalOrganization',
        '@id'        => $seoBase . '/#organization',
        'name'       => SITE_NAME,
        'url'        => $seoBase . '/',
        'logo'       => $seoBase . '/assets/images/logo/logotransparent.png',
        'telephone'  => SITE_PHONE,
        'email'      => SITE_EMAIL,
        'identifier' => ['TOID ' . TOID, 'CRICOS ' . CRICOS],
        'sameAs'     => [
            'https://www.facebook.com/profile.php?id=100090548090602',
            'https://www.instagram.com/cornellinstituteoftraining/',
        ],
        'location'   => [
            [
                '@type'   => 'Place',
                'name'    => SITE_NAME . ' - Melbourne Campus',
                'address' => $seoAddr('Level 5, 440 Elizabeth Street', 'Melbourne', 'VIC', '3000'),
            ],
            [
                '@type'   => 'Place',
                'name'    => SITE_NAME . ' - Brisbane Campus',
                'address' => $seoAddr('161 Brunswick Street', 'Fortitude Valley', 'QLD', '4006'),
            ],
        ],
    ];
?>

    <script type="application/ld+json"><?= json_encode($seoOrg, $seoJson) ?></script>
<?php endif; ?>
<?php if (!empty($seo['breadcrumbs'])):
    $seoCrumbs = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => []];
    foreach ($seo['breadcrumbs'] as $i => $crumb) {
        $seoCrumbs['itemListElement'][] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $crumb[0],
            'item'     => $seoBase . $crumb[1],
        ];
    }
?>
    <script type="application/ld+json"><?= json_encode($seoCrumbs, $seoJson) ?></script>
<?php endif; ?>
