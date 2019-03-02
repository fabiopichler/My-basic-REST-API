<?php
$settings = [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // PDO settings
        'db' => [
    	    'driver'    => 'mysql',
    	    'host'      => 'localhost',
    	    'database'  => 'basic_api',
    	    'username'  => 'root',
    	    'password'  => '',
    	    'charset'   => 'utf8mb4',
    	    'collation' => 'utf8mb4_unicode_ci',
    	    'prefix'    => '',
        ],
    ],
];

if (file_exists(__DIR__.'/../.env.php'))
    require __DIR__.'/../.env.php';

return $settings;
