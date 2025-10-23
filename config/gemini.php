<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google Gemini AI Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Google Gemini AI API integration
    | 
    | Free Tier Limits:
    | - Gemini 1.5 Flash: 15 requests/min, 1,500 requests/day, 1M tokens/day
    | - Gemini 1.5 Pro: 2 requests/min, 50 requests/day
    |
    */

    'api_key' => env('GEMINI_API_KEY'),

    'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),

    'base_url' => 'https://generativelanguage.googleapis.com/v1beta/models/',

    'timeout' => env('GEMINI_TIMEOUT', 30),

    'max_output_tokens' => env('GEMINI_MAX_TOKENS', 1000),

    'temperature' => env('GEMINI_TEMPERATURE', 0.7),

    /*
    |--------------------------------------------------------------------------
    | EcoEvents AI Dataset Configuration
    |--------------------------------------------------------------------------
    */

    'eco_context' => [
        'Tunisia' => [
            'climate' => 'Mediterranean, semi-arid',
            'main_environmental_issues' => [
                'Water scarcity',
                'Desertification', 
                'Marine pollution',
                'Urban air quality',
                'Waste management'
            ],
            'seasonal_activities' => [
                'spring' => ['Tree planting', 'Beach cleanup', 'Nature walks'],
                'summer' => ['Water conservation', 'Solar energy workshops', 'Coastal protection'],
                'autumn' => ['Harvest festivals', 'Composting workshops', 'Forest restoration'],
                'winter' => ['Indoor eco-workshops', 'Energy saving campaigns', 'Recycling drives']
            ]
        ]
    ],

    'event_types' => [
        'cleanup' => [
            'name' => 'Nettoyage environnemental',
            'keywords' => ['nettoyage', 'déchets', 'plage', 'forêt', 'rivière'],
            'impact_factors' => ['waste_collected', 'area_cleaned', 'participants']
        ],
        'planting' => [
            'name' => 'Plantation et reforestation',
            'keywords' => ['plantation', 'arbres', 'reforestation', 'jardin', 'agriculture'],
            'impact_factors' => ['trees_planted', 'area_covered', 'co2_absorbed']
        ],
        'education' => [
            'name' => 'Sensibilisation écologique',
            'keywords' => ['workshop', 'formation', 'sensibilisation', 'éducation'],
            'impact_factors' => ['people_educated', 'knowledge_shared', 'behavior_change']
        ],
        'conservation' => [
            'name' => 'Conservation de la nature',
            'keywords' => ['conservation', 'biodiversité', 'protection', 'faune', 'flore'],
            'impact_factors' => ['species_protected', 'habitat_preserved', 'ecosystem_health']
        ]
    ],

    'languages' => [
        'primary' => 'fr', // French
        'secondary' => ['ar', 'en'] // Arabic, English
    ]

];