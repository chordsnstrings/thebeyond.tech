<?php

return [
    'name' => 'Beyond',
    'legal_name' => 'The BeyondTech',
    'tagline' => 'The technology, AI & research engine of ARKS Groups.',
    'description' => 'Beyond is the in-house AI, research and engineering studio behind ARKS Groups — '
        .'building the intelligent platforms, data systems and products that run a portfolio across '
        .'mobility, energy, migration and wellness.',
    'url' => env('APP_URL', 'https://www.thebeyond.tech'),
    'email' => 'partners@thebeyond.tech',
    'location' => 'Dubai, United Arab Emirates',

    'parent' => [
        'name' => 'ARKS Groups Investments LLC',
        'url' => 'https://www.arks.ae',
    ],

    'socials' => [
        'LinkedIn' => 'https://www.linkedin.com/company/thebeyondtech',
        'X' => 'https://x.com/thebeyondtech',
    ],

    // Primary navigation, reused by desktop + mobile layouts.
    'nav' => [
        ['label' => 'Capabilities', 'route' => 'capabilities'],
        ['label' => 'Portfolio', 'route' => 'portfolio'],
        ['label' => 'Research', 'route' => 'research.index'],
        ['label' => 'About', 'route' => 'about'],
    ],
];
