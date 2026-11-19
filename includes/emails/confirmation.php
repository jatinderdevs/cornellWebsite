<?php
/**
 * Confirmation email sent to the person who submitted the contact form,
 * including a copy of what they sent. Reply-To is the college inbox.
 *
 * @param array $d topic, name, email, phone, student_id, message, submitted_at (DateTimeInterface)
 * @return array{subject:string,html:string,text:string}
 */

require_once __DIR__ . '/layout.php';

function mail_confirmation(array $d): array
{
    $when    = $d['submitted_at']->format('j M Y, g:i a T');
    $first   = preg_split('/\s+/', $d['name'])[0];
    $phone   = mail_const('SITE_PHONE', '1300 195 612');
    $inbox   = mail_const('SITE_EMAIL', 'info@cornell.vic.edu.au');
    $subject = "We've received your enquiry \u{2013} Cornell Institute of Training";

    $rows = mail_row('Topic', mail_e($d['topic']));
    if ($d['phone'] !== '') {
        $rows .= mail_row('Phone', mail_e($d['phone']));
    }
    if ($d['student_id'] !== '') {
        $rows .= mail_row('Student ID', mail_e($d['student_id']));
    }
    $rows .= mail_row('Sent', mail_e($when));

    $p = 'margin:0 0 16px;font:400 15px/1.6 Arial,Helvetica,sans-serif;color:#4a5568;';

    $body = '<p style="' . $p . '">Hi ' . mail_e($first) . ',</p>'
          . '<p style="' . $p . '">Thanks for getting in touch with Cornell Institute of Training. '
          . 'We&rsquo;ve received your enquiry and a member of our team will be in touch as soon as possible.</p>'
          . '<p style="margin:22px 0 6px;font:700 15px/1.4 Arial,Helvetica,sans-serif;color:#0b1d36;">Here&rsquo;s a copy of what you sent us</p>'
          . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">' . $rows . '</table>'
          . '<p style="margin:20px 0 4px;font:600 12px/1.5 Arial,Helvetica,sans-serif;letter-spacing:.04em;text-transform:uppercase;color:#718096;">Your message</p>'
          . mail_message_block($d['message'])
          . '<p style="' . $p . 'margin-top:24px;">Need us sooner? Call <a href="tel:' . mail_e(preg_replace('/\D+/', '', $phone)) . '" style="color:#035bce;">'
          . mail_e($phone) . '</a> or email <a href="mailto:' . mail_e($inbox) . '" style="color:#035bce;">' . mail_e($inbox) . '</a>.</p>'
          . '<p style="margin:0 0 22px;">' . mail_button(MAIL_SITE_URL . '/courses', 'Browse our courses') . '</p>'
          . '<p style="margin:0 0 8px;font:400 12px/1.6 Arial,Helvetica,sans-serif;color:#718096;">'
          . 'This is an automatic confirmation. If you didn&rsquo;t send this enquiry, you can safely ignore this email.</p>';

    $html = mail_layout('We have received your enquiry and will be in touch soon.', "Thanks, {$first} \u{2013} we got your message", $body);

    $text = "Hi {$first},\n\n"
          . "Thanks for getting in touch with Cornell Institute of Training. We've received your enquiry and a member of our team will be in touch as soon as possible.\n\n"
          . "Here's a copy of what you sent us:\n"
          . "Topic:       " . $d['topic'] . "\n"
          . ($d['phone'] !== '' ? "Phone:       " . $d['phone'] . "\n" : '')
          . ($d['student_id'] !== '' ? "Student ID:  " . $d['student_id'] . "\n" : '')
          . "Sent:        " . $when . "\n\n"
          . "Your message:\n" . $d['message'] . "\n\n"
          . "Need us sooner? Call {$phone} or email {$inbox}.\n\n"
          . "Melbourne: Level 5, 440 Elizabeth Street, Melbourne VIC 3000\n"
          . "Brisbane: 161 Brunswick Street, Fortitude Valley QLD 4006\n\n"
          . "This is an automatic confirmation. If you didn't send this enquiry, you can safely ignore this email.\n"
          . "--\nCornell Institute of Training | RTO TOID " . mail_const('TOID', '6074') . " | CRICOS " . mail_const('CRICOS', '03892A');

    return ['subject' => $subject, 'html' => $html, 'text' => $text];
}
