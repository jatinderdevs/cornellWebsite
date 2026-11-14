<?php
/**
 * Google Reviews section (reusable include)
 *
 * Usage (anywhere in a page):
 *   <?php include 'includes/reviews.php'; ?>
*
* Optional settings – set BEFORE the include:
* $reviewsOpts = [
* 'json' => __DIR__ . '/data/reviews-cache.json', // path to the cached Places JSON
* 'eyebrow' => 'Student reviews',
* 'title' => 'What our students say',
* 'limit' => 6, // max reviews shown
* 'min_rating' => 4, // hide reviews below this star rating
* 'exclude' => [], // author display names to hide, e.g. ['Usman Virk']
* ];
*
* Needs once per page:
*

* (before </body>)
*/

$rvOpts = array_merge([
'json' => __DIR__ . '/../data/reviews-cache.json',
'eyebrow' => 'Student reviews',
'title' => 'What our students say',
'limit' => 6,
'min_rating' => 4,
'exclude' => [],
], $reviewsOpts ?? []);

$rvData = is_readable($rvOpts['json']) ? json_decode(file_get_contents($rvOpts['json']), true) : null;
if (!is_array($rvData) || empty($rvData['reviews'])) {
return; // nothing to show – render no section
}

if (!function_exists('rv_ago')) {
function rv_ago($iso, $fallback = '') {
$t = $iso ? strtotime($iso) : false;
if (!$t) return $fallback;
$d = max(0, (int) floor((time() - $t) / 86400));
if ($d < 1) return 'Today' ; if ($d < 7) return $d . ($d===1 ? ' day ago' : ' days ago' ); if ($d < 30) { $w=(int)
    floor($d / 7); return $w . ($w===1 ? ' week ago' : ' weeks ago' ); } if ($d < 365) { $m=(int) floor($d / 30); return
    $m . ($m===1 ? ' month ago' : ' months ago' ); } $y=(int) floor($d / 365); return $y . ($y===1 ? ' year ago'
    : ' years ago' ); } function rv_stars($n) { $n=max(0, min(5, (int) round($n)));
    $out='<span class="rv-stars" role="img" aria-label="' . $n . ' out of 5 stars">' ; for ($i=1; $i <=5; $i++) { $out
    .='<svg viewBox="0 0 24 24" class="' . ($i <=$n ? 'is-on' : '' )
    . '" aria-hidden="true"><path d="M12 2.5l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.4l-5.9 3.1 1.2-6.5L2.5 9.4l6.6-.9L12 2.5z"/></svg>'
    ; } return $out . '</span>' ; } } // Filter + sort newest first
    $rvReviews=array_values(array_filter($rvData['reviews'], function ($r) use ($rvOpts) {
    $name=$r['authorAttribution']['displayName'] ?? '' ; return ($r['rating'] ?? 0)>= $rvOpts['min_rating']
    && !empty($r['text']['text'])
    && !in_array($name, $rvOpts['exclude'], true);
    }));
    usort($rvReviews, function ($a, $b) { return strcmp($b['publishTime'] ?? '', $a['publishTime'] ?? ''); });
    $rvReviews = array_slice($rvReviews, 0, (int) $rvOpts['limit']);
    if (!$rvReviews) return;

    $rvRating = (float) ($rvData['rating'] ?? 0);
    $rvCount = (int) ($rvData['userRatingCount'] ?? count($rvReviews));
    $rvMaps = $rvData['googleMapsUri'] ?? '';
    $rvName = $rvData['displayName']['text'] ?? '';

    $rvGoogleG = '<svg class="rv-g" viewBox="0 0 48 48" aria-hidden="true">
        <path fill="#EA4335"
            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
        <path fill="#4285F4"
            d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
        <path fill="#FBBC05"
            d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
        <path fill="#34A853"
            d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
    </svg>';
    ?>
    <section class="rv" data-reviews aria-labelledby="rv-title">
        <div class="container">
            <div class="rv-layout">

                <!-- Summary -->
                <div class="rv-summary">
                    <p class="rv-eyebrow"><?= htmlspecialchars($rvOpts['eyebrow']) ?></p>
                    <h2 class="rv-title heading" id="rv-title"><?= htmlspecialchars($rvOpts['title']) ?></h2>

                    <div class="rv-score">
                        <span class="rv-score-num"><?= number_format($rvRating, 1) ?></span>
                        <div class="rv-score-meta">
                            <?= rv_stars($rvRating) ?>
                            <span>Based on <?= $rvCount ?> Google reviews</span>
                        </div>
                    </div>

                    <?php if ($rvMaps): ?>
                    <a href="<?= htmlspecialchars($rvMaps) ?>" class="btn-pill btn-pill-primary" target="_blank"
                        rel="noopener noreferrer">
                        Read all on Google <span class="btn-icon">→</span>
                    </a>
                    <?php endif; ?>

                    <p class="rv-powered"><?= $rvGoogleG ?> Reviews from Google</p>
                </div>

                <!-- Carousel -->
                <div class="rv-carousel" role="region" aria-roledescription="carousel" aria-label="Student reviews">
                    <ul class="rv-track" tabindex="0" aria-label="Scroll to see more reviews">
                        <?php foreach ($rvReviews as $r):
                      $a    = $r['authorAttribution'] ?? [];
                      $nm   = $a['displayName'] ?? 'Google user';
                      $init = mb_strtoupper(mb_substr($nm, 0, 1));
                    ?>
                        <li class="rv-card">
                            <div class="rv-card-top">
                                <?= rv_stars($r['rating'] ?? 5) ?>
                                <?= $rvGoogleG ?>
                            </div>

                            <blockquote class="rv-text">
                                <p><?= nl2br(htmlspecialchars(trim($r['text']['text']))) ?></p>
                            </blockquote>
                            <button type="button" class="rv-more" hidden aria-expanded="false">Read more</button>

                            <div class="rv-author">
                                <span class="rv-avatar" data-initial="<?= htmlspecialchars($init) ?>">
                                    <?php if (!empty($a['photoUri'])): ?>
                                    <img src="<?= htmlspecialchars($a['photoUri']) ?>" alt="" width="44" height="44"
                                        loading="lazy" referrerpolicy="no-referrer" />
                                    <?php endif; ?>
                                </span>
                                <span class="rv-author-info">
                                    <?php if (!empty($a['uri'])): ?>
                                    <a href="<?= htmlspecialchars($a['uri']) ?>" class="rv-author-name" target="_blank"
                                        rel="noopener noreferrer"><?= htmlspecialchars($nm) ?></a>
                                    <?php else: ?>
                                    <span class="rv-author-name"><?= htmlspecialchars($nm) ?></span>
                                    <?php endif; ?>
                                    <span
                                        class="rv-date"><?= htmlspecialchars(rv_ago($r['publishTime'] ?? '', $r['relativePublishTimeDescription'] ?? '')) ?></span>
                                </span>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="rv-controls">
                        <div class="rv-dots" role="group" aria-label="Choose review"></div>
                        <div class="rv-arrows">
                            <button type="button" class="rv-arrow" data-dir="-1" aria-label="Previous reviews">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M15 5l-7 7 7 7" />
                                </svg>
                            </button>
                            <button type="button" class="rv-arrow" data-dir="1" aria-label="Next reviews">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>