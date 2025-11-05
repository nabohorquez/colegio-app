<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI / LLM Configuration
    |--------------------------------------------------------------------------
    |
    | Central place to define which AI provider and model the app should use
    | by default. This allows enabling "Claude Sonnet 3.5 for all clients"
    | by setting the environment variable AI_DEFAULT_MODEL accordingly.
    |
    */

    // Provider name (used by your HTTP client/service to route requests)
    'provider' => env('AI_PROVIDER', 'anthropic'),

    // Default model to use when no client-specific model is configured
    'default_model' => env('AI_DEFAULT_MODEL', 'claude-sonnet-3.5'),

    // Optional: tuning/defaults per provider (extend as needed)
    'providers' => [
        'anthropic' => [
            'timeout' => 30,
        ],
        'openai' => [
            'timeout' => 30,
        ],
    ],
];
