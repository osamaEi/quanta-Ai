<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Pagination Settings
    |--------------------------------------------------------------------------
    |
    | This value determines the default number of items per page when
    | paginating results. You can change this value to any number
    | that makes sense for your application.
    |
    */

    'per_page' => env('PAGINATION_PER_PAGE', 15),

    /*
    |--------------------------------------------------------------------------
    | Maximum Items Per Page
    |--------------------------------------------------------------------------
    |
    | This value determines the maximum number of items that can be
    | displayed per page. This prevents users from requesting too
    | many items at once, which could impact performance.
    |
    */

    'max_per_page' => env('PAGINATION_MAX_PER_PAGE', 100),

    /*
    |--------------------------------------------------------------------------
    | Minimum Items Per Page
    |--------------------------------------------------------------------------
    |
    | This value determines the minimum number of items that can be
    | displayed per page. This ensures a reasonable minimum for
    | pagination controls.
    |
    */

    'min_per_page' => env('PAGINATION_MIN_PER_PAGE', 5),

    /*
    |--------------------------------------------------------------------------
    | Available Per Page Options
    |--------------------------------------------------------------------------
    |
    | This array defines the available options for items per page that
    | users can select from. The key is the number of items, and the
    | value is the display text.
    |
    */

    'options' => [
        5 => '5 per page',
        10 => '10 per page',
        15 => '15 per page',
        25 => '25 per page',
        50 => '50 per page',
        100 => '100 per page',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination View
    |--------------------------------------------------------------------------
    |
    | This value determines the default pagination view that will be used
    | throughout your application. You can change this to any view that
    | extends the base pagination template.
    |
    */

    'view' => env('PAGINATION_VIEW', 'vendor.pagination.bootstrap-4'),

    /*
    |--------------------------------------------------------------------------
    | Simple Pagination View
    |--------------------------------------------------------------------------
    |
    | This value determines the default simple pagination view that will
    | be used for simple pagination (previous/next only).
    |
    */

    'simple_view' => env('PAGINATION_SIMPLE_VIEW', 'vendor.pagination.simple-bootstrap-4'),

    /*
    |--------------------------------------------------------------------------
    | Pagination Query Parameter
    |--------------------------------------------------------------------------
    |
    | This value determines the query parameter name used for the page
    | number in pagination links.
    |
    */

    'page_parameter' => env('PAGINATION_PAGE_PARAMETER', 'page'),

    /*
    |--------------------------------------------------------------------------
    | Per Page Query Parameter
    |--------------------------------------------------------------------------
    |
    | This value determines the query parameter name used for the number
    | of items per page in pagination links.
    |
    */

    'per_page_parameter' => env('PAGINATION_PER_PAGE_PARAMETER', 'per_page'),

    /*
    |--------------------------------------------------------------------------
    | Pagination Display Settings
    |--------------------------------------------------------------------------
    |
    | These settings control how pagination information is displayed
    | in your application.
    |
    */

    'display' => [
        'show_total' => true,
        'show_per_page_selector' => true,
        'show_page_numbers' => true,
        'show_first_last_links' => true,
        'show_previous_next_links' => true,
        'max_page_numbers' => 5, // Number of page numbers to show around current page
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Styling
    |--------------------------------------------------------------------------
    |
    | These settings control the styling of pagination elements.
    |
    */

    'styling' => [
        'container_class' => 'd-flex justify-content-center',
        'pagination_class' => 'pagination',
        'page_item_class' => 'page-item',
        'page_link_class' => 'page-link',
        'active_class' => 'active',
        'disabled_class' => 'disabled',
        'per_page_container_class' => 'd-flex align-items-center',
        'per_page_label_class' => 'me-2',
        'per_page_select_class' => 'form-select form-select-sm',
    ],

]; 