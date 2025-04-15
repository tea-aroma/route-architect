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
];
