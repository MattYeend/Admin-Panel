<?php 

return [
    'dashboard_route' => '/queue-monitor', // Accessible at http://your-app.com/queue-monitor
    'notifications' => [
        'enabled' => true,
        'email' => env('QUEUE_MONITOR_NOTIFICATION_EMAIL', 'admin@example.com'),
    ],
];