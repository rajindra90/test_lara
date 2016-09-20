<?php
return [
    'register' => [
        'successfully' => 'The user was registered successfully.
        A link to activate your account has been sent to your email.',
        'error'        => 'The user has not been registered successfully.'
    ],
    'login'    => [
        'email_not_verified'           => 'Your email address has not been verified',
        'details_is_not_correct'       => 'User login details are not correct. Please try again.',
        'cant_find_user_belongs_email' => 'There is no user account under this email.',
        'disable'                      => 'User account has been disabled. Please contact administrator.'
    ],

    'reset_password' => [
        'code_sent'                    => 'The user reset code has been sent. Please check your email.',
        'reset_code_not_sent'          => 'The user reset code has not been sent. Please try again.',
        'cant_find_user_belongs_email' => 'There is no user account under this email.',
        'code_is_not_valid'            => 'Reset code is invalid.',
        'reset_successfully'           => 'Password has been changed successfully.',
        'not_reset_successfully'       => 'Failed to change password. Please try again.',
        'not_match_password'           => 'Confirm password is not match.'
    ],
    'delete'            => [
        'success'               => 'Selected user(s) successfully deleted.',
        'error'                 => 'Some error occurred while processing the request. Please try again.',
        'have_ongoing_bookings' => 'Some user(s) have profiles that have pending or accepted bookings (with future dates). Please try to resolve them and try again.'
    ],
    'update'            => [
        'not_match_password'      => 'Confirm password is not match.',
        'not_update_successfully' => 'Failed to update user data. Please try again.',
        'update_successfully'     => 'User details has been changed successfully.',
        'password_invalid'        => 'Your current password is not correct. Please try again.',
        'new_password'            => 'Your new password is required.'
    ],
    'logout'            => [
        'successfully' => 'User successfully logout',
        'error'        => 'Failed to logout user. Please try again'
    ],
    'active_email_temp' => [
        'successfully' => 'Your email address has been confirmed.',
        'error'        => 'Failed to confirm email. Please try again'

    ],
    'general' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Email',
        'last_login' => 'Last Login',
        'registered_date' => 'Registered Date',
        'user' => 'User',
        'name' => 'Name',
        'status' => 'Status',
        'enabled' => 'Enabled',
        'disabled' => 'Disabled',
        'created' => 'Created on',
    ]

];