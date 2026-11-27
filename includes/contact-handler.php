<?php

/**
 * Contact form handler
 * Validates an enquiry, emails it to the college and sends the visitor a
 * confirmation copy. Sending lives in includes/contact-mail.php.
 *
 * Settings (env.php, git-ignored): SMTP_HOST, SMTP_PORT, SMTP_USER, SMTP_PASS,
 * SMTP_SECURE, CONTACT_TO, CONTACT_FROM
 * Requires an active session (contact.php starts it).
 */

if (is_file(__DIR__ . '/../env.php')) {
    $env = include __DIR__ . '/../env.php';
    if (is_array($env)) {
        foreach (['SMTP_HOST', 'SMTP_PORT', 'SMTP_USER', 'SMTP_PASS', 'SMTP_SECURE', 'CONTACT_TO', 'CONTACT_FROM', 'CONTACT_CONFIRMATION'] as $key) {
            if (isset($env[$key]) && !defined($key)) {
                define($key, $env[$key]);
            }
        }
    }
}
// Composer packages (phpmailer/phpmailer). Required for SMTP sending.
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}
require_once __DIR__ . '/contact-mail.php';

defined('CONTACT_TO')   || define('CONTACT_TO', 'info@cornell.vic.edu.au');
defined('CONTACT_FROM') || define('CONTACT_FROM', 'Cornell Website <no-reply@cornell.vic.edu.au>');

const CONTACT_TOPICS = [
    'enrolment'     => 'Enrolment',
    'courses'       => 'Course info',
    'international' => 'International students',
    'feedback'      => 'Feedback',
    'other'         => 'Something else',
];

/**
 * @param array $post    Raw $_POST
 * @param array $courses Unused (kept so contact.php's call still works)
 * @return array         ['ok' => bool, 'status' => int, 'message' => string, 'errors' => array]
 */
function contact_handle(array $post, array $courses = [])
{
    $result = function ($ok, $status, $message = '', $errors = []) {
        return ['ok' => $ok, 'status' => $status, 'message' => $message, 'errors' => $errors];
    };

    $get = function ($key) use ($post) {
        return (isset($post[$key]) && is_string($post[$key])) ? trim($post[$key]) : '';
    };

    // 1. CSRF
    $token = $get('csrf');
    if (empty($_SESSION['contact_csrf']) || !hash_equals($_SESSION['contact_csrf'], $token)) {
        return $result(false, 403, 'Your session has expired. Please refresh the page and try again.');
    }

    // 2. Honeypot – bots fill this in; pretend it worked
    if ($get('website') !== '') {
        return $result(true, 200);
    }

    // 3. Basic rate limit (one message per 20 seconds per visitor)
    if (isset($_SESSION['contact_last']) && (time() - $_SESSION['contact_last']) < 20) {
        return $result(false, 429, 'Please wait a moment before sending another message.');
    }

    // 4. Validate
    $topic   = $get('topic');
    $name    = trim(preg_replace('/[\x00-\x1F\x7F\s]+/u', ' ', $get('name')));
    $email   = $get('email');
    $phone   = $get('phone');
    $stuId   = $get('stu_id');
    $message = str_replace(["\r\n", "\r", "\0"], ["\n", "\n", ''], $get('message'));

    $len = function ($s) {
        return function_exists('mb_strlen') ? mb_strlen($s, 'UTF-8') : strlen($s);
    };

    $errors = [];

    if (!isset(CONTACT_TOPICS[$topic])) {
        $errors['topic'] = 'Please choose a topic.';
    }
    if ($len($name) < 2 || $len($name) > 100) {
        $errors['name'] = 'Please enter your full name.';
    }
    if ($len($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }
    if ($phone !== '' && !preg_match('/^[0-9+()\-\s]{6,20}$/', $phone)) {
        $errors['phone'] = 'Please enter a valid phone number.';
    }
    if ($stuId !== '' && !preg_match('/^[A-Za-z0-9][A-Za-z0-9\-\/ ]{0,19}$/', $stuId)) {
        $errors['stu_id'] = 'Please enter a valid student ID (letters and numbers only).';
    }
    if ($len($message) < 10 || $len($message) > 3000) {
        $errors['message'] = 'Please tell us a little more (10–3000 characters).';
    }
    if (empty($post['consent'])) {
        $errors['consent'] = 'Please confirm that we can contact you about your enquiry.';
    }

    if ($errors) {
        return $result(false, 422, 'Please check the highlighted fields.', $errors);
    }

    // 5. Send: college first (must succeed), then the visitor's confirmation
    $data = [
        'topic'        => CONTACT_TOPICS[$topic],
        'name'         => $name,
        'email'        => $email,
        'phone'        => $phone,
        'student_id'   => $stuId,
        'message'      => $message,
        'submitted_at' => new DateTimeImmutable('now', new DateTimeZone('Australia/Melbourne')),
    ];

    if (!contact_send_staff($data)) {
        return $result(
            false,
            500,
            "We couldn't send your message right now. Please email " . CONTACT_TO . ' or call 1300 195 612.'
        );
    }

    $_SESSION['contact_last'] = time();

    // The enquiry is already delivered, so a failed confirmation is only logged.
    if (!contact_send_confirmation($data)) {
        error_log('[contact] confirmation email could not be sent');
    }

    return $result(true, 200);
}