<?php

/**
 * Contact form handler
 * Validates an enquiry and emails it to the admissions inbox.
 *
 * Delivery
 *  - If RESEND_API_KEY is defined (put it in env.php, which is git-ignored) the
 *    message is sent through Resend.
 *  - Otherwise it falls back to PHP's mail().
 *
 * Optional constants (env.php): RESEND_API_KEY, CONTACT_TO, CONTACT_FROM
 * Requires PHP 7.0+ and an active session (contact.php starts it).
 */

if (is_file(__DIR__ . '/../env.php')) {
    require_once __DIR__ . '/../env.php';
}

defined('CONTACT_TO')   || define('CONTACT_TO', 'info@cornell.vic.edu.au');
defined('CONTACT_FROM') || define('CONTACT_FROM', 'Cornell Website <no-reply@cornell.vic.edu.au>');

const CONTACT_TOPICS = [
    'enrolment'     => 'Enrolment',
    'courses'       => 'Course info',
    'international' => 'International students',
    'feedback'      => 'Feedback',
    'other'         => 'Something else',
];

const CONTACT_CAMPUSES = ['Melbourne', 'Brisbane', 'Not sure yet'];

/**
 * @param array $post    Raw $_POST
 * @param array $courses Course list from data/dbcourses.php
 * @return array         ['ok' => bool, 'status' => int, 'message' => string, 'errors' => array]
 */
function contact_handle(array $post, array $courses)
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
    $name    = preg_replace('/\s+/', ' ', $get('name'));
    $email   = $get('email');
    $phone   = $get('phone');
    $campus  = $get('campus');
    $course  = $get('course');
    $message = $get('message');

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
    if ($campus !== '' && !in_array($campus, CONTACT_CAMPUSES, true)) {
        $errors['campus'] = 'Please choose a campus from the list.';
    }
    if ($course !== '' && !in_array($course, array_column($courses, 'title'), true)) {
        $errors['course'] = 'Please choose a course from the list.';
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

    // 5. Compose + send
    $dash    = function ($v) { return $v !== '' ? $v : '—'; };
    $subject = '[' . CONTACT_TOPICS[$topic] . '] Website enquiry from ' . $name;
    $body    = "Topic:  " . CONTACT_TOPICS[$topic] . "\n"
             . "Name:   " . $name . "\n"
             . "Email:  " . $email . "\n"
             . "Phone:  " . $dash($phone) . "\n"
             . "Campus: " . $dash($campus) . "\n"
             . "Course: " . $dash($course) . "\n\n"
             . "Message:\n" . $message . "\n\n"
             . "--\nSent via the Cornell website contact form";

    if (!contact_send($subject, $body, $email)) {
        return $result(
            false,
            500,
            "We couldn't send your message right now. Please email " . CONTACT_TO . ' or call 1300 195 612.'
        );
    }

    $_SESSION['contact_last'] = time();
    return $result(true, 200);
}

/**
 * Send the email. $replyTo must already be a validated address.
 */
function contact_send($subject, $body, $replyTo)
{
    if (defined('RESEND_API_KEY') && RESEND_API_KEY) {
        $ch = curl_init('https://api.resend.com/emails');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . RESEND_API_KEY,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS     => json_encode([
                'from'     => CONTACT_FROM,
                'to'       => [CONTACT_TO],
                'reply_to' => $replyTo,
                'subject'  => $subject,
                'text'     => $body,
            ]),
        ]);
        $response = curl_exec($ch);
        $status   = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($response === false || $status < 200 || $status >= 300) {
            error_log('[contact] Resend failed (' . $status . '): ' . ($curlErr ?: $response));
            return false;
        }
        return true;
    }

    $headers = [
        'From: ' . CONTACT_FROM,
        'Reply-To: ' . $replyTo,
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
    ];
    $sent = mail(CONTACT_TO, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, implode("\r\n", $headers));
    if (!$sent) {
        error_log('[contact] mail() failed');
    }
    return $sent;
}