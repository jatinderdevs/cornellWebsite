<?php
/**
 * Shared HTML shell for the contact-form emails.
 *
 * Table-based layout with inline CSS so it renders consistently in Gmail,
 * Outlook and Apple Mail. Brand colours match assets/css/style.css:
 *   primary #0b1d36 (navy), accent #ffa200 (amber).
 */

if (!defined('MAIL_SITE_URL')) {
    define('MAIL_SITE_URL', 'https://cornell.vic.edu.au');
}

if (!function_exists('mail_e')) {
    function mail_e($v): string
    {
        return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
    }
}

/** Constants from config.php, with safe fallbacks. */
function mail_const(string $name, string $fallback): string
{
    return defined($name) ? (string) constant($name) : $fallback;
}

/** One label / value row for the details table. $valueHtml must already be escaped. */
function mail_row(string $label, string $valueHtml): string
{
    return '<tr>'
        . '<td style="padding:9px 0;border-bottom:1px solid #e2e8f0;width:130px;vertical-align:top;'
        . 'font:600 12px/1.5 Arial,Helvetica,sans-serif;letter-spacing:.04em;text-transform:uppercase;color:#718096;">'
        . mail_e($label) . '</td>'
        . '<td style="padding:9px 0;border-bottom:1px solid #e2e8f0;vertical-align:top;'
        . 'font:400 15px/1.5 Arial,Helvetica,sans-serif;color:#1a1a1a;">' . $valueHtml . '</td>'
        . '</tr>';
}

/** The visitor's message in a quoted block (escaped, line breaks kept). */
function mail_message_block(string $message): string
{
    return '<div style="margin:6px 0 0;padding:16px 18px;background:#f7f9fc;border-left:4px solid #ffa200;'
        . 'border-radius:6px;font:400 15px/1.65 Arial,Helvetica,sans-serif;color:#1a1a1a;">'
        . nl2br(mail_e($message), false) . '</div>';
}

/** Amber pill button / link. */
function mail_button(string $href, string $label): string
{
    return '<a href="' . mail_e($href) . '" style="display:inline-block;background:#ffa200;color:#0b1d36;'
        . 'font:700 14px/1 Arial,Helvetica,sans-serif;padding:13px 24px;border-radius:999px;text-decoration:none;">'
        . mail_e($label) . '</a>';
}

/**
 * @param string $preheader  Hidden preview text shown in the inbox list
 * @param string $heading    Main heading inside the card
 * @param string $contentHtml Body HTML (already escaped where needed)
 */
function mail_layout(string $preheader, string $heading, string $contentHtml): string
{
    $phone = mail_const('SITE_PHONE', '1300 195 612');
    $email = mail_const('SITE_EMAIL', 'info@cornell.vic.edu.au');
    $toid  = mail_const('TOID', '6074');
    $cric  = mail_const('CRICOS', '03892A');

    $muted = 'font:400 12px/1.6 Arial,Helvetica,sans-serif;color:#718096;';

    return '<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="x-apple-disable-message-reformatting">
<title>' . mail_e($heading) . '</title>
</head>
<body style="margin:0;padding:0;background:#f4f6fa;">
<div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">' . mail_e($preheader) . '</div>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f6fa;">
<tr><td align="center" style="padding:24px 12px;">
  <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
    <tr><td style="background:#0b1d36;padding:24px 28px;">
      <div style="font:700 24px/1 Georgia,\'Times New Roman\',serif;letter-spacing:5px;color:#ffffff;">CORNELL</div>
      <div style="margin-top:7px;font:700 10px/1.4 Arial,Helvetica,sans-serif;letter-spacing:3px;color:#ffa200;">INSTITUTE OF TRAINING</div>
    </td></tr>
    <tr><td style="height:4px;background:#ffa200;font-size:0;line-height:0;">&nbsp;</td></tr>
    <tr><td style="padding:30px 28px 8px;">
      <h1 style="margin:0 0 14px;font:700 22px/1.3 Arial,Helvetica,sans-serif;color:#0b1d36;">' . mail_e($heading) . '</h1>
      ' . $contentHtml . '
    </td></tr>
    <tr><td style="padding:22px 28px 28px;">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top:1px solid #e2e8f0;">
        <tr><td style="padding-top:18px;' . $muted . '">
          <strong style="color:#0b1d36;">Cornell Institute of Training</strong><br>
          Melbourne: Level 5, 440 Elizabeth Street, Melbourne VIC 3000<br>
          Brisbane: 161 Brunswick Street, Fortitude Valley QLD 4006<br>
          <a href="tel:' . mail_e(preg_replace('/\D+/', '', $phone)) . '" style="color:#035bce;text-decoration:none;">' . mail_e($phone) . '</a>
          &nbsp;&middot;&nbsp;
          <a href="mailto:' . mail_e($email) . '" style="color:#035bce;text-decoration:none;">' . mail_e($email) . '</a>
          &nbsp;&middot;&nbsp;
          <a href="' . mail_e(MAIL_SITE_URL) . '" style="color:#035bce;text-decoration:none;">cornell.vic.edu.au</a><br>
          RTO TOID ' . mail_e($toid) . ' &nbsp;|&nbsp; CRICOS ' . mail_e($cric) . '
        </td></tr>
      </table>
    </td></tr>
  </table>
</td></tr>
</table>
</body>
</html>';
}
