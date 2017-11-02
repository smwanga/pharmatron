<?php

return array(
    'pdf' => array(
        'enabled' => true,
        'binary' => env('PDF_BINARY', base_path('vendor/bin/wkhtmltopdf-amd64')),
        'timeout' => false,
        'options' => ['load-error-handling' => 'ignore'],
        'env' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env' => array(),
    ),
);
