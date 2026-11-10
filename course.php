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
$heroImage       = $course['hero_image'] ?? 'assets/images/courses/default.jpg';
$unitsCount      = count($course['units'] ?? []);
$visibleUnits    = 8;
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
  <meta property="og:image" content="<?= htmlspecialchars('https://www.cornell.vic.edu.au/' . ltrim($heroImage, '/')) ?>" />
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

  <?php include_once('includes/stylesheets.php') ?>
  <link rel="stylesheet" href="assets/css/page/course-page.css" />

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
    <img
      class="course-hero-bg"
      src="<?= htmlspecialchars($heroImage) ?>"
      alt="<?= htmlspecialchars($course['title']) ?>"
      width="1470"
      height="800"
      fetchpriority="high" />
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
              <?= (int)$course['contact_weeks'] ?> contact weeks · <?= (int)$course['hours_per_week'] ?> hrs/week
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
    <div class="container">
      <div class="course-layout">

        <!-- LEFT COLUMN -->
        <div class="course-main">

          <!-- Description -->
          <article class="content-block">
            <h2>Course Description</h2>
            <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>
          </article>

          <!-- Pathways -->
          <article class="content-block">
            <h2>Course Pathways</h2>
            <div class="pathway-grid">
              <div class="pathway-card">
                <h3>Further Study</h3>
                <?php if (!empty($course['pathways_study'])): ?>
                  <ul>
                    <?php foreach ($course['pathways_study'] as $pathway): ?>
                      <li><?= htmlspecialchars($pathway) ?></li>
                    <?php endforeach; ?>
                  </ul>
                <?php else: ?>
                  <p>Contact us for further study options.</p>
                <?php endif; ?>
              </div>
              <div class="pathway-card">
                <h3>Employment Outcomes</h3>
                <?php if (!empty($course['pathways_job'])): ?>
                  <p>This qualification provides a pathway to work as a
                    <strong><?= htmlspecialchars(implode(', ', $course['pathways_job'])) ?></strong>.
                  </p>
                <?php endif; ?>
                <p class="note">Pathways are a guide only and are not prerequisites for enrolment.</p>
              </div>
            </div>
          </article>

          <!-- Entry Requirements (COMMON – hardcoded) -->
          <article class="content-block" id="entry">
            <h2>Entry Requirements</h2>

            <h3>English Language Proficiency</h3>
            <div class="table-wrap">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Evidence</th>
                    <th>Minimum Score</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>IELTS Academic</td>
                    <td>6.0 overall</td>
                  </tr>
                  <tr>
                    <td>TOEFL iBT</td>
                    <td>60 – 78</td>
                  </tr>
                  <tr>
                    <td>PTE Academic</td>
                    <td>51.6</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="req-grid">
              <div class="req-item">
                <h4>Academic</h4>
                <p>Australian Year 12 (or equivalent from other countries)</p>
              </div>
              <div class="req-item">
                <h4>Age</h4>
                <p>Must be 18 years or older at course commencement</p>
              </div>
              <div class="req-item">
                <h4>Other</h4>
                <p>Pre-enrolment needs analysis, interview and LLND assessment may be required</p>
              </div>
            </div>
          </article>

          <!-- Course Structure -->
          <article class="content-block" id="structure">
            <h2>Course Structure</h2>
            <p class="structure-intro">
              <?= $unitsCount ?> units in total — Core + Elective units covering practical and technical skills.
            </p>

            <?php if (!empty($course['units'])): ?>
              <div class="table-wrap" id="unitsTableWrap">
                <table class="data-table units-table">
                  <thead>
                    <tr>
                      <th>Unit Code</th>
                      <th>Unit Title</th>
                      <th>Type</th>
                    </tr>
                  </thead>
                  <tbody id="unitsTableBody">
                    <?php foreach ($course['units'] as $index => $unit): ?>
                      <tr class="<?= $index >= $visibleUnits ? 'unit-row-hidden' : '' ?>">
                        <td><?= htmlspecialchars($unit['code']) ?></td>
                        <td><?= htmlspecialchars($unit['title']) ?></td>
                        <td>
                          <span class="badge <?= strtolower($unit['type']) === 'core' ? 'core' : 'elective' ?>">
                            <?= htmlspecialchars($unit['type']) ?>
                          </span>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <?php if ($unitsCount > $visibleUnits): ?>
                <button type="button" class="units-toggle" id="unitsToggle">
                  See all <?= $unitsCount ?> units
                </button>
              <?php endif; ?>
            <?php else: ?>
              <p>Unit list is available on request. Please contact us for the full course structure.</p>
            <?php endif; ?>
          </article>

          <!-- Assessment & Delivery (COMMON – hardcoded) -->
          <div class="two-col-blocks">
            <article class="content-block">
              <h2>Assessment Methods</h2>
              <ul class="check-list">
                <?php if (!empty($course['assessment'])): ?>
                  <?php foreach ($course['assessment'] as $method): ?>
                    <li><?= htmlspecialchars($method) ?></li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li>Demonstrations</li>
                  <li>Written Questions &amp; Answers</li>
                  <li>Case Studies</li>
                  <li>Projects</li>
                <?php endif; ?>
              </ul>
            </article>

            <article class="content-block">
              <h2>Mode of Delivery</h2>
              <p>
                Face-to-face training combined with independent study. Classes include trainer demonstrations, practical tasks, case studies, group work and simulated workplace activities. Students also complete homework, research and out-of-class assessments.
              </p>
            </article>
          </div>

          <!-- RPL & Credit (COMMON – hardcoded) -->
          <div class="two-col-blocks">
            <article class="content-block">
              <h2>Recognition of Prior Learning (RPL)</h2>
              <p>
                You may be eligible for RPL based on previous skills and experience. This can reduce the time and cost of your course. Contact us to discuss your eligibility.
              </p>
            </article>

            <article class="content-block">
              <h2>Credit Transfer</h2>
              <p>
                If you have previously completed identical units with another Australian RTO, you can apply for Credit Transfer.
              </p>
            </article>
          </div>

        </div>

        <!-- RIGHT SIDEBAR -->
        <aside class="course-sidebar">
          <div class="sidebar-card sticky-card">
            <h3>Ready to start?</h3>
            <p>Speak with our team about intakes, fees and enrolment.</p>

            <a href="#enquire" class="btn-pill btn-pill-accent full-width">
              Enquire / Apply <span class="btn-icon">→</span>
            </a>

            <div class="sidebar-meta">
              <div>
                <span>Duration</span>
                <strong><?= (int)$course['duration_weeks'] ?> weeks</strong>
              </div>
              <div>
                <span>Weekly hours</span>
                <strong><?= (int)$course['hours_per_week'] ?> hours</strong>
              </div>
              <div>
                <span>CRICOS</span>
                <strong><?= htmlspecialchars($course['cricos']) ?></strong>
              </div>
            </div>

            <div class="sidebar-contact">
              <a href="tel:1300195612">1300 195 612</a>
              <a href="mailto:info@cornell.vic.edu.au">info@cornell.vic.edu.au</a>
            </div>
          </div>
        </aside>

      </div>
    </div>
  </section>

  <!-- ===================== CTA ===================== -->
  <section class="course-cta" id="enquire">
    <div class="container">
      <div class="cta-box">
        <div>
          <h2>Start your career with <?= htmlspecialchars($course['title']) ?></h2>
          <p>Multiple intakes available throughout the year. Contact us for the next available start date and current tuition fees.</p>
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