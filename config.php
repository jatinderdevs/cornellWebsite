<?php
/**
 * Cornell Institute of Training — Global Config
 * Include at the top of every page:
 *   require_once __DIR__ . '/config.php';
 */

// ---------------------------------------------------------------------------
// Base URL (auto-detects localhost/subfolder vs live domain)
// ---------------------------------------------------------------------------
$httpHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
$isLocal  = (
    $httpHost === 'localhost' ||
    $httpHost === '127.0.0.1' ||
    str_starts_with($httpHost, 'localhost:') ||
    str_starts_with($httpHost, '127.0.0.1:') ||
    $httpHost === '::1' ||
    str_ends_with($httpHost, '.local') ||
    str_ends_with($httpHost, '.test') ||
    str_ends_with($httpHost, '.localhost')
);

if ($isLocal) {
    $scheme   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $subPath  = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    define('BASE_PATH', $subPath);                       // '' at the root
    define('BASE_URL',  $scheme . '://' . $httpHost . $subPath);
} else {
    define('BASE_PATH', '');
    define('BASE_URL',  'https://cornell.vic.edu.au');
}

// ---------------------------------------------------------------------------
// Site Identity
// ---------------------------------------------------------------------------
define('SITE_NAME', 'Cornell Institute of Training');
define('SITE_EMAIL', 'info@cornell.vic.edu.au');
define('SITE_PHONE', '1300 195 612');
define('TOID', '6074');
define('CRICOS', '03892A');