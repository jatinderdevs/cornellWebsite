<?php

/**
 * Course Detail Page
 * Loads course data from dbcourses.php
 */

require_once 'data/dbcourses.php';

// Get course key from URL (supports both ?course=msf30322 and /course/msf30322)
$courseKey = $_GET['course'] ?? null;

// Fallback: try to get from path if using pretty URLs
if (!$courseKey && isset($_SERVER['PATH_INFO'])) {
  $parts = explode('/', trim($_SERVER['PATH_INFO'], '/'));
  $courseKey = $parts[0] ?? null;
}

$course = $courseKey ? get_course($courseKey) : null;

// 404 if course not found
if (!$course) {
  http_response_code(404);
  // Optionally include a 404 template
  echo '<h1>Course not found</h1><p><a href="courses.php">View all courses</a></p>';
  exit;
}

// Helper values
$pageTitle       = $course['title'] . ' | Cornell Institute of Training';
$pageDescription = $course['short_desc'] ?? substr(strip_tags($course['description']), 0, 155);
$canonicalUrl    = 'https://www.cornell.vic.edu.au/course/' . ($course['slug'] ?? $courseKey);
$heroImage       = "assets/images/courses/".$course['hero_image'];
$unitsCount      = count($course['units'] ?? []);
$visibleUnits    = 8;

// Unit stats
$coreCount     = 0;
foreach (($course['units'] ?? []) as $u) {
  if (strtolower($u['type'] ?? '') === 'core') $coreCount++;
}
$electiveCount = $unitsCount - $coreCount;
$longDesc      = strlen($course['description'] ?? '') > 650;

// Small inline icon set (stroke icons, inherit currentColor)
function cc_icon($name) {
  $p = [
    'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
    'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
    'pin'      => '<path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>',
    'users'    => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6M16 4.8a3.5 3.5 0 0 1 0 6.4M18 14.4c2.2.7 3.5 2.6 3.5 5.6"/>',
    'book'     => '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5v-16z"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20"/>',
    'cap'      => '<path d="M2 9l10-5 10 5-10 5L2 9z"/><path d="M6 11.5V16c0 1.4 2.7 3 6 3s6-1.6 6-3v-4.5"/>',
    'briefcase'=> '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 13h18"/>',
    'id'       => '<rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path d="M6 16c.5-1.6 1.7-2.4 3-2.4s2.5.8 3 2.4M15 10h3M15 13h3"/>',
    'globe'    => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.6 2.8 4 5.8 4 9s-1.4 6.2-4 9c-2.6-2.8-4-5.8-4-9s1.4-6.2 4-9z"/>',
    'check'    => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
    'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
    'search'   => '<circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/>',
    'phone'    => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>',
    'mail'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
    'refresh'  => '<path d="M20 11a8 8 0 0 0-14-4.5L4 9M4 4v5h5M4 13a8 8 0 0 0 14 4.5L20 15M20 20v-5h-5"/>',
    'swap'     => '<path d="M7 7h12l-3-3M17 17H5l3 3"/>',
    'pencil'   => '<path d="M4 20l1-4L16.5 4.5a2 2 0 0 1 3 3L8 19l-4 1z"/>',
    'chat'     => '<path d="M21 12a8 8 0 0 1-11.5 7.2L4 20l1.3-4.6A8 8 0 1 1 21 12z"/>',
    'tool'     => '<path d="M14.5 6.5a4 4 0 0 0-5 5L3 18l3 3 6.5-6.5a4 4 0 0 0 5-5l-2.5 2.5-2.5-.5-.5-2.5 2.5-2.5z"/>',
    'home'     => '<path d="M3 11l9-8 9 8M5 10v10h14V10"/>',
  ];
  $d = $p[$name] ?? '';
  return '<svg class="cc-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Primary SEO -->
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>" />
    <meta name="robots" content="index, follow, max-image-preview:large" />
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= htmlspecialchars($course['title']) ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>" />
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>" />
    <meta property="og:image"
        content="<?= htmlspecialchars('https://www.cornell.vic.edu.au/' . ltrim($heroImage, '/')) ?>" />
    <meta property="og:site_name" content="Cornell Institute of Training" />
    <meta property="og:locale" content="en_AU" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= htmlspecialchars($course['title']) ?>" />
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>" />

    <!-- Additional SEO -->
    <meta name="author" content="Cornell Institute of Training" />
    <meta name="geo.region" content="AU-VIC" />
    <meta name="geo.placename" content="Melbourne" />

    <script>
    document.documentElement.classList.add("js")
    </script>
    <?php include_once('includes/stylesheets.php') ?>
    <link rel="stylesheet" href="assets/css/page/course-page.css" />
    <link rel="stylesheet" href="assets/css/sections/campuses.css" />

    <!-- Structured Data (Course) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Course",
        "name": "<?= htmlspecialchars($course['title']) ?>",
        "description": "<?= htmlspecialchars($pageDescription) ?>",
        "provider": {
            "@type": "Organization",
            "name": "Cornell Institute of Training",
            "sameAs": "https://www.cornell.vic.edu.au",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Level 5, 440 Elizabeth Street",
                "addressLocality": "Melbourne",
                "addressRegion": "VIC",
                "postalCode": "3000",
                "addressCountry": "AU"
            }
        },
        "offers": {
            "@type": "Offer",
            "category": "Paid",
            "priceCurrency": "AUD",
            "price": "<?= (int)$course['enrolment_fee'] ?>"
        },
        "hasCourseInstance": {
            "@type": "CourseInstance",
            "courseMode": "onsite",
            "duration": "P<?= (int)$course['duration_weeks'] ?>W",
            "location": {
                "@type": "Place",
                "name": "Cornell Institute of Training – Melbourne Campus",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Level 5, 440 Elizabeth Street",
                    "addressLocality": "Melbourne",
                    "addressRegion": "VIC",
                    "postalCode": "3000",
                    "addressCountry": "AU"
                }
            }
        },
        "educationalCredentialAwarded": "<?= htmlspecialchars($course['code'] . ' - ' . $course['title']) ?>",
        "occupationalCredentialAwarded": "<?= htmlspecialchars(implode(', ', $course['pathways_job'] ?? [])) ?>"
    }
    </script>
