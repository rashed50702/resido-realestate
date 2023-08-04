<?php

return [
    'name' => 'plugins/real-estate::settings.email.title',
    'description' => 'plugins/real-estate::settings.email.description',
    'templates' => [
        'notice' => [
            'title' => 'plugins/real-estate::consult.settings.email.templates.notice_title',
            'description' => 'plugins/real-estate::consult.settings.email.templates.notice_description',
            'subject' => 'New consult',
            'can_off' => true,
        ],
        'new-pending-property' => [
            'title' => 'New pending property',
            'description' => 'Send email to admin when a new property created',
            'subject' => 'New pending property by {{ post_author }} waiting for approve',
            'can_off' => true,
            'enabled' => false,
        ],
        'account-registered' => [
            'title' => 'Account registered',
            'description' => 'Send a notification to admin when a new account registered',
            'subject' => 'New account registered on {{ site_title }}',
            'can_off' => true,
            'enabled' => false,
        ],
        'confirm-email' => [
            'title' => 'Confirm email',
            'description' => 'Send email to user when they register an account to verify their email',
            'subject' => 'Confirm Email Notification',
            'can_off' => false,
        ],
        'password-reminder' => [
            'title' => 'Reset password',
            'description' => 'Send email to user when requesting reset password',
            'subject' => 'Reset Password',
            'can_off' => false,
        ],
        'payment-receipt' => [
            'title' => 'Payment receipt',
            'description' => 'Send a notification to user when they buy credits',
            'subject' => 'Payment receipt for package {{ package_name }} on {{ site_title }}',
            'can_off' => true,
            'enabled' => false,
        ],
        'free-credit-claimed' => [
            'title' => 'Free credit claimed',
            'description' => 'Send a notification to admin when free credit is claimed',
            'subject' => '{{ account_name }} has claimed free credit on {{ site_title }}',
            'can_off' => true,
            'enabled' => false,
        ],
        'payment-received' => [
            'title' => 'Payment received',
            'description' => 'Send a notification to admin when someone buy credits',
            'subject' => 'Payment received from {{ account_name }} on {{ site_title }}',
            'can_off' => true,
            'enabled' => false,
        ],
    ],
    'variables' => [
        'consult_name' => 'Name',
        'consult_phone' => 'Phone',
        'consult_email' => 'Email',
        'consult_content' => 'Content',
        'consult_link' => 'Link',
        'consult_subject' => 'Subject',
        'post_author' => 'Post Author',
        'post_name' => 'Post Name',
        'post_url' => 'Post URL',
        'account_name' => 'Account name',
        'account_email' => 'Account email',
        'package_name' => 'Name of package',
        'package_price' => 'Price',
        'package_discount' => 'Discount',
        'package_total' => 'Total',
        'verify_link' => 'Verify email link',
        'reset_link' => 'Reset password link',
    ],
];
