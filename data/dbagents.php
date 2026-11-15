<?php

/**
 * Cornell Institute of Training - Education Agents Data
 *
 * Used by agents.php:
 *   include_once('includes/dbagents.php');
 *   $list = get_agents();
 *
 * HOW TO ADD AN AGENT
 * Copy one block inside $agents, fill in what you have and delete the rest.
 * Only 'name' is required. Anything left empty is simply not shown on the page.
 *
 *   'name'     Agency name (required)
 *   'country'  Used for the country filter (the filter only appears when
 *              the list has 2 or more different countries)
 *   'city'     Optional, shown next to the country
 *   'address'  Full address as you want it displayed
 *   'email'    Agent email (becomes a "mailto:" button)
 *   'phone'    Optional
 *   'website'  With or without https:// (only http/https links are shown)
 *   'logo'     Optional file name inside assets/img/agents/  e.g. 'abc-education.png'
 *              (initials are shown when there is no logo)
 *   'status'   'active' (default) or 'inactive' - inactive agents are hidden
 */

/* ---------------------------------------------------------------
   Page settings (links and contact details used on the agents page)
   --------------------------------------------------------------- */
$agent_settings = [
    // "Apply via Agent Portal" button. Replace with your real portal link.
    'apply_url'     => 'https://agents.cornell.vic.edu.au',

    // PDF link for "Download application form". Leave '' to hide the button.
    'form_url'      => '',

    'support_email' => 'info@cornell.vic.edu.au',
    'support_phone' => '1300 195 612',
];

/* ---------------------------------------------------------------
   Agents list
   --------------------------------------------------------------- */
$agents = [

    // [
    //     'name'    => 'Example Education Pty Ltd',
    //     'country' => 'India',
    //     'city'    => 'Chandigarh',
    //     'address' => 'SCO 123, Sector 17, Chandigarh 160017',
    //     'email'   => 'info@example-education.com',
    //     'phone'   => '+91 00000 00000',
    //     'website' => 'https://www.example-education.com',
    //     'logo'    => '',
    //     'status'  => 'active',
    // ],

    // Source: agentzone table (21 agents). The 'address' values are suburbs/cities as listed there.
    ['name' => 'Aggarwal Consultants Pty Ltd',                  'address' => 'Williams Landing', 'email' => 'infoaggarwal3@gmail.com',              'website' => 'https://www.aggarwalimmigration.com.au/'],
    ['name' => 'Asia Pacific Education Consultants Pty Ltd',    'address' => 'Melbourne',        'email' => 'priya@asiapacificgroup.com',           'website' => 'https://www.asiapacificgroup.com'],
    ['name' => 'Aum Global Education Services',                 'address' => 'Melbourne',        'email' => 'admin@aumglobal.com.au',               'website' => 'https://www.aumglobal.com.au'],
    ['name' => 'Cies Consultants Pty. Ltd.',                    'address' => 'Melbourne',        'email' => 'education@cies.net.au',                'website' => 'https://www.cies.net.au'],
    ['name' => 'Danfe International Pty Ltd',                   'address' => 'Melbourne',        'email' => 'accounts.mel@danfeinternational.com',  'website' => 'https://www.danfeinternational.com'],
    ['name' => 'E Planet Brisbane',                             'address' => 'Brisbane City',    'email' => 'info@eplanetintl.com.au',              'website' => 'https://www.eplanet.edu.np/'],
    ['name' => 'Elegance Education Consultancy Pty Ltd',        'address' => 'Craigieburn',      'email' => 'admissions@eecvic.com.au',             'website' => 'https://www.eecvic.com.au'],
    ['name' => 'Future Migration Australia Pty Ltd',            'address' => 'Berwick',          'email' => 'student@fmecaustralia.com.au',         'website' => 'https://www.fmecaustralia.com.au'],
    ['name' => 'Future Study Education Services Pty Ltd',       'address' => 'Tarneit',          'email' => 'info@futurestudy.com.au',              'website' => 'https://www.futurestudy.com.au'],
    ['name' => 'Go Global Immigration',                         'address' => 'Perth',            'email' => 'm.mann@goglobalimmigration.com',       'website' => 'https://www.goglobalimmigration.com'],
    ['name' => 'Gratus Education & Immigration Consultants',    'address' => 'Dandenong',        'email' => 'ekta@gratusconsultants.com.au',        'website' => 'https://www.gratusconsultants.com.au'],
    ['name' => 'Koala Education Consulting',                    'address' => 'Bulimba',          'email' => 'eser@study-in-australia.net',          'website' => 'https://www.study-in-australia.net'],
    ['name' => 'New Roots Migration And Education Consultants', 'address' => 'Melbourne',        'email' => 'info@newrootsmigration.com',           'website' => 'https://www.newrootsmigration.com'],
    ['name' => 'P&G Migration Consultants',                     'address' => 'Cranbourne West',  'email' => 'enquiries@pgmigration.com.au',         'website' => 'https://www.pgmigration.com.au'],
    ['name' => 'Probity Lawyers',                               'address' => 'Docklands',        'email' => 'info@probitylawyers.com.au',           'website' => 'https://www.probitylawyers.com.au'],
    ['name' => 'Zoom Education & Migration',                    'address' => 'Tarneit',          'email' => 'admissions@zoomeducation.com.au',      'website' => 'https://www.zoomeducation.com.au'],
    ['name' => 'Skywings Migration & Education Consultants',    'address' => 'Nobel Park',       'email' => 'education@skywings.com.au',            'website' => 'https://www.skywings.com.au'],
    ['name' => 'Stepping Stones Career',                        'address' => 'Melbourne',        'email' => 'admissions.sscs@gmail.com',            'website' => 'https://sscs.com.au/'],
    ['name' => 'Upright Migration Consultants',                 'address' => 'Melbourne',        'email' => 'info@uprightmigration.com.au',         'website' => 'https://www.uprightmigration.com.au'],
    ['name' => 'Visacare Migration Consultants',                'address' => 'Clyde North',      'email' => 'enquiry@visacare.com.au',              'website' => 'https://www.visacare.com.au'],
    ['name' => 'Viva Immigration Pty Ltd',                      'address' => 'Melbourne',        'email' => 'info@vivaimmigration.com.au',          'website' => 'https://www.vivaimmigration.com.au'],

];

