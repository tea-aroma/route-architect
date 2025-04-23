<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Auto Scan
    |--------------------------------------------------------------------------
    |
    | Determines whether routes should be declaring automatically.
    |
    */

    'auto_scan' => env('ROUTE_ARCHITECT_AUTO_SCAN', false),

    /*
    |--------------------------------------------------------------------------
    | Url Variable Template
    |--------------------------------------------------------------------------
    |
    | Defines how variables are wrapped in the URL.
    |
    */

    'url_variable_template' => env('ROUTE_ARCHITECT_URL_VARIABLE_TEMPLATE', '{%s}'),

    /*
    |--------------------------------------------------------------------------
    | Url Delimiter
    |--------------------------------------------------------------------------
    |
    | Separator between URL segments.
    |
    */

    'url_delimiter' => env('ROUTE_ARCHITECT_URL_DELIMITER', '/'),

    /*
    |--------------------------------------------------------------------------
    | Url Segment Delimiter
    |--------------------------------------------------------------------------
    |
    | Delimiter used within individual URL segments.
    |
    */

    'url_segment_delimiter' => env('ROUTE_ARCHITECT_URL_SEGMENT_DELIMITER', '-'),

    /*
    |--------------------------------------------------------------------------
    | Route Name Delimiter
    |--------------------------------------------------------------------------
    |
    | Separator between name of route segments.
    |
    */

    'route_name_delimiter' => env('ROUTE_ARCHITECT_ROUTE_NAME_DELIMITER', '.'),

    /*
    |--------------------------------------------------------------------------
    | View Name Delimiter
    |--------------------------------------------------------------------------
    |
    | Separator between name of view segments.
    |
    */

    'view_name_delimiter' => env('ROUTE_ARCHITECT_VIEW_NAME_DELIMITER', '.'),

    /*
    |--------------------------------------------------------------------------
    | Action Delimiter
    |--------------------------------------------------------------------------
    |
    | Separator between namespace of a class and an action name.
    |
    */

    'action_delimiter' => env('ROUTE_ARCHITECT_ACTION_DELIMITER', '@'),
];