</head>

<body>
    <?php include_once('includes/navbar.php') ?>

    <!-- ===================== COURSE HERO ===================== -->
    <section class="course-hero">
        <img class="course-hero-bg" src="<?= htmlspecialchars($heroImage) ?>"
            alt="<?= htmlspecialchars($course['title']) ?>" width="1470" height="800" fetchpriority="high" />
        <div class="course-hero-overlay"></div>

        <div class="container">
            <nav class="course-breadcrumb" aria-label="Breadcrumb">
                <a href="courses.php">Our Courses</a>
                <span>/</span>
                <span><?= htmlspecialchars($course['title']) ?></span>
            </nav>

            <div class="course-hero-grid">
                <div class="course-hero-content">
                    <div class="course-meta-top">
                        <span class="course-code"><?= htmlspecialchars($course['code']) ?></span>
                        <span class="course-cricos">CRICOS: <?= htmlspecialchars($course['cricos']) ?></span>
                    </div>

                    <h1 class="course-title">
                        <?= htmlspecialchars($course['title']) ?>
                    </h1>

                    <p class="course-lead">
                        <?= htmlspecialchars($course['short_desc']) ?>
                    </p>

                    <div class="course-actions">
                        <a href="#enquire" class="btn-pill btn-pill-accent">
                            Enquire Now <span class="btn-icon">→</span>
                        </a>
                        <a href="#structure" class="btn-pill btn-pill-secondary">
                            View Units <span class="btn-icon">→</span>
                        </a>
                    </div>
                </div>

                <!-- Key facts card -->
                <div class="course-facts-card">
                    <div class="fact-item">
                        <span class="fact-label">Duration</span>
                        <span class="fact-value"><?= (int)$course['duration_weeks'] ?> weeks</span>
                        <span class="fact-note">
                            <?= (int)$course['contact_weeks'] ?> contact weeks · <?= (int)$course['hours_per_week'] ?>
                            hrs/week
                        </span>
                    </div>
                    <div class="fact-item">
                        <span class="fact-label">Enrolment Fee</span>
                        <span class="fact-value">$<?= number_format((int)$course['enrolment_fee']) ?></span>
                        <span class="fact-note">Non-refundable</span>
                    </div>
                    <div class="fact-item">
                        <span class="fact-label">Tuition Fee</span>
                        <span class="fact-value"><?= htmlspecialchars($course['tuition_fee']) ?></span>
                        <span class="fact-note">Request current pricing</span>
                    </div>
                    <div class="fact-item">
                        <span class="fact-label">Location</span>
                        <span class="fact-value"><?= htmlspecialchars($course['location']) ?></span>
                        <span class="fact-note">Level 5, 440 Elizabeth St</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== MAIN CONTENT ===================== -->
    <section class="course-content">

        <!-- Sticky section navigation -->
        <nav class="cc-subnav" id="ccSubnav" aria-label="Course sections">
            <div class="container">
                <ul class="cc-subnav-list" id="ccSubnavList">
                    <li><a href="#overview" class="is-active">Overview</a></li>
                    <li><a href="#pathways">Pathways</a></li>
                    <li><a href="#requirements">Entry</a></li>
                    <li><a href="#structure">Units</a></li>
                    <li><a href="#assessment">Assessment</a></li>
                    <li><a href="#rpl">RPL &amp; Credit</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>
        </nav>

        <div class="container cc-layout">

            <!-- ============ MAIN COLUMN ============ -->
            <div class="cc-main">

                <!-- Overview -->
                <section class="cc-block" id="overview" data-spy>
                    <p class="cc-eyebrow">Overview</p>
                    <h2 class="cc-h2">About this course</h2>

                    <ul class="cc-stats">
                        <li class="cc-stat">
                            <span class="cc-stat-ic"><?= cc_icon('clock') ?></span>
                            <span class="cc-stat-val"><?= (int)$course['duration_weeks'] ?> weeks</span>
                            <span class="cc-stat-label"><?= (int)$course['contact_weeks'] ?> contact weeks</span>
                        </li>
                        <li class="cc-stat">
                            <span class="cc-stat-ic"><?= cc_icon('calendar') ?></span>
                            <span class="cc-stat-val"><?= (int)$course['hours_per_week'] ?> hrs / week</span>
                            <span class="cc-stat-label">Scheduled study</span>
                        </li>
                        <li class="cc-stat">
                            <span class="cc-stat-ic"><?= cc_icon('users') ?></span>
                            <span class="cc-stat-val">Face-to-face</span>
                            <span class="cc-stat-label">Plus independent study</span>
                        </li>
                        <li class="cc-stat">
                            <span class="cc-stat-ic"><?= cc_icon('pin') ?></span>
                            <span class="cc-stat-val"><?= htmlspecialchars($course['location']) ?></span>
                            <span class="cc-stat-label">Campus</span>
                        </li>
                    </ul>

                    <div class="cc-prose<?= $longDesc ? ' is-clamped' : '' ?>" id="ccProse">
                        <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>
                    </div>
                    <?php if ($longDesc): ?>
                    <button type="button" class="cc-link-btn" id="ccProseToggle" aria-expanded="false"
                        aria-controls="ccProse">
                        <span>Read more</span>
                        <?= cc_icon('arrow') ?>
                    </button>
                    <?php endif; ?>
                </section>

                <!-- Pathways -->
                <section class="cc-block img-grid" id="pathways" data-spy>
                    <div>
                        <p class="cc-eyebrow">Pathways</p>
                        <h2 class="cc-h2">Where this course can take you</h2>

                        <div class="cc-tabs" data-tabs>
                            <div class="cc-tablist" role="tablist" aria-label="Pathway type">
                                <button type="button" class="cc-tab is-active" role="tab" id="tab-careers"
                                    aria-selected="true" aria-controls="panel-careers">
                                    <?= cc_icon('briefcase') ?> Careers
                                </button>
                                <button type="button" class="cc-tab" role="tab" id="tab-study" aria-selected="false"
                                    aria-controls="panel-study" tabindex="-1">
                                    <?= cc_icon('cap') ?> Further study
                                </button>
                            </div>

                            <div class="cc-tabpanel is-active" role="tabpanel" id="panel-careers"
                                aria-labelledby="tab-careers">
                                <?php if (!empty($course['pathways_job'])): ?>
                                <p class="cc-panel-lead">This qualification provides a pathway to work as a:</p>
                                <ul class="cc-chips">
                                    <?php foreach ($course['pathways_job'] as $job): ?>
                                    <li class="cc-chip"><?= cc_icon('check') ?><?= htmlspecialchars($job) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else: ?>
                                <p class="cc-panel-lead">Contact us to discuss employment outcomes for this course.</p>
                                <?php endif; ?>
                            </div>

                            <div class="cc-tabpanel" role="tabpanel" id="panel-study" aria-labelledby="tab-study"
                                hidden>
                                <?php if (!empty($course['pathways_study'])): ?>
                                <p class="cc-panel-lead">After this course you could continue into:</p>
                                <ul class="cc-pathlist">
                                    <?php foreach ($course['pathways_study'] as $pathway): ?>
                                    <li><?= cc_icon('arrow') ?><span><?= htmlspecialchars($pathway) ?></span></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else: ?>
                                <p class="cc-panel-lead">Contact us for further study options.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <p class="cc-footnote">Pathways are a guide only and are not prerequisites for enrolment.</p>

                    </div>

                    <img src="assets/images/courses/const.svg" width="400px" alt="">
                </section>

                <!-- Entry Requirements -->
                <section class="cc-block" id="requirements" data-spy>

                    <p class="cc-eyebrow">Entry requirements</p>
                    <h2 class="cc-h2">Can I enrol?</h2>

                    <div class="cc-req-grid">
                        <div class="cc-req">
                            <span class="cc-req-ic"><?= cc_icon('book') ?></span>
                            <h3>Academic</h3>
                            <p>Australian Year 12 (or equivalent from other countries)</p>
                        </div>
                        <div class="cc-req">
                            <span class="cc-req-ic"><?= cc_icon('id') ?></span>
                            <h3>Age</h3>
                            <p>Must be 18 years or older at course commencement</p>
                        </div>
                        <div class="cc-req">
                            <span class="cc-req-ic"><?= cc_icon('chat') ?></span>
                            <h3>Other</h3>
                            <p>Pre-enrolment needs analysis, interview and LLND assessment may be required</p>
                        </div>
                    </div>

                    <div class="cc-english">
                        <div class="cc-english-head">
                            <span class="cc-req-ic"><?= cc_icon('globe') ?></span>
                            <div>
                                <h3>English language proficiency</h3>
                                <p>Pick your test to see the minimum score.</p>
                            </div>
                        </div>
                        <div class="cc-seg" role="group" aria-label="English test" id="ccEnglish">
                            <button type="button" class="is-active" data-score="6.0" data-note="overall"
                                aria-pressed="true">IELTS Academic</button>
                            <button type="button" data-score="60 – 78" data-note="overall (iBT)"
                                aria-pressed="false">TOEFL iBT</button>
                            <button type="button" data-score="51.6" data-note="overall" aria-pressed="false">PTE
                                Academic</button>
                        </div>
                        <div class="cc-score" aria-live="polite">
                            <span class="cc-score-val" id="ccScoreVal">6.0</span>
                            <span class="cc-score-note">minimum <span id="ccScoreNote">overall</span></span>
                        </div>
                    </div>
                </section>

                <!-- Course Structure -->
                <section class="cc-block" id="structure" data-spy>
                    <p class="cc-eyebrow">Course structure</p>
                    <h2 class="cc-h2"><?= $unitsCount ?> units, Core + Elective</h2>
                    <p class="cc-lead">Practical and technical skills you can use at work from day one.</p>

                    <?php if (!empty($course['units'])): ?>
                    <div class="cc-units" id="ccUnits" data-visible="<?= (int)$visibleUnits ?>">
                        <div class="cc-units-bar">
                            <label class="cc-search">
                                <span class="sr-only">Search units</span>
                                <?= cc_icon('search') ?>
                                <input type="search" id="ccUnitSearch" placeholder="Search by unit code or title"
                                    autocomplete="off" />
                            </label>
                            <div class="cc-filter" role="group" aria-label="Filter units by type">
                                <button type="button" class="is-active" data-filter="all" aria-pressed="true">
                                    All <b><?= $unitsCount ?></b>
                                </button>
                                <button type="button" data-filter="core" aria-pressed="false">
                                    Core <b><?= $coreCount ?></b>
                                </button>
                                <button type="button" data-filter="elective" aria-pressed="false">
                                    Elective <b><?= $electiveCount ?></b>
                                </button>
                            </div>
                        </div>

                        <ul class="cc-unit-list" id="ccUnitList">
                            <?php foreach ($course['units'] as $unit): ?>
                            <?php $type = strtolower($unit['type']) === 'core' ? 'core' : 'elective'; ?>
                            <li class="cc-unit" data-type="<?= $type ?>"
                                data-search="<?= htmlspecialchars(strtolower($unit['code'] . ' ' . $unit['title'])) ?>">
                                <span class="cc-unit-code"><?= htmlspecialchars($unit['code']) ?></span>
                                <span class="cc-unit-title"><?= htmlspecialchars($unit['title']) ?></span>
                                <span class="badge <?= $type ?>"><?= htmlspecialchars($unit['type']) ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>

                        <p class="cc-empty" id="ccUnitEmpty" hidden>No units match your search. Try a different word.
                        </p>

                        <div class="cc-units-foot">
                            <span class="cc-units-count" id="ccUnitCount" aria-live="polite"></span>
                            <?php if ($unitsCount > $visibleUnits): ?>
                            <button type="button" class="units-toggle" id="unitsToggle" aria-expanded="false">
                                See all <?= $unitsCount ?> units
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <p>Unit list is available on request. Please contact us for the full course structure.</p>
                    <?php endif; ?>
                </section>

                <!-- Assessment & Delivery -->
                <section class="cc-block" id="assessment" data-spy>
                    <p class="cc-eyebrow">Assessment &amp; delivery</p>
                    <h2 class="cc-h2">How you'll learn</h2>

                    <div class="cc-split">
                        <div class="cc-panel">
                            <h3><?= cc_icon('pencil') ?> Assessment methods</h3>
                            <ul class="cc-checklist">
                                <?php if (!empty($course['assessment'])): ?>
                                <?php foreach ($course['assessment'] as $method): ?>
                                <li><?= cc_icon('check') ?><?= htmlspecialchars($method) ?></li>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <li><?= cc_icon('check') ?>Demonstrations</li>
                                <li><?= cc_icon('check') ?>Written Questions &amp; Answers</li>
                                <li><?= cc_icon('check') ?>Case Studies</li>
                                <li><?= cc_icon('check') ?>Projects</li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="cc-panel">
                            <h3><?= cc_icon('users') ?> Mode of delivery</h3>
                            <p>Face-to-face training combined with independent study.</p>
                            <ul class="cc-chips cc-chips--sm">
                                <li class="cc-chip">Trainer demonstrations</li>
                                <li class="cc-chip">Practical tasks</li>
                                <li class="cc-chip">Case studies</li>
                                <li class="cc-chip">Group work</li>
                                <li class="cc-chip">Simulated workplace</li>
                                <li class="cc-chip">Homework &amp; research</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- RPL & Credit -->
                <section class="cc-block" id="rpl" data-spy>
                    <p class="cc-eyebrow">Save time &amp; money</p>
                    <h2 class="cc-h2">RPL &amp; credit transfer</h2>

                    <div class="cc-split">
                        <div class="cc-feature">
                            <span class="cc-req-ic"><?= cc_icon('refresh') ?></span>
                            <h3>Recognition of Prior Learning (RPL)</h3>
                            <p>You may be eligible for RPL based on previous skills and experience. This can reduce
                                the time and cost of your course.</p>
                            <a href="#enquire" class="cc-link-btn"><span>Check my
                                    eligibility</span><?= cc_icon('arrow') ?></a>
                        </div>
                        <div class="cc-feature">
                            <span class="cc-req-ic"><?= cc_icon('swap') ?></span>
                            <h3>Credit Transfer</h3>
                            <p>If you have previously completed identical units with another Australian RTO, you can
                                apply for Credit Transfer.</p>
                            <a href="#enquire" class="cc-link-btn"><span>Ask about
                                    credit</span><?= cc_icon('arrow') ?></a>
                        </div>
                    </div>
                </section>

                <?php include_once('includes/campuses.php') ?>

                <!-- FAQ -->
                <section class="cc-block" id="faq" data-spy>
                    <p class="cc-eyebrow">FAQ</p>
                    <h2 class="cc-h2">Frequently asked questions</h2>

                    <div class="cc-faq">
                        <div class="cc-faq-item">
                            <h3 class="cc-faq-h">
                                <button type="button" class="cc-faq-q" aria-expanded="false" aria-controls="faq-a1"
                                    id="faq-q1">
                                    What are the entry requirements for this course?
                                    <span class="cc-faq-icon" aria-hidden="true"></span>
                                </button>
                            </h3>
                            <div class="cc-faq-a" id="faq-a1" role="region" aria-labelledby="faq-q1">
                                <p>Applicants must be 18 years or older, hold Australian Year 12 (or equivalent), and
                                    meet the English language requirements (IELTS 6.0 overall or equivalent). A
                                    pre-enrolment needs analysis and interview may also be required.</p>
                            </div>
                        </div>

                        <div class="cc-faq-item">
                            <h3 class="cc-faq-h">
                                <button type="button" class="cc-faq-q" aria-expanded="false" aria-controls="faq-a2"
                                    id="faq-q2">
                                    How long does the course take?
                                    <span class="cc-faq-icon" aria-hidden="true"></span>
                                </button>
                            </h3>
                            <div class="cc-faq-a" id="faq-a2" role="region" aria-labelledby="faq-q2">
                                <p>This course runs for <?= (int)$course['duration_weeks'] ?> weeks
                                    (<?= (int)$course['contact_weeks'] ?> contact weeks) with approximately
                                    <?= (int)$course['hours_per_week'] ?> scheduled hours per week.</p>
                            </div>
                        </div>

                        <div class="cc-faq-item">
                            <h3 class="cc-faq-h">
                                <button type="button" class="cc-faq-q" aria-expanded="false" aria-controls="faq-a3"
                                    id="faq-q3">
                                    Can I apply for RPL or Credit Transfer?
                                    <span class="cc-faq-icon" aria-hidden="true"></span>
                                </button>
                            </h3>
                            <div class="cc-faq-a" id="faq-a3" role="region" aria-labelledby="faq-q3">
                                <p>Yes. If you have previous skills, work experience or formal training, you may be
                                    eligible for Recognition of Prior Learning (RPL) or Credit Transfer. Contact our
                                    team to discuss your situation.</p>
                            </div>
                        </div>

                        <div class="cc-faq-item">
                            <h3 class="cc-faq-h">
                                <button type="button" class="cc-faq-q" aria-expanded="false" aria-controls="faq-a4"
                                    id="faq-q4">
                                    Where is the course delivered?
                                    <span class="cc-faq-icon" aria-hidden="true"></span>
                                </button>
                            </h3>
                            <div class="cc-faq-a" id="faq-a4" role="region" aria-labelledby="faq-q4">
                                <p>Training is delivered face-to-face at our
                                    <?= htmlspecialchars($course['location']) ?> campus (Level 5, 440 Elizabeth Street,
                                    Melbourne VIC 3000).</p>
                            </div>
                        </div>

                        <div class="cc-faq-item">
                            <h3 class="cc-faq-h">
                                <button type="button" class="cc-faq-q" aria-expanded="false" aria-controls="faq-a5"
                                    id="faq-q5">
                                    How do I enrol or get more information?
                                    <span class="cc-faq-icon" aria-hidden="true"></span>
                                </button>
                            </h3>
                            <div class="cc-faq-a" id="faq-a5" role="region" aria-labelledby="faq-q5">
                                <p>You can call us on 1300 195 612, email info@cornell.vic.edu.au, or use the enquire
                                    button on this page. Our team will guide you through the next available intake and
                                    enrolment process.</p>
                            </div>
                        </div>
                    </div>
                </section>

            </div>


        </div>

        <!-- Mobile sticky enquiry bar -->
        <div class="cc-mobilebar" id="ccMobileBar">
            <div class="cc-mobilebar-info">
                <strong>$<?= number_format((int)$course['enrolment_fee']) ?></strong>
                <span>enrolment fee</span>
            </div>
            <a href="#enquire" class="btn-pill btn-pill-accent">
                Enquire <span class="btn-icon">→</span>
            </a>
        </div>
    </section>

    <!-- ===================== CTA ===================== -->
    <section class="course-cta" id="enquire">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Start your career with <?= htmlspecialchars($course['title']) ?></h2>
                    <p>Multiple intakes available throughout the year. Contact us for the next available start date and
                        current tuition fees.</p>
                </div>
                <div class="cta-actions">
                    <a href="tel:1300195612" class="btn-pill btn-pill-accent">Call 1300 195 612</a>
                    <a href="mailto:info@cornell.vic.edu.au" class="btn-pill btn-pill-secondary">Email Us</a>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/scripts.php') ?>
    <script src="assets/js/course-page.js"></script>
</body>

</html>