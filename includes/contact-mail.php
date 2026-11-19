<?php
/**
 * Contact-form email sending (Resend).
 *
 *  - Uses the official SDK when installed (composer require resend/resend-php),
 *    otherwise falls back to a plain cURL call to the same Resend API.
 *  - Staff email falls back to PHP mail() if RESEND_API_KEY is not set.
 *
 * Settings (env.php, git-ignored): RESEND_API_KEY, CONTACT_TO, CONTACT_FROM,
 * and optionally CONTACT_CONFIRMATION (set false to stop confirmation emails).
 */

require_once __DIR__ . '/emails/staff.php';
require_once __DIR__ . '/emails/confirmation.php';

/**
 * @param array $m to, subject, html, text, reply_to, resend_only (bool)
 */
if (!function_exists('contact_deliver')) {
    function contact_deliver(array $m): bool
    {
        $payload = [
            'from'    => CONTACT_FROM,
            'to'      => [$m['to']],
            'subject' => $m['subject'],
            'html'    => $m['html'],
            'text'    => $m['text'],
        ];
        if (!empty($m['reply_to'])) {
            $payload['reply_to'] = $m['reply_to'];
        }

        if (defined('RESEND_API_KEY') && RESEND_API_KEY) {
            // 1) Official SDK
            if (class_exists('Resend')) {
                try {
                    \Resend::client(RESEND_API_KEY)->emails->send($payload);
                    return true;
                } catch (\Throwable $e) {
                    error_log('[contact] Resend SDK error: ' . $e->getMessage());
                    return false;
                }
            }
            // 2) No Composer: same API over cURL
            $ch = curl_init(defined('RESEND_API_URL') ? RESEND_API_URL : 'https://api.resend.com/emails');
            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 15,
                CURLOPT_HTTPHEADER     => [
                    'Authorization: Bearer ' . RESEND_API_KEY,
                    'Content-Type: application/json',
                ],
                CURLOPT_POSTFIELDS     => json_encode($payload),
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

        // 3) No Resend key
        if (!empty($m['resend_only'])) {
            error_log('[contact] RESEND_API_KEY not set - email skipped: ' . $m['subject']);
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
        'to'          => $d['email'],
        'reply_to'    => CONTACT_TO,
        'subject'     => $mail['subject'],
        'html'        => $mail['html'],
        'text'        => $mail['text'],
        'resend_only' => true,
    ]);
}
