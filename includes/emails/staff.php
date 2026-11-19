<?php
/**
 * Email sent to the college (CONTACT_TO) when someone submits the contact form.
 * Reply-To is set to the visitor, so "Reply" answers them directly.
 *
 * @param array $d topic, name, email, phone, student_id, message, submitted_at (DateTimeInterface)
 * @return array{subject:string,html:string,text:string}
 */

require_once __DIR__ . '/layout.php';

function mail_staff(array $d): array
{
    $dash    = function ($v) { return $v !== '' ? $v : "\u{2014}"; };
    $when    = $d['submitted_at']->format('j M Y, g:i a T');
    $subject = '[' . $d['topic'] . '] Website enquiry from ' . $d['name'];
    $first   = preg_split('/\s+/', $d['name'])[0];

    $rows = mail_row('Topic', mail_e($d['topic']))
          . mail_row('Name', mail_e($d['name']))
          . mail_row('Email', '<a href="mailto:' . mail_e($d['email']) . '" style="color:#035bce;">' . mail_e($d['email']) . '</a>')
          . mail_row('Phone', $d['phone'] !== ''
                ? '<a href="tel:' . mail_e(preg_replace('/[^\d+]/', '', $d['phone'])) . '" style="color:#035bce;">' . mail_e($d['phone']) . '</a>'
                : mail_e($dash('')))
          . mail_row('Student ID', mail_e($dash($d['student_id'])))
          . mail_row('Submitted', mail_e($when));

    $body = '<p style="margin:0 0 18px;font:400 15px/1.6 Arial,Helvetica,sans-serif;color:#4a5568;">'
          . 'A new enquiry came in through the website contact form. Reply to this email to respond to '
          . mail_e($first) . ' directly.</p>'
          . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">' . $rows . '</table>'
          . '<p style="margin:22px 0 4px;font:600 12px/1.5 Arial,Helvetica,sans-serif;letter-spacing:.04em;text-transform:uppercase;color:#718096;">Message</p>'
          . mail_message_block($d['message'])
          . '<p style="margin:26px 0 22px;">'
          . mail_button('mailto:' . $d['email'] . '?subject=' . rawurlencode('Re: Your enquiry to Cornell Institute of Training'), 'Reply to ' . $first)
          . '</p>';

    $html = mail_layout('New ' . $d['topic'] . ' enquiry from ' . $d['name'], 'New website enquiry', $body);

    $text = "New website enquiry\n\n"
          . "Topic:       " . $d['topic'] . "\n"
          . "Name:        " . $d['name'] . "\n"
          . "Email:       " . $d['email'] . "\n"
          . "Phone:       " . $dash($d['phone']) . "\n"
          . "Student ID:  " . $dash($d['student_id']) . "\n"
          . "Submitted:   " . $when . "\n\n"
          . "Message:\n" . $d['message'] . "\n\n"
          . "Reply to this email to respond to " . $first . " directly.\n"
          . "--\nSent via the Cornell website contact form";

    return ['subject' => $subject, 'html' => $html, 'text' => $text];
}
