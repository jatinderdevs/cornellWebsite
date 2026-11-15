<?php
require_once 'data/dbcourses.php';

// Separate groups
$construction = [];
$hospitality  = [];

foreach ($courses as $key => $course) {
    $cat = strtolower(trim($course['category'] ?? ''));

    if ($cat === 'construction') {
        $construction[$key] = $course;
    } elseif ($cat === 'hospitality') {
        $hospitality[$key] = $course;
    }
}

include_once('data/dbagents.php');

$agent_list      = get_agents();
$agent_total     = count($agent_list);
$agent_countries = agent_countries($agent_list);

/** Small inline icons used on this page. */
function ag_icon(string $name): string
{
    $paths = [
        'pin'   => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'mail'  => '<path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><polyline points="22,6 12,13 2,6"/>',
        'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'globe' => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
        'search' => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'book'  => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
        'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'megaphone' => '<path d="M3 11v2a1 1 0 0 0 1 1h3l5 4V6L7 10H4a1 1 0 0 0-1 1z"/><path d="M16 8a5 5 0 0 1 0 8"/><path d="M19 5a9 9 0 0 1 0 14"/>',
        'clock' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
    ];
    $p = $paths[$name] ?? '';
    return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $p . '</svg>';
}

function ag_e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

$apply_url   = agent_url($agent_settings['apply_url'] ?? '');
$form_url    = trim($agent_settings['form_url'] ?? '');
$support_em  = $agent_settings['support_email'] ?? 'info@cornell.vic.edu.au';
$support_ph  = $agent_settings['support_phone'] ?? '1300 195 612';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Education Agents | Cornell Institute of Training</title>
    <meta name="description"
        content="Find a Cornell Institute of Training education agent or become a partner. Nationally recognised vocational courses in Melbourne & Brisbane." />
    <link rel="canonical" href="https://www.cornell.vic.edu.au/agents.php" />

    <meta property="og:title" content="Education Agents | Cornell Institute of Training" />
    <meta property="og:description"
        content="Find a Cornell education agent or become a partner – nationally recognised vocational courses in Melbourne & Brisbane." />
    <meta property="og:url" content="https://www.cornell.vic.edu.au/agents.php" />
    <meta property="og:type" content="website" />

    <?php include_once('includes/stylesheets.php') ?>
    <link rel="stylesheet" href="assets/css/page/agents.css" />
    <link rel="stylesheet" href="assets/css/sections/campuses.css" />

</head>

