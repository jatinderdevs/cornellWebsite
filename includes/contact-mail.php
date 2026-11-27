<?php
/**
 * Contact-form email sending (Zoho ZeptoMail over SMTP, via PHPMailer).
 *
 *  - Requires PHPMailer (composer require phpmailer/phpmailer).
 *  - Staff email falls back to PHP mail() if SMTP is not configured.
 *
 * Settings (env.php, git-ignored): SMTP_HOST, SMTP_PORT, SMTP_USER, SMTP_PASS,
 * SMTP_SECURE ('tls' for 587 or 'ssl' for 465), CONTACT_TO, CONTACT_FROM,
 * and optionally CONTACT_CONFIRMATION (set false to stop confirmation emails).
 */

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/emails/staff.php';
require_once __DIR__ . '/emails/confirmation.php';

/** True when the SMTP settings and PHPMailer are both available. */
if (!function_exists('contact_smtp_ready')) {
    function contact_smtp_ready(): bool
    {
        return defined('SMTP_HOST') && SMTP_HOST
            && defined('SMTP_USER') && SMTP_USER
            && defined('SMTP_PASS') && SMTP_PASS
            && class_exists(PHPMailer::class);
    }
}

/**
 * @param array $m to, subject, html, text, reply_to, smtp_only (bool)
 */
if (!function_exists('contact_deliver')) {
    function contact_deliver(array $m): bool
    {
        if (contact_smtp_ready()) {
            $mail = new PHPMailer(true);
            try {
                $secure = defined('SMTP_SECURE') ? strtolower((string) SMTP_SECURE) : 'tls';

                $mail->isSMTP();
                $mail->Host       = trim(SMTP_HOST);
                $mail->SMTPAuth   = true;
                $mail->Username   = trim(SMTP_USER);
                $mail->Password   = SMTP_PASS;
                $mail->SMTPSecure = $secure === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = defined('SMTP_PORT') ? (int) SMTP_PORT : ($secure === 'ssl' ? 465 : 587);
                $mail->Timeout    = 15;
                $mail->CharSet    = PHPMailer::CHARSET_UTF8;

                // CONTACT_FROM can be "Name <address>" or a bare address.
                $from = PHPMailer::parseAddresses(CONTACT_FROM);
                if (!$from) {
                    throw new \RuntimeException('CONTACT_FROM is not a valid address');
                }
                $mail->setFrom($from[0]['address'], $from[0]['name'] ?? '');

                $mail->addAddress($m['to']);
                if (!empty($m['reply_to'])) {
                    $mail->addReplyTo($m['reply_to']);
                }

                $mail->isHTML(true);
                $mail->Subject = $m['subject'];
                $mail->Body    = $m['html'];
                $mail->AltBody = $m['text'];

                $mail->send();
                return true;
            } catch (\Throwable $e) {
                error_log('[contact] SMTP error: ' . ($mail->ErrorInfo ?: $e->getMessage()));
                return false;
            }
        }

        // No SMTP configured
        if (!empty($m['smtp_only'])) {
            error_log('[contact] SMTP not configured - email skipped: ' . $m['subject']);
            return false;
        }
        $headers = [
            'From: ' . CONTACT_FROM,
            'Reply-To: ' . $m['reply_to'],
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
        ];
        $sent = mail($m['to'], '=?UTF-8?B?' . base64_encode($m['subject']) . '?=', $m['text'], implode("\r\n", $headers));
        if (!$sent) {
            error_log('[contact] mail() failed');
        }
        return $sent;
    }
}

/** Email to the college with the form details. Reply-To = the visitor. */
function contact_send_staff(array $d): bool
{
    $mail = mail_staff($d);
    return contact_deliver([
        'to'       => CONTACT_TO,
        'reply_to' => $d['email'],
        'subject'  => $mail['subject'],
        'html'     => $mail['html'],
        'text'     => $mail['text'],
    ]);
}

/** Confirmation to the visitor with a copy of their message. Reply-To = college inbox. */
function contact_send_confirmation(array $d): bool
{
    if (defined('CONTACT_CONFIRMATION') && !CONTACT_CONFIRMATION) {
        return true;
    }
    $mail = mail_confirmation($d);
    return contact_deliver([
        'to'        => $d['email'],
        'reply_to'  => CONTACT_TO,
        'subject'   => $mail['subject'],
        'html'      => $mail['html'],
        'text'      => $mail['text'],
        'smtp_only' => true,
    ]);
}
