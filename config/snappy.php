<?php

return array(
    'pdf' => array(
        'enabled' => true,
        'binary' => 'xvfb-run /usr/local/bin/wkhtmltopdf',
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
