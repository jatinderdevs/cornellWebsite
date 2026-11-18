<?php
/**
 * Cornell Institute of Training — Global Config
 * Include this at the top of every page:
 *   require_once __DIR__ . '/config.php';
 *
 * Detects localhost vs production automatically.
 * Use BASE_URL for absolute links (canonical, OG, schema).
 * Use url() / asset() helpers for all href/src attributes.
 */

// ---------------------------------------------------------------------------
// Environment detection
// ---------------------------------------------------------------------------
$httpHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
$isLocal  = (
    $httpHost === 'localhost' ||
    $httpHost === '127.0.0.1' ||
    str_starts_with($httpHost, 'localhost:') ||
    str_starts_with($httpHost, '127.0.0.1:') ||
    $httpHost === '::1' ||
    // Common local dev hostnames
    str_ends_with($httpHost, '.local') ||
    str_ends_with($httpHost, '.test') ||
    str_ends_with($httpHost, '.localhost')
);

define('IS_LOCAL', $isLocal);
define('IS_PRODUCTION', !$isLocal);

// ---------------------------------------------------------------------------
// Base URL & Path
// ---------------------------------------------------------------------------
// Production domain (always non-www, HTTPS)
define('PRODUCTION_DOMAIN', 'cornell.vic.edu.au');
define('PRODUCTION_URL', 'https://' . PRODUCTION_DOMAIN);

if (IS_LOCAL) {
    // Detect protocol (http on most local setups)
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    // Keep the port if present (e.g. localhost:8080)
    define('BASE_URL', $scheme . '://' . $httpHost);
} else {
    define('BASE_URL', PRODUCTION_URL);
}

// Site root path (usually empty if site is at domain root)
// If you ever host in a subfolder, set this e.g. '/cornell'
define('BASE_PATH', '');

// Absolute path on disk to project root
define('ROOT_PATH', __DIR__);

// ---------------------------------------------------------------------------
// Site identity (used in SEO, schema, emails)
// ---------------------------------------------------------------------------
define('SITE_NAME', 'Cornell Institute of Training');
define('SITE_EMAIL', 'info@cornell.vic.edu.au');
define('SITE_PHONE', '1300 195 612');
define('TOID', '6074');
define('CRICOS', '03892A');

// ---------------------------------------------------------------------------
// Helpers — use these everywhere instead of hard-coded paths
// ---------------------------------------------------------------------------

/**
 * Build a clean internal URL.
 *   url('about')           → /about          (or http://localhost/about)
 *   url('course', $slug)   → /course/certificate-iii-cabinet-making
 *   url()                  → /
 */
function url(string $path = '', string $slug = ''): string
{
    $path = trim($path, '/');
    $slug = trim($slug, '/');

    if ($path === '' || $path === 'index' || $path === 'home') {
        return BASE_PATH . '/';
    }

    // Course detail pages
    if ($path === 'course' && $slug !== '') {
        return BASE_PATH . '/course/' . rawurlencode($slug);
    }

    return BASE_PATH . '/' . $path . ($slug !== '' ? '/' . rawurlencode($slug) : '');
}

/**
 * Absolute URL (for canonical, Open Graph, schema, emails)
 *   absolute_url('about')  → https://cornell.vic.edu.au/about
 */
function absolute_url(string $path = '', string $slug = ''): string
{
    return rtrim(BASE_URL, '/') . url($path, $slug);
}

/**
 * Asset path (CSS, JS, images)
 *   asset('css/style.css')           → /assets/css/style.css
 *   asset('images/logo/logo.png')    → /assets/images/logo/logo.png
 */
function asset(string $path): string
{
    return BASE_PATH . '/assets/' . ltrim($path, '/');
}

/**
 * Current page path helper (useful for active nav states)
 */
function current_path(): string
{
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    return rtrim($uri, '/') ?: '/';
}

/**
 * Simple active-class helper for navigation
 *   active_class('courses')  → 'active' if current page is /courses
 */
function active_class(string $path, string $class = 'active'): string
{
    $current = current_path();
    $target  = url($path);
    return ($current === $target || str_starts_with($current, $target . '/')) ? $class : '';
}