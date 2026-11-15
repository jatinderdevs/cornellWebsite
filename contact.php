<?php

/**
 * Contact Page
 * Enquiry form + FAQ. Submissions are handled by includes/contact-handler.php
 */

session_start();

require_once 'data/dbcourses.php';
require_once 'includes/contact-handler.php';

if (empty($_SESSION['contact_csrf'])) {
  $_SESSION['contact_csrf'] = bin2hex(random_bytes(16));
}

/* ---------- Handle submission ---------- */
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = contact_handle($_POST, $courses);

  $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
  if ($isAjax) {
    http_response_code($result['status']);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
      'ok'      => $result['ok'],
      'message' => $result['message'],
      'errors'  => $result['errors'],
    ]);
    exit;
  }
}

/* ---------- View helpers ---------- */
function ct_e($v)
{
  return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

$sent   = $result && $result['ok'];
$errors = $result ? $result['errors'] : [];
$old    = ($result && !$result['ok']) ? $_POST : [];

$val = function ($key) use ($old) {
  return (isset($old[$key]) && is_string($old[$key])) ? $old[$key] : '';
};
$err = function ($key) use ($errors) {
  return isset($errors[$key]) ? $errors[$key] : '';
};

// Topic: sticky value, else ?topic= deep link, else none
$selTopic = $val('topic');
if ($selTopic === '' && isset($_GET['topic']) && is_string($_GET['topic'])) {
  $selTopic = $_GET['topic'];
}
if (!isset(CONTACT_TOPICS[$selTopic])) {
  $selTopic = '';
}

// Courses grouped by category for the dropdown
$coursesByCat = [];
foreach ($courses as $c) {
  $coursesByCat[$c['category']][] = $c['title'];
}

/* ---------- FAQ (single source for page + schema) ---------- */
$faqs = [
  [
    'q' => 'How do I enrol?',
    'a' => 'Send us an enquiry using the form above or call <a href="tel:1300195612">1300 195 612</a>. Our team will guide you through the next available intake. International students can also download the application form from <a href="student-support.php#forms">Student Forms</a>.',
  ],
  [
    'q' => 'Which courses can I study?',
    'a' => 'We offer nationally recognised Hospitality and Construction qualifications, from Certificate III to Advanced Diploma. See <a href="courses.php">Courses</a> for duration, units and pathways.',
  ],
  [
    'q' => 'Where are your campuses?',
    'a' => 'Melbourne: Level 5, 440 Elizabeth Street, Melbourne VIC 3000. Brisbane: 161 Brunswick Street, Fortitude Valley QLD 4006. Each course page shows which campus it runs at.',
  ],
  [
    'q' => 'Can I get credit for previous study or work experience?',
    'a' => 'You may be able to. We offer Recognition of Prior Learning (RPL) and credit transfer. The forms are on <a href="student-support.php#forms">Student Forms</a>, or tell us about your background in the form above and we will advise.',
  ],
  [
    'q' => 'I am an international student. Who can help with visas, OSHC or orientation?',
    'a' => 'Our team can help with visa and ESOS information, orientation and OSHC guidance. Choose &ldquo;International students&rdquo; as your topic above, or visit <a href="student-support.php">Student Support</a>.',
  ],
  [
    'q' => 'How do I give feedback or make a complaint?',
    'a' => 'Choose &ldquo;Feedback&rdquo; in the form above or email <a href="mailto:info@cornell.vic.edu.au">info@cornell.vic.edu.au</a>. For formal complaints and appeals, our <a href="student-support.php#policies">Feedback, Complaints &amp; Appeals policy</a> explains the process.',
  ],
];

$faqSchema = [
  '@context'   => 'https://schema.org',
  '@type'      => 'FAQPage',
  'mainEntity' => array_map(function ($f) {
    return [
      '@type'          => 'Question',
      'name'           => $f['q'],
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text'  => html_entity_decode(strip_tags($f['a']), ENT_QUOTES, 'UTF-8'),
      ],
    ];
  }, $faqs),
];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Contact Us | Cornell Institute of Training</title>
    <meta name="description"
        content="Contact Cornell Institute of Training – enrolment, course and international student enquiries, feedback and FAQs. Melbourne &amp; Brisbane campuses." />
    <link rel="canonical" href="https://www.cornell.vic.edu.au/contact.php" />

    <!-- Open Graph -->
    <meta property="og:title" content="Contact Us | Cornell Institute of Training" />
    <meta property="og:description"
        content="Questions about courses, enrolment or student life? Send us a message or call 1300 195 612." />
    <meta property="og:url" content="https://www.cornell.vic.edu.au/contact.php" />
    <meta property="og:type" content="website" />

    <script type="application/ld+json">
    <?= json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>
    </script>

    <?php include_once('includes/stylesheets.php') ?>
    <link rel="stylesheet" href="assets/css/page/contact.css" />
