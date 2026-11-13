<?php

/**
 * Cornell Institute of Training - Courses Data
 * Use with: $course = $courses['msf30322'];
 */

$courses = [

    // =====================================================
    // CONSTRUCTION & TRADES
    // =====================================================

    'cpc30220' => [
        'slug'            => 'certificate-iii-carpentry',
        'code'            => 'CPC30220',
        'title'           => 'Certificate III in Carpentry',
        'cricos'          => '117651D',          // from enrolment form
        'category'        => 'Construction',
        'duration_weeks'  => 54,
        'contact_weeks'   => 48,                 // approximate – confirm
        'hours_per_week'  => 20,
        'enrolment_fee'   => 300,
        'tuition_fee'     => 'Contact us',
        'location'        => 'Melbourne',
        'hero_image'      => 'carpentry.jpg',
        'short_desc'      => 'Gain practical carpentry skills for residential and commercial construction work.',
        'description'     => 'This qualification provides a trade outcome in carpentry, covering the skills required to work on residential and commercial projects. Students learn to construct, install and repair timber and formwork structures.',
        'pathways_study'  => [
            'CPC40120 – Certificate IV in Building and Construction',
            'CPC50220 – Diploma of Building and Construction (Building)',
        ],
        'pathways_job'    => ['Carpenter', 'Formwork Carpenter', 'Joiner'],
        'units'           => [
            // Add full unit list when available
        ],
        'assessment'      => ['Demonstrations', 'Written Questions & Answers', 'Case Studies', 'Projects'],
    ],

    'msf30322' => [
        'slug'            => 'certificate-iii-cabinet-making',
        'code'            => 'MSF30322',
        'title'           => 'Certificate III in Cabinet Making and Timber Technology',
        'cricos'          => '113236G',
        'category'        => 'Construction',
        'duration_weeks'  => 54,
        'contact_weeks'   => 48,
        'hours_per_week'  => 20,
        'enrolment_fee'   => 300,
        'tuition_fee'     => 'Contact us',
        'location'        => 'Melbourne and Brisbane',
        'hero_image'      => 'cabinet.jpg',
        'short_desc'      => 'Develop tradesperson-level skills in the manufacture and installation of furniture and cabinetry.',
        'description'     => 'Workers with this qualification have tradesperson-level skills in the manufacture and/or installation of products, including furniture and cabinetry, made from timber and other materials. They have core skills in tool use, measuring, drawing (including CAD), interpreting work documents, preparing cutting lists, communication, teamwork, and safe work practices.',
        'pathways_study'  => [
            'MSF40318 – Certificate IV in Kitchen and Bathroom Design',
            'MSF50222 – Diploma of Furniture Design and Manufacturing',
            'MSF60122 – Advanced Diploma of Interior Design',
        ],
        'pathways_job'    => ['Cabinet Maker'],
        'units'           => [
            ['code' => 'MSMSUP102', 'title' => 'Communicate in the workplace', 'type' => 'Core'],
            ['code' => 'MSMSUP106', 'title' => 'Work in a team', 'type' => 'Core'],
            ['code' => 'MSMENV272', 'title' => 'Participate in environmentally sustainable work practices', 'type' => 'Core'],
            ['code' => 'MSFFM2013', 'title' => 'Use furniture making hand and power tools', 'type' => 'Core'],
            ['code' => 'MSFGN3005', 'title' => 'Read and interpret work documents', 'type' => 'Core'],
            ['code' => 'MSFFM3031', 'title' => 'Prepare cutting lists from design and production documentation', 'type' => 'Core'],
            ['code' => 'MSFGN2001', 'title' => 'Make measurements and calculations', 'type' => 'Core'],
            ['code' => 'MSFFM3030', 'title' => 'Produce manual and computer-aided production drawings', 'type' => 'Core'],
            ['code' => 'MSFFM3029', 'title' => 'Select timbers for furniture production', 'type' => 'Elective'],
            ['code' => 'MSFFM2017', 'title' => 'Hand make timber joints', 'type' => 'Elective'],
            ['code' => 'MSFFM2016', 'title' => 'Join solid timber', 'type' => 'Elective'],
            ['code' => 'MSFFF2012', 'title' => 'Prepare surfaces for finishing', 'type' => 'Elective'],
            ['code' => 'MSFFM2019', 'title' => 'Assemble furnishing products', 'type' => 'Elective'],
            ['code' => 'MSFFF2014', 'title' => 'Apply surface coatings by spray gun', 'type' => 'Elective'],
            ['code' => 'MSFFM2015', 'title' => 'Apply sheet laminates by hand', 'type' => 'Elective'],
            ['code' => 'MSFFM2014', 'title' => 'Select and apply hardware', 'type' => 'Elective'],
            ['code' => 'MSFFM3042', 'title' => 'Fabricate cabinetry', 'type' => 'Elective'],
            ['code' => 'MSFFM3041', 'title' => 'Determine and document requirements for cabinetry installation', 'type' => 'Elective'],
            ['code' => 'MSFKB3012', 'title' => 'Plan kitchen and bathroom projects', 'type' => 'Elective'],
            ['code' => 'MSFKB2003', 'title' => 'Prepare for cabinetry installation', 'type' => 'Elective'],
            ['code' => 'MSFFM3043', 'title' => 'Install cabinetry', 'type' => 'Elective'],
            ['code' => 'BSBOPS304', 'title' => 'Deliver and monitor a service to customers', 'type' => 'Elective'],
            ['code' => 'CPCWHS1001', 'title' => 'Prepare to work safely in the construction industry', 'type' => 'Elective'],
            ['code' => 'MSMWHS200', 'title' => 'Work safely', 'type' => 'Elective'],
            ['code' => 'MSFFM2018', 'title' => 'Operate basic static machines safely', 'type' => 'Elective'],
        ],
        'assessment'      => ['Demonstrations', 'Written Questions & Answers', 'Case Studies', 'Projects'],
    ],

    'cpc40120' => [
        'slug'            => 'certificate-iv-building-construction',
        'code'            => 'CPC40120',
        'title'           => 'Certificate IV in Building and Construction',
        'cricos'          => '117652C',
        'category'        => 'Construction',
        'duration_weeks'  => 42,
        'contact_weeks'   => 36,
        'hours_per_week'  => 20,
        'enrolment_fee'   => 300,
        'tuition_fee'     => 'Contact us',
        'location'        => 'Melbourne',
        'hero_image'      => 'build.jpg',
        'short_desc'      => 'Prepare for roles as a builder, site manager or construction supervisor.',
        'description'     => 'This qualification reflects the role of builders, site managers and managers of small to medium-sized building businesses who apply knowledge of structural principles, codes, standards and legal requirements to Class 1 and 10 (to a maximum of two storeys) and Class 2 to 9 Type C constructions.',
        'pathways_study'  => [
            'CPC50220 – Diploma of Building and Construction (Building)',
        ],
        'pathways_job'    => ['Builder', 'Construction Supervisor', 'Site Manager', 'Site Supervisor', 'Leading Hand'],
        'units'           => [
            ['code' => 'CPCCBC4053', 'title' => 'Apply building codes and standards to the construction process for Class 2 to 9, Type C Buildings', 'type' => 'Core'],
            ['code' => 'CPCCBC4001', 'title' => 'Apply building codes and standards to the construction process for Class 1 and 10 Buildings', 'type' => 'Core'],
            ['code' => 'CPCCBC4002', 'title' => 'Manage work health and safety in the building and construction workplace', 'type' => 'Core'],
            ['code' => 'CPCCBC4007', 'title' => 'Plan building or construction work', 'type' => 'Core'],
            ['code' => 'CPCCBC4008', 'title' => 'Supervise site communication and administration processes for building and construction projects', 'type' => 'Core'],
            ['code' => 'CPCCBC4009', 'title' => 'Apply legal requirements to building and construction projects', 'type' => 'Core'],
            ['code' => 'CPCCBC4010', 'title' => 'Apply structural principles to residential and commercial constructions', 'type' => 'Core'],
            ['code' => 'CPCCBC4012', 'title' => 'Read and interpret plans and specifications', 'type' => 'Core'],
            ['code' => 'CPCCBC4014', 'title' => 'Prepare simple building sketches and drawings', 'type' => 'Core'],
            ['code' => 'CPCCBC4018', 'title' => 'Apply site surveys and set-out procedures to building and construction projects', 'type' => 'Core'],
            ['code' => 'CPCCBC4021', 'title' => 'Minimise waste on the building and construction site', 'type' => 'Core'],
            // electives truncated for brevity – full list available
        ],
        'assessment'      => ['Demonstrations', 'Written Questions & Answers', 'Case Studies', 'Projects'],
    ],

    'cpc30620' => [
        'slug'            => 'certificate-iii-painting-decorating',
        'code'            => 'CPC30620',
        'title'           => 'Certificate III in Painting and Decorating',
        'cricos'          => '119424K',
        'category'        => 'Construction',
        'duration_weeks'  => 54,
        'contact_weeks'   => 48,
        'hours_per_week'  => 20,
        'enrolment_fee'   => 300,
        'tuition_fee'     => 'Contact us',
        'location'        => 'Melbourne',
        'hero_image'      => 'painting.jpg',
        'short_desc'      => 'Learn professional painting and decorating skills for residential and commercial projects.',
        'description'     => 'This qualification provides a trade outcome in painting and decorating, covering the preparation of surfaces and application of paint and other finishes.',
        'pathways_study'  => [],
        'pathways_job'    => ['Painter and Decorator'],
        'units'           => [],
        'assessment'      => ['Demonstrations', 'Written Questions & Answers', 'Case Studies', 'Projects'],
    ],

    'cpc50220' => [
        'slug'            => 'diploma-building-construction',
        'code'            => 'CPC50220',
        'title'           => 'Diploma of Building and Construction (Building)',
        'cricos'          => '118410B',
        'category'        => 'Construction',
        'duration_weeks'  => 54,
        'contact_weeks'   => 48,
        'hours_per_week'  => 20,
        'enrolment_fee'   => 300,
        'tuition_fee'     => 'Contact us',
        'location'        => 'Melbourne',
        'hero_image'      => 'dipcon.webp',
        'short_desc'      => 'Advance your career in building and construction management.',
        'description'     => 'This qualification is designed for people who want to work as builders or construction managers on medium-rise projects.',
        'pathways_study'  => [],
        'pathways_job'    => ['Builder', 'Construction Manager', 'Project Manager'],
        'units'           => [],
        'assessment'      => ['Demonstrations', 'Written Questions & Answers', 'Case Studies', 'Projects'],
    ],

    // =====================================================
    // HOSPITALITY
    // =====================================================

    'sit30821' => [
        'slug'            => 'certificate-iii-commercial-cookery',
        'code'            => 'SIT30821',
        'title'           => 'Certificate III in Commercial Cookery',
        'cricos'          => '109901B',
        'category'        => 'Hospitality',
        'duration_weeks'  => 55,
        'contact_weeks'   => 46,
        'hours_per_week'  => 20,
        'enrolment_fee'   => 300,
        'tuition_fee'     => 'Contact us',
        'location'        => 'Melbourne',
        'hero_image'      => 'cooking.jpg',
        'short_desc'      => 'Master the essential skills of commercial cookery for restaurants, hotels and cafés.',
        'description'     => 'This qualification reflects the role of commercial cooks who use a wide range of well-developed cookery skills and sound knowledge of kitchen operations to prepare food and menu items. Using discretion and judgement, they work with some independence and under limited supervision.',
        'pathways_study'  => [
            'SIT40521 – Certificate IV in Kitchen Management',
        ],
        'pathways_job'    => ['Commercial Cook', 'Commis Chef'],
        'units'           => [
            ['code' => 'SITXFSA005', 'title' => 'Use hygienic practices for food safety', 'type' => 'Core'],
            ['code' => 'SITHCCC027', 'title' => 'Prepare dishes using basic methods of cookery', 'type' => 'Core'],
            ['code' => 'SITXFSA006', 'title' => 'Participate in safe food handling practices', 'type' => 'Core'],
            ['code' => 'SITHKOP001', 'title' => 'Clean kitchen premises and equipment', 'type' => 'Core'],
            ['code' => 'SITXINV006', 'title' => 'Receive, store and maintain stock', 'type' => 'Core'],
            ['code' => 'SITHCCC023', 'title' => 'Use food preparation equipment', 'type' => 'Core'],
            ['code' => 'SITHCCC028', 'title' => 'Prepare appetisers and salads', 'type' => 'Core'],
            ['code' => 'SITHCCC029', 'title' => 'Prepare stocks, sauces and soups', 'type' => 'Core'],
            ['code' => 'SITHCCC030', 'title' => 'Prepare vegetable, fruit, eggs and farinaceous dishes', 'type' => 'Core'],
            ['code' => 'SITHCCC031', 'title' => 'Prepare vegetarian and vegan dishes', 'type' => 'Core'],
            ['code' => 'SITHCCC035', 'title' => 'Prepare poultry dishes', 'type' => 'Core'],
            ['code' => 'SITHCCC036', 'title' => 'Prepare meat dishes', 'type' => 'Core'],
            ['code' => 'SITHCCC037', 'title' => 'Prepare seafood dishes', 'type' => 'Core'],
            ['code' => 'SITHCCC041', 'title' => 'Produce cakes, pastries and breads', 'type' => 'Core'],
            ['code' => 'SITHPAT016', 'title' => 'Produce desserts', 'type' => 'Core'],
            ['code' => 'SITHCCC042', 'title' => 'Prepare food to meet special dietary requirements', 'type' => 'Core'],
            ['code' => 'SITHKOP010', 'title' => 'Plan and cost recipes', 'type' => 'Core'],
            ['code' => 'SITXWHS005', 'title' => 'Participate in safe work practices', 'type' => 'Core'],
            ['code' => 'SITXHRM007', 'title' => 'Coach others in job skills', 'type' => 'Core'],
            ['code' => 'SITHCCC043', 'title' => 'Work effectively as a cook (WBT)', 'type' => 'Core'],
            // electives...
        ],
        'assessment'      => ['Demonstrations', 'Workplace Training', 'Projects', 'Case Studies', 'Written Questions & Answers'],
    ],

    'sit40521' => [
        'slug'            => 'certificate-iv-kitchen-management',
        'code'            => 'SIT40521',
        'title'           => 'Certificate IV in Kitchen Management',
        'cricos'          => '109593J',
        'category'        => 'Hospitality',
        'duration_weeks'  => 73,
        'contact_weeks'   => 60,
        'hours_per_week'  => 20,
        'enrolment_fee'   => 300,
        'tuition_fee'     => 'Contact us',
        'location'        => 'Melbourne',
        'hero_image'      => 'cooking.jpg',
        'short_desc'      => 'Advance to kitchen management and supervisory roles in commercial kitchens.',
        'description'     => 'This qualification reflects the role of chefs and cooks who have a supervisory or team leading role in the kitchen. They operate independently or with limited guidance from others and use discretion to solve non-routine problems.',
        'pathways_study'  => [
            'SIT50422 – Diploma of Hospitality Management',
        ],
        'pathways_job'    => ['Chef', 'Chef de Partie', 'Sous Chef'],
        'units'           => [],
        'assessment'      => ['Demonstrations', 'Workplace Training', 'Projects', 'Case Studies', 'Written Questions & Answers'],
    ],

    'sit50422' => [
        'slug'            => 'diploma-hospitality-management',
        'code'            => 'SIT50422',
        'title'           => 'Diploma of Hospitality Management',
        'cricos'          => '113237F',
        'category'        => 'Hospitality',
        'duration_weeks'  => 73,
        'contact_weeks'   => 60,
        'hours_per_week'  => 20,
        'enrolment_fee'   => 300,
        'tuition_fee'     => 'Contact us',
        'location'        => 'Melbourne',
        'hero_image'      => 'cooking.jpg',
        'short_desc'      => 'Develop management skills for hotels, restaurants and tourism operations.',
        'description'     => 'This qualification reflects the role of highly skilled senior operators who use a broad range of hospitality skills combined with managerial skills and sound knowledge of industry to coordinate hospitality operations.',
        'pathways_study'  => [
            'SIT60322 – Advanced Diploma of Hospitality Management',
        ],
        'pathways_job'    => ['Restaurant Manager', 'Hotel Manager', 'Banquet Manager', 'Front Office Manager'],
        'units'           => [],
        'assessment'      => ['Demonstrations', 'Projects', 'Case Studies', 'Written Questions & Answers'],
    ],

    'sit60322' => [
        'slug'            => 'advanced-diploma-hospitality-management',
        'code'            => 'SIT60322',
        'title'           => 'Advanced Diploma of Hospitality Management',
        'cricos'          => '118940J',
        'category'        => 'Hospitality',
        'duration_weeks'  => 104,
        'contact_weeks'   => 88,
        'hours_per_week'  => 20,
        'enrolment_fee'   => 300,
        'tuition_fee'     => 'Contact us',
        'location'        => 'Melbourne',
        'hero_image'      => 'cooking.jpg',
        'short_desc'      => 'Prepare for senior management roles in the hospitality industry.',
        'description'     => 'This qualification reflects the role of highly skilled senior managers who use a broad range of hospitality skills combined with specialised managerial skills and knowledge to coordinate hospitality operations.',
        'pathways_study'  => [],
        'pathways_job'    => ['General Manager', 'Operations Manager', 'Food and Beverage Manager'],
        'units'           => [],
        'assessment'      => ['Demonstrations', 'Projects', 'Case Studies', 'Written Questions & Answers'],
    ],

];

/**
 * Helper – get a single course by key
 */
function get_course(string $key): ?array
{
    global $courses;
    return $courses[$key] ?? null;
}