<body>
    <?php include_once('includes/navbar.php') ?>

    <!-- ===================== PAGE HEADER ===================== -->
    <section class="page-header">
        <img class="page-header-bg"
            src="https://plus.unsplash.com/premium_photo-1681823100546-0541b5880f14?q=80&w=1470&auto=format&fit=crop"
            alt="" />
        <div class="page-header-overlay"></div>

        <div class="container">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="index.php">Home</a>
                <span>/</span>
                <span>Education Agents</span>
            </nav>

            <div class="page-header-content">
                <span class="page-label">Partner with us</span>
                <h1 class="heading">Education <span>Agents</span></h1>
                <p>Find an approved Cornell agent near you, or apply to become one.</p>
                <div class="header-actions">
                    <a href="#agents" class="btn-pill btn-pill-accent">
                        Find an agent <span class="btn-icon">→</span>
                    </a>
                    <a href="#become-partner" class="btn-pill btn-pill-soft">
                        Become a partner <span class="btn-icon">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== FACTS BAR ===================== -->
    <section class="ag-facts" aria-label="Cornell at a glance">
        <div class="container">
            <div class="ag-facts-grid">
                <div class="ag-fact">
                    <span class="ag-fact-number">6074</span>
                    <span class="ag-fact-label">RTO code (TOID)</span>
                </div>
                <div class="ag-fact">
                    <span class="ag-fact-number">03892A</span>
                    <span class="ag-fact-label">CRICOS code</span>
                </div>
                <div class="ag-fact">
                    <span class="ag-fact-number">2</span>
                    <span class="ag-fact-label">Campuses</span>
                </div>
                <div class="ag-fact">
                    <span class="ag-fact-number">9</span>
                    <span class="ag-fact-label">CRICOS courses</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== AGENT DIRECTORY ===================== -->
    <section class="ag-section" id="agents">
        <div class="container">
            <div class="ag-section-header">
                <span class="section-label">Our partners</span>
                <h2 class="heading">Registered <span>education agents</span></h2>
                <p>Students can enrol through any agent below. Contact them directly for advice and applications.</p>
            </div>

            <?php if ($agent_total > 0): ?>

            <div class="ag-toolbar">
                <div class="ag-search">
                    <?= ag_icon('search') ?>
                    <input type="search" id="agent-search" placeholder="Search by agency, city or country"
                        aria-label="Search agents" autocomplete="off" />
                </div>

                <?php if (count($agent_countries) > 1): ?>
                <div class="ag-filters" role="group" aria-label="Filter by country">
                    <button type="button" class="ag-filter-pill active" data-filter="all">All</button>
                    <?php foreach ($agent_countries as $key => $label): ?>
                    <button type="button" class="ag-filter-pill"
                        data-filter="<?= ag_e($key) ?>"><?= ag_e($label) ?></button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <p class="ag-count" id="agent-count" aria-live="polite" data-total="<?= $agent_total ?>">
                Showing <?= $agent_total ?> of <?= $agent_total ?> agent<?= $agent_total === 1 ? '' : 's' ?>
            </p>

            <div class="ag-agents-grid" id="agent-grid">
                <?php foreach ($agent_list as $a):
                        $name    = $a['name'];
                        $country = trim($a['country'] ?? '');
                        $city    = trim($a['city'] ?? '');
                        $address = trim($a['address'] ?? '');
                        $email   = trim($a['email'] ?? '');
                        $phone   = trim($a['phone'] ?? '');
                        $site    = agent_url($a['website'] ?? '');
                        $logo    = trim($a['logo'] ?? '');
                        $place   = trim($city . ($city !== '' && $country !== '' ? ', ' : '') . $country);
                        $email_ok = $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL);
                        $search  = strtolower(implode(' ', [$name, $country, $city, $address]));
                    ?>
                <article class="ag-agent-card" data-country="<?= ag_e(strtolower($country)) ?>"
                    data-search="<?= ag_e($search) ?>">
                    <header class="ag-agent-head">
                        <div class="ag-agent-avatar">
                            <?php if ($logo !== ''): ?>
                            <img src="assets/img/agents/<?= ag_e(rawurlencode($logo)) ?>" alt="" loading="lazy" />
                            <?php else: ?>
                            <span><?= ag_e(agent_initials($name)) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="ag-agent-title">
                            <h3><?= ag_e($name) ?></h3>
                            <?php if ($place !== ''): ?>
                            <span class="ag-agent-place"><?= ag_e($place) ?></span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <?php if ($address !== '' || $phone !== ''): ?>
                    <ul class="ag-agent-meta">
                        <?php if ($address !== ''): ?>
                        <li><?= ag_icon('pin') ?><span><?= ag_e($address) ?></span></li>
                        <?php endif; ?>
                        <?php if ($phone !== ''): ?>
                        <li><?= ag_icon('phone') ?><a
                                href="tel:<?= ag_e(preg_replace('/[^\d+]/', '', $phone)) ?>"><?= ag_e($phone) ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <?php endif; ?>

                    <?php if ($email_ok || $site): ?>
                    <div class="ag-agent-actions">
                        <?php if ($email_ok): ?>
                        <a class="ag-action" href="mailto:<?= ag_e($email) ?>">
                            <?= ag_icon('mail') ?> Email
                        </a>
                        <?php endif; ?>
                        <?php if ($site): ?>
                        <a class="ag-action" href="<?= ag_e($site) ?>" target="_blank" rel="noopener noreferrer">
                            <?= ag_icon('globe') ?> <?= ag_e(agent_host($site)) ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
            </div>

            <div class="ag-empty" id="agent-none" hidden>
                <strong>No agents match your search.</strong>
                <span>Try a different name or country, or <a href="mailto:<?= ag_e($support_em) ?>">email us</a> and
                    we will point you to the right agent.</span>
            </div>

            <?php else: ?>

            <div class="ag-empty ag-empty-static">
                <strong>Our agent list is being updated.</strong>
                <span>To find an agent in your country, contact us on <a
                        href="tel:<?= ag_e(preg_replace('/[^\d+]/', '', $support_ph)) ?>"><?= ag_e($support_ph) ?></a>
                    or <a href="mailto:<?= ag_e($support_em) ?>"><?= ag_e($support_em) ?></a>.</span>
            </div>

            <?php endif; ?>
        </div>
    </section>

    <!-- ===================== BECOME A PARTNER ===================== -->
    <section class="ag-section ag-section-alt" id="become-partner">
        <div class="container">
            <div class="ag-section-header">
                <span class="section-label">Join our network</span>
                <h2 class="heading">Become a <span>partner</span> in 3 steps</h2>
                <p>We welcome professional agents who share our commitment to ethical recruitment and student success.
                </p>
            </div>

            <ol class="ag-steps">
                <li class="ag-step">
                    <span class="ag-step-num">1</span>
                    <h3>Apply</h3>
                    <p>Complete the online application on our agent
                        portal<?= $form_url !== '' ? ' or send us the application form' : '' ?>.</p>
                </li>
                <li class="ag-step">
                    <span class="ag-step-num">2</span>
                    <h3>We review</h3>
                    <p>Our team assesses your application and contacts you.</p>
                </li>
                <li class="ag-step">
                    <span class="ag-step-num">3</span>
                    <h3>Start recruiting</h3>
                    <p>Sign the agent agreement and get access to materials and support.</p>
                </li>
            </ol>

            <div class="ag-apply-actions">
                <?php if ($apply_url): ?>
                <a href="<?= ag_e($apply_url) ?>" target="_blank" rel="noopener" class="btn-pill btn-pill-accent"
                    id="agent-portal-link">
                    Apply via Agent Portal <span class="btn-icon">→</span>
                </a>
                <?php endif; ?>
                <?php if ($form_url !== ''): ?>
                <a href="<?= ag_e($form_url) ?>" class="btn-pill ag-btn-outline" download>
                    Download application form <span class="btn-icon">↓</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ===================== BENEFITS ===================== -->
    <section class="ag-section" id="benefits">
        <div class="container">
            <div class="ag-section-header">
                <span class="section-label">Why partner with us</span>
                <h2 class="heading">Benefits for <span>agents</span></h2>
            </div>

            <div class="ag-benefits-grid">
                <article class="ag-benefit-card">
                    <div class="ag-benefit-icon"><?= ag_icon('book') ?></div>
                    <h3>Quality courses</h3>
                    <p>Nationally recognised qualifications with practical, job-ready outcomes.</p>
                </article>

                <article class="ag-benefit-card">
                    <div class="ag-benefit-icon"><?= ag_icon('users') ?></div>
                    <h3>Student support</h3>
                    <p>Academic, wellbeing and international student services.</p>
                </article>

                <article class="ag-benefit-card">
                    <div class="ag-benefit-icon"><?= ag_icon('megaphone') ?></div>
                    <h3>Marketing support</h3>
                    <p>Course information, logos and clear promotion guidelines.</p>
                </article>

                <article class="ag-benefit-card">
                    <div class="ag-benefit-icon"><?= ag_icon('clock') ?></div>
                    <h3>Clear processes</h3>
                    <p>Simple application, enrolment and commission steps.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- ===================== COURSES ===================== -->
    <section class="ag-section ag-section-alt" id="courses">
        <div class="container">
            <div class="ag-section-header">
                <span class="section-label">Our programs</span>
                <h2 class="heading">Courses we offer</h2>
            </div>

            <div class="ag-courses-grid">
                <div class="ag-course-card">
                    <div class="ag-course-tag">Hospitality</div>
                    <h3>Hospitality &amp; Cookery</h3>
                    <ul class="ag-chips">
                        <?php foreach ($hospitality  as $key => $course): ?>
                        <li class="course_chip">
                            <a href="course.php?course=<?= urlencode($key) ?>">
                                <?= htmlspecialchars($course['code'] ?? $key) ?> -
                                <?= htmlspecialchars($course['name'] ?? $course['title'] ?? '') ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <span class="ag-course-link">View courses →</span>
                </div>

                <div class="ag-course-card">
                    <div class="ag-course-tag">Construction</div>
                    <h3>Building &amp; Trades</h3>
                    <ul class="ag-chips">
                        <?php foreach ($construction as $key => $course): ?>
                        <li class="course_chip">
                            <a class="course_chip" href="course.php?course=<?= urlencode($key) ?>">
                                <?= htmlspecialchars($course['code'] ?? $key) ?> -
                                <?= htmlspecialchars($course['name'] ?? $course['title'] ?? '') ?>
                            </a>


                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <span class="ag-course-link">View courses →</span>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('includes/campuses.php') ?>

    <!-- ===================== FAQ ===================== -->
    <section class="ag-section ag-section-alt" id="faq">
        <div class="container">
            <div class="ag-section-header">
                <span class="section-label">FAQ</span>
                <h2 class="heading">Common questions from <span>agents</span></h2>
            </div>

            <div class="ag-faq-list">
                <div class="ag-faq-item">
                    <button class="ag-faq-question" aria-expanded="false">
                        How do I become an education agent?
                        <span class="ag-faq-icon"></span>
                    </button>
                    <div class="ag-faq-answer">
                        <p>Use the “Apply via Agent Portal” button above. Our team reviews your application and
                            contacts you.</p>
                    </div>
                </div>

                <div class="ag-faq-item">
                    <button class="ag-faq-question" aria-expanded="false">
                        Which courses can I promote?
                        <span class="ag-faq-icon"></span>
                    </button>
                    <div class="ag-faq-answer">
                        <p>All our CRICOS-registered Hospitality and Construction courses. See the
                            <a href="courses.php">Courses page</a> for details.
                        </p>
                    </div>
                </div>

                <div class="ag-faq-item">
                    <button class="ag-faq-question" aria-expanded="false">
                        Where are the campuses?
                        <span class="ag-faq-icon"></span>
                    </button>
                    <div class="ag-faq-answer">
                        <p>Melbourne: Level 5, 440 Elizabeth Street, VIC 3000.<br />
                            Brisbane: 161 Brunswick Street, Fortitude Valley, QLD 4006.</p>
                    </div>
                </div>

                <div class="ag-faq-item">
                    <button class="ag-faq-question" aria-expanded="false">
                        How does commission work?
                        <span class="ag-faq-icon"></span>
                    </button>
                    <div class="ag-faq-answer">
                        <p>Commission terms are provided once your application is approved and the agent agreement is
                            signed. Contact agent support for current details.</p>
                    </div>
                </div>

                <div class="ag-faq-item">
                    <button class="ag-faq-question" aria-expanded="false">
                        Who do I contact for support?
                        <span class="ag-faq-icon"></span>
                    </button>
                    <div class="ag-faq-answer">
                        <p>Email <a href="mailto:<?= ag_e($support_em) ?>"><?= ag_e($support_em) ?></a> or call
                            <?= ag_e($support_ph) ?>. Mention that you are an education agent.
                        </p>
                    </div>
                </div>

                <div class="ag-faq-item">
                    <button class="ag-faq-question" aria-expanded="false">
                        Do you provide marketing materials?
                        <span class="ag-faq-icon"></span>
                    </button>
                    <div class="ag-faq-answer">
                        <p>Yes. Approved agents get course information, logos and approved materials. All promotion
                            must follow our branding and regulatory guidelines.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== CTA ===================== -->
    <section class="ag-cta">
        <div class="container">
            <div class="ag-cta-box">
                <div>
                    <h2>Ready to partner with Cornell?</h2>
                    <p>Apply through the agent portal or get in touch.</p>
                </div>
                <div class="ag-cta-actions">
                    <?php if ($apply_url): ?>
                    <a href="<?= ag_e($apply_url) ?>" target="_blank" rel="noopener" class="btn-pill btn-pill-accent">
                        Apply Now <span class="btn-icon">→</span>
                    </a>
                    <?php endif; ?>
                    <a href="mailto:<?= ag_e($support_em) ?>" class="btn-pill btn-pill-secondary">
                        Email Us <span class="btn-icon">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/scripts.php') ?>
    <script src="assets/js/agents.js"></script>
</body>

</html>