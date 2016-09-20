<?php
    return [
        'data_cache_time'                             => 1,
        'service_api_prefix'                          => 'api',
        'service_api_prefix_v2'                       => 'api/v2',
        'admin_service_api_prefix'                    => 'api/Admin/v1',
        'default_date_format'                         => 'Y-m-d H:i:s',
        'default_date_only_format'                    => 'Y-m-d',
        'date_with_month'                             => 'dS F',
        'uploads_folder'                              => 'uploads',
        'token_limit'                                 => 6,
        'backend_user_prefix'                         => 'Admin',
        'default_lang_id'                             => 1,
        'default_role'                                => 'super_admin',
        'time_zone'                                   => 'Australia/Sydney',
        'cache_key_prefix'                            => 'plroo',
        'cache_expire_time'                           => 60, //1 hour in minutes
        'search_sort_types'                           => [
            'SORT_BY_DAILY_RATE'   => 'daily_rate',
            'SORT_BY_RATING_COUNT' => 'rating_count',
            'SORT_BY_LAST_NAME'    => 'business_name',
            'SORT_BY_RATING'       => 'rating'
        ],
        'search_sort_order'                           => [
            'SORT_ASCENDING'  => 'ASC',
            'SORT_DESCENDING' => 'DESC'
        ],

        'normal_user_type'                            => 1,
        'pagination_per_page'                         => 5,
        'pagination_default_page'                     => 1,
        'rate_status'                                 => 1,
        'rate_enabled'                                => 1,
        'stylist_calender_start_days'                 => 2,
        'stylist_calender_all_days'                   => 10,
        'stylist_max_review_rate'                     => 5,
        'stylist_min_review_rate'                     => 1,
        'stylist_rate_thumbs_up_yes'                  => 1,
        'stylist_rate_thumbs_up_no'                   => 0,
        'stylist_search_pagination_per_page'          => 5,
        'stylist_search_max_number_of_days'         => 10,
        'stylist_search_min_number_of_days'         => 1,
        'pagination_items'                            => 10,
        'dashboard_graph_default_past_days'           => 30,
        'dashboard_stats_cache_expire_time'           => 360, //6 hours in minutes
        'stylist_booking_details_pagination_per_page' => 10,
        'stylist_booking_details_time_frame'          => [
            'UPCOMING_BOOKINGS' => 'upcoming',
            'PAST_BOOKINGS'     => 'past'
        ],

        'forbidden_code' => 403,

        'admin_type' => 'Admin',
        'frontend_type' => 'frontend',
        'paypal_payment_type'                         => 'paypal',
        'refund'                                      => 'refund',
        'payment'                                     => 'payment',

        'variable_value_zero'                         => 0,
        'variable_value_one'                          => 1,
        'variable_value_minus_one'                    => -1,
        'variable_value_two'                          => 2,
        'variable_value_three'                        => 3,
        'variable_value_four'                         => 4,
        'variable_value_five'                         => 5,
        'variable_value_six'                          => 6,
        'variable_value_seven'                        => 7,
        'variable_value_eight'                        => 8,
        'variable_value_nine'                         => 9,
        'variable_value_ten'                          => 10,
        'variable_value_eleven'                       => 11,
        'variable_value_twelve'                       => 12,
        'variable_value_thirteen'                     => 13,
        'variable_value_fourteen'                     => 14,
        'variable_value_two_five_five'                => 255,
        'variable_value_thirty'                       => 255,
        'tax_amount'                                  => 0,

        'success' => "success",
        'error' => "error"

    ];