</head>

<body>
    <?php include_once('includes/navbar.php') ?>

    <!-- ===================== PAGE HEADER ===================== -->
    <section class="page-header">
        <img class="page-header-bg" src="assets/images/campus/campus.jpg" alt="" />
        <div class="page-header-overlay"></div>

        <div class="container">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="index.php">Home</a>
                <span>/</span>
                <span>Contact</span>
            </nav>

            <div class="page-header-content">
                <span class="page-label">Get in touch</span>
                <h1 class="heading">Contact <span>Us</span></h1>
                <p>
                    Questions about courses, enrolment or student life? Send us a message and the right
                    team will get back to you.
                </p>
            </div>
        </div>
    </section>

    <!-- ===================== QUICK CONTACT ===================== -->
    <section class="ct-channels" aria-label="Contact details">
        <div class="container">
            <div class="ct-channels-grid">
                <a href="tel:1300195612" class="ct-channel">
                    <span class="ct-channel-icon" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                    </span>
                    <span class="ct-channel-body">
                        <span class="ct-channel-label">Call us</span>
                        <span class="ct-channel-value">1300 195 612</span>
                        <span class="ct-channel-hint">Enrolments &amp; general enquiries</span>
                    </span>
                </a>

                <a href="mailto:info@cornell.vic.edu.au" class="ct-channel">
                    <span class="ct-channel-icon" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="m22 7-10 5L2 7" />
                        </svg>
                    </span>
                    <span class="ct-channel-body">
                        <span class="ct-channel-label">Email us</span>
                        <span class="ct-channel-value">info@cornell.vic.edu.au</span>
                        <span class="ct-channel-hint">Questions, feedback, documents</span>
                    </span>
                </a>

                <a href="https://maps.google.com/?q=Level+5,+440+Elizabeth+Street,+Melbourne+VIC+3000" target="_blank"
                    rel="noopener" class="ct-channel">
                    <span class="ct-channel-icon" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </span>
                    <span class="ct-channel-body">
                        <span class="ct-channel-label">Melbourne campus</span>
                        <span class="ct-channel-value">Level 5, 440 Elizabeth Street</span>
                        <span class="ct-channel-hint">Melbourne VIC 3000 · Directions ↗</span>
                    </span>
                </a>

                <a href="https://maps.google.com/?q=161+Brunswick+Street,+Fortitude+Valley+QLD+4006" target="_blank"
                    rel="noopener" class="ct-channel">
                    <span class="ct-channel-icon" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </span>
                    <span class="ct-channel-body">
                        <span class="ct-channel-label">Brisbane campus</span>
                        <span class="ct-channel-value">161 Brunswick Street</span>
                        <span class="ct-channel-hint">Fortitude Valley QLD 4006 · Directions ↗</span>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- ===================== FORM ===================== -->
    <section class="ct-main">
        <div class="container">
            <div class="ct-main-grid">

                <!-- Form card -->
                <div class="ct-form-card" id="enquire">
                    <div class="ct-form-head">
                        <h2 class="ct-form-title">Send us a message</h2>
                        <p>Pick a topic, tell us a little about you, and we&rsquo;ll take it from there.</p>
                    </div>

                    <form id="contactForm" method="post" action="contact.php#enquire" novalidate
                        <?= $sent ? 'hidden' : '' ?>>
                        <input type="hidden" name="csrf" value="<?= ct_e($_SESSION['contact_csrf']) ?>" />

                        <!-- Honeypot (hidden from people) -->
                        <div class="ct-hp" aria-hidden="true">
                            <label for="ctWebsite">Website</label>
                            <input type="text" id="ctWebsite" name="website" tabindex="-1" autocomplete="off" />
                        </div>

                        <!-- Topic -->
                        <fieldset class="ct-fieldset ct-field" data-field="topic">
                            <legend class="ct-legend">What&rsquo;s it about? <span class="ct-req">*</span></legend>
                            <div class="ct-chips" role="radiogroup">
                                <?php foreach (CONTACT_TOPICS as $key => $label): ?>
                                <label class="ct-chip">
                                    <input type="radio" name="topic" value="<?= ct_e($key) ?>"
                                        <?= $selTopic === $key ? 'checked' : '' ?> />
                                    <span><?= ct_e($label) ?></span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                            <p class="ct-error" id="err-topic" role="alert"><?= ct_e($err('topic')) ?></p>
                        </fieldset>

                        <div class="ct-grid">
                            <div class="ct-field" data-field="name">
                                <label for="ctName">Full name <span class="ct-req">*</span></label>
                                <input type="text" id="ctName" name="name" autocomplete="name" maxlength="100"
                                    value="<?= ct_e($val('name')) ?>" aria-describedby="err-name" />
                                <p class="ct-error" id="err-name" role="alert"><?= ct_e($err('name')) ?></p>
                            </div>

                            <div class="ct-field" data-field="email">
                                <label for="ctEmail">Email <span class="ct-req">*</span></label>
                                <input type="email" id="ctEmail" name="email" autocomplete="email" maxlength="254"
                                    value="<?= ct_e($val('email')) ?>" aria-describedby="err-email" />
                                <p class="ct-error" id="err-email" role="alert"><?= ct_e($err('email')) ?></p>
                            </div>

                            <div class="ct-field" data-field="phone">
                                <label for="ctPhone">Phone <span class="ct-opt">(optional)</span></label>
                                <input type="tel" id="ctPhone" name="phone" autocomplete="tel" maxlength="20"
                                    value="<?= ct_e($val('phone')) ?>" aria-describedby="err-phone" />
                                <p class="ct-error" id="err-phone" role="alert"><?= ct_e($err('phone')) ?></p>
                            </div>

                            <div class="ct-field" data-field="campus">
                                <label for="ctCampus">Campus <span class="ct-opt">(optional)</span></label>
                                <select id="ctCampus" name="campus" aria-describedby="err-campus">
                                    <option value="">Select a campus</option>
                                    <?php foreach (CONTACT_CAMPUSES as $campus): ?>
                                    <option value="<?= ct_e($campus) ?>"
                                        <?= $val('campus') === $campus ? 'selected' : '' ?>>
                                        <?= ct_e($campus) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="ct-error" id="err-campus" role="alert"><?= ct_e($err('campus')) ?></p>
                            </div>

                            <div class="ct-field ct-field-full" data-field="course">
                                <label for="ctCourse">Course of interest <span class="ct-opt">(optional)</span></label>
                                <select id="ctCourse" name="course" aria-describedby="err-course">
                                    <option value="">Not sure yet / not applicable</option>
                                    <?php foreach ($coursesByCat as $cat => $titles): ?>
                                    <optgroup label="<?= ct_e($cat) ?>">
                                        <?php foreach ($titles as $title): ?>
                                        <option value="<?= ct_e($title) ?>"
                                            <?= $val('course') === $title ? 'selected' : '' ?>>
                                            <?= ct_e($title) ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <?php endforeach; ?>
                                </select>
                                <p class="ct-error" id="err-course" role="alert"><?= ct_e($err('course')) ?></p>
                            </div>

                            <div class="ct-field ct-field-full" data-field="message">
                                <label for="ctMessage">Your message <span class="ct-req">*</span></label>
                                <textarea id="ctMessage" name="message" rows="5" maxlength="3000"
                                    aria-describedby="err-message"><?= ct_e($val('message')) ?></textarea>
                                <p class="ct-error" id="err-message" role="alert"><?= ct_e($err('message')) ?></p>
                            </div>
                        </div>

                        <div class="ct-field ct-consent" data-field="consent">
                            <input type="checkbox" id="ctConsent" name="consent" value="1"
                                <?= !empty($old['consent']) ? 'checked' : '' ?> aria-describedby="err-consent" />
                            <div>
                                <label for="ctConsent">
                                    I&rsquo;m happy for Cornell to contact me about this enquiry. See our
                                    <a href="student-support.php#privacy">privacy information</a>.
                                </label>
                                <p class="ct-error" id="err-consent" role="alert"><?= ct_e($err('consent')) ?></p>
                            </div>
                        </div>

                        <div class="ct-actions">
                            <button type="submit" class="btn-pill btn-pill-accent" id="ctSubmit">
                                <span class="ct-submit-label">Send message</span> <span class="btn-icon">↗</span>
                            </button>
                        </div>

                        <p class="ct-status <?= ($result && !$result['ok'] && $result['message']) ? 'is-error' : '' ?>"
                            id="ctStatus" role="alert">
                            <?= ($result && !$result['ok']) ? ct_e($result['message']) : '' ?></p>
                    </form>

                    <!-- Success state -->
                    <div class="ct-success" id="ctSuccess" <?= $sent ? '' : 'hidden' ?>>
                        <div class="ct-success-icon" aria-hidden="true">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5" />
                            </svg>
                        </div>
                        <h2 tabindex="-1">Message sent</h2>
                        <p>Thanks &ndash; we&rsquo;ve received your enquiry and will be in touch soon. Need us sooner?
                            Call <a href="tel:1300195612">1300 195 612</a>.</p>
                        <button type="button" class="btn-pill btn-pill-primary" id="ctAnother">
                            Send another <span class="btn-icon">↗</span>
                        </button>
                    </div>
                </div>

                <!-- Aside -->
                <aside class="ct-aside" aria-label="Other ways we can help">
                    <div class="ct-aside-card">
                        <h3>Looking for something else?</h3>
                        <ul class="ct-links">
                            <li>
                                <a href="courses.php" class="ct-link">
                                    <span><strong>Browse courses</strong><small>Duration, units and
                                            pathways</small></span>
                                    <span class="ct-link-arrow" aria-hidden="true">→</span>
                                </a>
                            </li>
                            <li>
                                <a href="student-support.php#forms" class="ct-link">
                                    <span><strong>Student forms</strong><small>Enrolment, RPL, deferral and
                                            more</small></span>
                                    <span class="ct-link-arrow" aria-hidden="true">→</span>
                                </a>
                            </li>
                            <li>
                                <a href="student-support.php#policies" class="ct-link">
                                    <span><strong>Feedback &amp; complaints</strong><small>Read our policy and
                                            process</small></span>
                                    <span class="ct-link-arrow" aria-hidden="true">→</span>
                                </a>
                            </li>
                            <li>
                                <a href="agents.php" class="ct-link">
                                    <span><strong>Education agents</strong><small>Partner with Cornell</small></span>
                                    <span class="ct-link-arrow" aria-hidden="true">→</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- ===================== FAQ ===================== -->
    <section class="ct-faq" id="faq">
        <div class="container">
            <div class="ct-section-header">
                <span class="section-label">FAQ</span>
                <h2 class="heading">Frequently asked <span>questions</span></h2>
            </div>

            <div class="ct-faq-list">
                <?php foreach ($faqs as $i => $faq): ?>
                <div class="ct-faq-item">
                    <h3 class="ct-faq-h">
                        <button type="button" class="ct-faq-question" aria-expanded="false"
                            aria-controls="faq-a<?= $i ?>" id="faq-q<?= $i ?>">
                            <?= ct_e($faq['q']) ?>
                            <span class="ct-faq-icon" aria-hidden="true"></span>
                        </button>
                    </h3>
                    <div class="ct-faq-answer" id="faq-a<?= $i ?>" role="region" aria-labelledby="faq-q<?= $i ?>">
                        <p><?= $faq['a'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/scripts.php') ?>
    <script src="assets/js/contact.js"></script>
</body>

</html>