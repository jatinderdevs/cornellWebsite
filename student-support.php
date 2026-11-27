<?php
require_once __DIR__ . '/config.php';
$seo = [
    'title' => 'Student Support | Cornell Institute of Training',
    'description' => 'Student support services, resources, forms, policies and wellbeing information at Cornell Institute of Training - Melbourne & Brisbane.',
    'path' => '/student-support',
    'breadcrumbs' => [['Home', '/'], ['Student Support', '/student-support']],
];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <?php require __DIR__ . '/includes/seo.php'; ?>

    <?php include_once('includes/stylesheets.php') ?>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/page/student-support.css" />
</head>

<body>
    <?php include_once('includes/navbar.php') ?>

    <!-- ===================== PAGE HEADER ===================== -->
    <section class="page-header">
        <img class="page-header-bg" src="<?= BASE_PATH ?>/assets/images/about.webp" alt="" />
        <div class="page-header-overlay"></div>

        <div class="container">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="<?= BASE_PATH ?>/">Home</a>
                <span>/</span>
                <span>Student Support</span>
            </nav>

            <div class="page-header-content">
                <span class="page-label">We're here to help</span>
                <h1 class="heading">Student <span>Support</span></h1>
                <p>
                    Academic guidance, wellbeing services, forms, policies and resources —
                    everything you need to succeed at Cornell Institute of Training.
                </p>
            </div>
        </div>
    </section>

    <!-- ===================== QUICK JUMP NAV ===================== -->
    <nav class="ss-jump-nav" aria-label="Page sections">
        <div class="container">
            <div class="ss-jump-pills">
                <a href="#support-services" class="ss-jump-pill">Support Services</a>
                <a href="#resources" class="ss-jump-pill">Resources</a>
                <a href="#forms" class="ss-jump-pill">Forms</a>
                <a href="#policies" class="ss-jump-pill">Policies</a>
                <a href="#privacy" class="ss-jump-pill">Privacy</a>
                <a href="#contacts" class="ss-jump-pill">Important Contacts</a>
            </div>
        </div>
    </nav>

    <!-- ===================== SUPPORT SERVICES ===================== -->
    <section class="ss-section" id="support-services">
        <div class="container">
            <div class="ss-section-header">
                <span class="section-label">Support Services</span>
                <h2 class="heading">How we support <span>you</span></h2>
                <p>Our student support team is available throughout your studies to help you stay on track and succeed.
                </p>
            </div>

            <div class="ss-services-grid">
                <article class="ss-service-card">
                    <div class="ss-service-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                        </svg>
                    </div>
                    <h3>Academic Support</h3>
                    <p>Study skills, assessment guidance, LLN support and academic progress monitoring.</p>
                </article>

                <article class="ss-service-card">
                    <div class="ss-service-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                        </svg>
                    </div>
                    <h3>Wellbeing &amp; Counselling</h3>
                    <p>Confidential wellbeing support and referrals for personal or study-related concerns.</p>
                </article>

                <article class="ss-service-card">
                    <div class="ss-service-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4l3 3" />
                        </svg>
                    </div>
                    <h3>Disability Support</h3>
                    <p>Reasonable adjustments and support arrangements so every student can participate fully.</p>
                </article>

                <article class="ss-service-card">
                    <div class="ss-service-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                    <h3>Career Guidance</h3>
                    <p>Course pathways, job-ready skills advice and industry-focused career conversations.</p>
                </article>

                <article class="ss-service-card">
                    <div class="ss-service-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="2" y1="12" x2="22" y2="12" />
                            <path
                                d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                        </svg>
                    </div>
                    <h3>International Students</h3>
                    <p>Visa &amp; ESOS information, orientation, OSHC guidance and dedicated international support.</p>
                </article>

                <article class="ss-service-card">
                    <div class="ss-service-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                    </div>
                    <h3>Contact Support Team</h3>
                    <p>Reach us any time — we’re here to answer questions and point you in the right direction.</p>
                    <a href="mailto:info@cornell.vic.edu.au" class="ss-card-link">Email support →</a>
                </article>
            </div>
        </div>
    </section>

    <!-- ===================== RESOURCES ===================== -->
    <section class="ss-section ss-section-alt" id="resources">
        <div class="container">
            <div class="ss-section-header">
                <span class="section-label">Student Resources</span>
                <h2 class="heading">Essential <span>information</span></h2>
                <p>Key documents and guides that help you understand your rights, responsibilities and options.</p>
            </div>

            <div class="ss-resources-grid">
                <a href="#policies" class="ss-resource-card">
                    <h3>Student Handbook</h3>
                    <p>Your primary guide to rights, responsibilities, support services and campus life.</p>
                    <span class="ss-resource-action">View details →</span>
                </a>

                <a href="#policies" class="ss-resource-card">
                    <h3>Policies &amp; Procedures</h3>
                    <p>Attendance, enrolment, support &amp; intervention, complaints and more.</p>
                    <span class="ss-resource-action">Browse policies →</span>
                </a>

                <a href="#policies" class="ss-resource-card">
                    <h3>Fees &amp; Refunds</h3>
                    <p>Clear information about fees, payment schedules and the refund policy.</p>
                    <span class="ss-resource-action">View policy →</span>
                </a>

                <a href="mailto:info@cornell.vic.edu.au" class="ss-resource-card">
                    <h3>Timetables</h3>
                    <p>Request current class timetables and intake schedules from the student team.</p>
                    <span class="ss-resource-action">Request timetable →</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ===================== FORMS ===================== -->
    <section class="ss-section" id="forms">
        <div class="container">
            <div class="ss-section-header">
                <span class="section-label">Student Forms</span>
                <h2 class="heading">Download <span>forms</span></h2>
                <p>Common forms for applications, changes, refunds, RPL and more. Complete and return as directed.</p>
            </div>

            <?php
            // Student forms: PDFs live in assets/forms/ (file => link text).
            // To add a form: drop the PDF in assets/forms/ and add one line below.
            $formGroups = [
                'Applications &amp; Enrolment' => [
                    'international-student-application-form.pdf'           => 'International Student Application',
                    'citf015-pre-enrolment-review-form.pdf'                => 'Pre-Enrolment Review Form',
                    'citf020-continuing-student-enrolment-form.pdf'        => 'Continuing Student Enrolment Form',
                    'citf021-rpl-application-form.pdf'                     => 'Recognition of Prior Learning (RPL) Application',
                    'citf001-credit-transfer-application-form.pdf'         => 'Credit Transfer Application',
                    'citf009-internal-course-transfer-application-form.pdf' => 'Internal Course Transfer Application',
                ],
                'Changes &amp; Requests' => [
                    'citf007-student-change-of-details-form.pdf'                  => 'Change of Details Form',
                    'citf010-deferral-application-form-international-students.pdf' => 'Deferral Application (International Students)',
                    'citf008-withdrawal-form-international-students.pdf'          => 'Withdrawal Form (International Students)',
                    'citf011-release-request-form.pdf'                            => 'Release Request Form',
                    'citf069-change-of-education-agent-request.pdf'               => 'Change of Education Agent Request',
                    'citf014-access-to-records-request-form.pdf'                  => 'Access to Records Request',
                    'citf019-disability-disclosure-form.pdf'                      => 'Disability Disclosure Form',
                ],
                'Assessment, Complaints &amp; Finance' => [
                    'citf025-assessment-extension-and-further-attempt-request.pdf' => 'Assessment Extension &amp; Further Attempt Request',
                    'citf004-reassessment-and-appeal-form.pdf'                     => 'Reassessment &amp; Appeal Form',
                    'citf005-complaints-and-appeal-form.pdf'                       => 'Complaints &amp; Appeal Form',
                    'citf006-refund-application-form.pdf'                          => 'Refund Application Form',
                    'citf012-qualification-issue-form.pdf'                         => 'Qualification Issue Form',
                    'citf041-feedback-form.pdf'                                    => 'Feedback Form',
                    'citf059-student-privacy-notice.pdf'                           => 'Student Privacy Notice',
                ],
            ];

            // One icon per group, in the same order as $formGroups
            $formGroupIcons = [
                '<path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" /><rect x="8" y="2" width="8" height="4" rx="1" /><path d="M9 14l2 2 4-4" />',
                '<path d="M21 2v6h-6" /><path d="M3 12a9 9 0 0 1 15-6.7L21 8" /><path d="M3 22v-6h6" /><path d="M21 12a9 9 0 0 1-15 6.7L3 16" />',
                '<path d="M12 3v18" /><path d="M5 7h14" /><path d="M5 7l-3 7a3 3 0 0 0 6 0z" /><path d="M19 7l-3 7a3 3 0 0 0 6 0z" /><path d="M8 21h8" />',
            ];
            $formCount = array_sum(array_map('count', $formGroups));
            ?>
            <div class="ss-forms-grid">
                <?php $gi = 0; foreach ($formGroups as $groupTitle => $forms): ?>
                <div class="ss-form-group">
                    <div class="ss-form-group-head">
                        <span class="ss-form-group-icon" aria-hidden="true">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round"><?= $formGroupIcons[$gi++] ?? '' ?></svg>
                        </span>
                        <h3 class="ss-form-group-title"><?= $groupTitle ?></h3>
                        <span class="ss-form-count"><?= count($forms) ?> forms</span>
                    </div>
                    <ul class="ss-forms-list">
                        <?php foreach ($forms as $file => $label):
                            $formCode = preg_match('/^(citf\d+)-/', $file, $m) ? strtoupper($m[1]) . ' &middot; ' : ''; ?>
                        <li>
                            <a class="ss-form-item" href="<?= BASE_PATH ?>/assets/forms/<?= $file ?>" target="_blank"
                                rel="noopener">
                                <span class="ss-form-file" aria-hidden="true"><img
                                        src="<?= BASE_PATH ?>/assets/images/icons/pdf.png" alt=""></span>
                                <span class="ss-form-text">
                                    <span class="ss-form-name"><?= $label ?></span>
                                    <span class="ss-form-meta"><?= $formCode ?>Fillable PDF</span>
                                </span>
                                <svg class="ss-form-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" aria-hidden="true">
                                    <path d="M7 17L17 7" />
                                    <path d="M8 7h9v9" />
                                </svg>
                                <span class="sr-only">(PDF, opens in a new tab)</span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="ss-forms-help">
                <p>
                    Download, complete on your device and email to
                    <a href="mailto:info@cornell.vic.edu.au">info@cornell.vic.edu.au</a>.
                    Not sure which form you need? Call <a href="tel:1300195612">1300 195 612</a>.
                </p>
            </div>
        </div>
    </section>

    <!-- ===================== POLICIES ===================== -->
    <section class="ss-section ss-section-alt" id="policies">
        <div class="container">
            <div class="ss-section-header">
                <span class="section-label">Policies &amp; Procedures</span>
                <h2 class="heading">Our key <span>policies</span></h2>
                <p>Transparent policies that protect your rights and outline how we support your learning journey.</p>
            </div>

            <div class="ss-policies-grid">
                <a href="<?= BASE_PATH ?>/forms/policy/CITP014-Student-wellbeing-support.pdf" target="_blank"
                    rel="noopener" class="ss-policy-card">
                    <h3>Student Wellbeing Support</h3>
                    <p>How we support student wellbeing and provide appropriate assistance.</p>
                    <span class="ss-policy-link">View PDF →</span>
                </a>

                <a href="<?= BASE_PATH ?>/forms/policy/CITP011-Student-support-and-intervention.pdf" target="_blank"
                    rel="noopener" class="ss-policy-card">
                    <h3>Student Support &amp; Intervention</h3>
                    <p>Support strategies and intervention when academic progress is at risk.</p>
                    <span class="ss-policy-link">View PDF →</span>
                </a>

                <a href="<?= BASE_PATH ?>/forms/policy/CITP015-Feedback-complaints-and-Appeals.pdf" target="_blank"
                    rel="noopener" class="ss-policy-card">
                    <h3>Feedback, Complaints &amp; Appeals</h3>
                    <p>How to provide feedback or lodge a formal complaint or appeal.</p>
                    <span class="ss-policy-link">View PDF →</span>
                </a>

                <a href="<?= BASE_PATH ?>/forms/policy/CITP020-Fee-and-Refund.pdf" target="_blank" rel="noopener"
                    class="ss-policy-card">
                    <h3>Fee &amp; Refund Policy</h3>
                    <p>Fees, payment schedules, refunds and withdrawal procedures.</p>
                    <span class="ss-policy-link">View PDF →</span>
                </a>

                <a href="<?= BASE_PATH ?>/forms/policy/CITP010-Student-Enrolment.pdf" target="_blank" rel="noopener"
                    class="ss-policy-card">
                    <h3>Student Enrolment Policy</h3>
                    <p>Enrolment processes, entry requirements and related procedures.</p>
                    <span class="ss-policy-link">View PDF →</span>
                </a>

                <a href="<?= BASE_PATH ?>/forms/policy/CITP012-Attendance.pdf" target="_blank" rel="noopener"
                    class="ss-policy-card">
                    <h3>Attendance Policy</h3>
                    <p>Attendance requirements and monitoring for all students.</p>
                    <span class="ss-policy-link">View PDF →</span>
                </a>

                <a href="<?= BASE_PATH ?>/forms/policy/CITP006-RPL-Policy.pdf" target="_blank" rel="noopener"
                    class="ss-policy-card">
                    <h3>RPL Policy</h3>
                    <p>Recognition of Prior Learning processes and evidence requirements.</p>
                    <span class="ss-policy-link">View PDF →</span>
                </a>

                <a href="<?= BASE_PATH ?>/forms/policy/CITP009-Student-information.pdf" target="_blank" rel="noopener"
                    class="ss-policy-card">
                    <h3>Student Information Policy</h3>
                    <p>How we provide clear, accurate and timely information to students.</p>
                    <span class="ss-policy-link">View PDF →</span>
                </a>

                <a href="<?= BASE_PATH ?>/forms/policy/CITP013-Diversity-Incl-and-C-Safety.pdf" target="_blank"
                    rel="noopener" class="ss-policy-card">
                    <h3>Diversity, Inclusion &amp; Child Safety</h3>
                    <p>Our commitment to an inclusive and safe learning environment.</p>
                    <span class="ss-policy-link">View PDF →</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ===================== PRIVACY ===================== -->
    <section class="ss-section" id="privacy">
        <div class="container">
            <div class="ss-privacy-box">
                <div class="ss-privacy-content">
                    <span class="section-label">Privacy</span>
                    <h2 class="heading">Your privacy <span>matters</span></h2>
                    <p>
                        Cornell Institute of Training collects and handles personal information in accordance with the
                        Australian Privacy Principles and relevant VET legislation. We only collect information
                        necessary
                        for enrolment, training delivery, reporting and support services.
                    </p>
                    <p>
                        You can request access to or correction of your personal information, or raise a privacy
                        concern,
                        by contacting us at
                        <a href="mailto:info@cornell.vic.edu.au">info@cornell.vic.edu.au</a>.
                    </p>

                </div>
            </div>
        </div>
    </section>

    <!-- ===================== IMPORTANT CONTACTS ===================== -->
    <section class="ss-section ss-section-alt" id="contacts">
        <div class="container">
            <div class="ss-section-header">
                <span class="section-label">Important Contacts</span>
                <h2 class="heading">External help &amp; <span>emergency</span></h2>
                <p>Useful external organisations and emergency numbers for students.</p>
            </div>

            <div class="ss-contacts-grid">
                <div class="ss-contact-card">
                    <h3>Emergency</h3>
                    <ul>
                        <li><strong>Police / Fire / Ambulance</strong> — 000</li>
                        <li><strong>Poison Information</strong> — 13 11 26</li>
                    </ul>
                </div>

                <div class="ss-contact-card">
                    <h3>Overseas Students Ombudsman</h3>
                    <ul>
                        <li>Phone: 1300 362 072</li>
                        <li><a href="https://www.ombudsman.gov.au/" target="_blank" rel="noopener">ombudsman.gov.au</a>
                        </li>
                        <li><a href="mailto:overseas.students@ombudsman.gov.au">overseas.students@ombudsman.gov.au</a>
                        </li>
                    </ul>
                </div>

                <div class="ss-contact-card">
                    <h3>Sexual Assault &amp; Harassment</h3>
                    <ul>
                        <li>Melbourne Sexual Assault Crisis Line — 1800 806 292 (24/7)</li>
                        <li>Centre Against Sexual Assault — 03 9635 3600</li>
                    </ul>
                </div>

                <div class="ss-contact-card">
                    <h3>Other Useful Links</h3>
                    <ul>
                        <li><a href="https://www.homeaffairs.gov.au/" target="_blank" rel="noopener">Home Affairs
                                (Visa)</a></li>
                        <li><a href="https://www.consumer.vic.gov.au/" target="_blank" rel="noopener">Consumer Affairs
                                Victoria</a></li>
                        <li><a href="https://www.humanrightscommission.vic.gov.au/" target="_blank" rel="noopener">Equal
                                Opportunity Commission</a></li>
                        <li><a href="https://www.ptv.vic.gov.au/" target="_blank" rel="noopener">Public Transport
                                Victoria</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== CTA ===================== -->
    <section class="ss-cta">
        <div class="container">
            <div class="ss-cta-box">
                <div>
                    <h2>Still have questions?</h2>
                    <p>Our student support team is ready to help with any enquiry about courses, support or enrolment.
                    </p>
                </div>
                <div class="ss-cta-actions">
                    <a href="mailto:info@cornell.vic.edu.au" class="btn-pill btn-pill-accent">
                        Email Us <span class="btn-icon">→</span>
                    </a>
                    <a href="tel:1300195612" class="btn-pill btn-pill-secondary">
                        Call 1300 195 612 <span class="btn-icon">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php') ?>
    <?php include_once('includes/scripts.php') ?>
    <script src="<?= BASE_PATH ?>/assets/js/student-support.js"></script>
</body>

</html>