/* ---------------------------------------------------------------
   Helpers
   --------------------------------------------------------------- */

/** Active agents, sorted A-Z by name. */
function get_agents(): array
{
    global $agents;

    $list = array_values(array_filter($agents, function ($a) {
        return !empty($a['name']) && strtolower($a['status'] ?? 'active') !== 'inactive';
    }));

    usort($list, function ($a, $b) {
        return strcasecmp($a['name'], $b['name']);
    });

    return $list;
}

/** Unique, sorted countries from a list of agents. */
function agent_countries(array $list): array
{
    $countries = [];
    foreach ($list as $a) {
        $c = trim($a['country'] ?? '');
        if ($c !== '') {
            $countries[strtolower($c)] = $c;
        }
    }
    asort($countries, SORT_NATURAL | SORT_FLAG_CASE);
    return $countries; // [ 'india' => 'India', ... ]
}

/** Up to two initials for the avatar fallback. */
function agent_initials(string $name): string
{
    $words = preg_split('/[\s&\-]+/u', trim($name), -1, PREG_SPLIT_NO_EMPTY);
    $out = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $out .= mb_strtoupper(mb_substr($w, 0, 1));
    }
    return $out !== '' ? $out : '?';
}

/** Returns a safe http(s) URL or null. */
function agent_url(?string $url): ?string
{
    $url = trim((string) $url);
    if ($url === '') {
        return null;
    }
    if (!preg_match('#^[a-z][a-z0-9+.-]*://#i', $url)) {
        $url = 'https://' . $url;
    }
    $parts = parse_url($url);
    if (!$parts || empty($parts['host']) || !in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)) {
        return null;
    }
    return $url;
}

/** Readable host for button/label, e.g. "example.com". */
function agent_host(string $url): string
{
    $host = parse_url($url, PHP_URL_HOST) ?: $url;
    return preg_replace('/^www\./i', '', $host);
}