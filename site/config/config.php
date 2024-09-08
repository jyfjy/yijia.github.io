<?php
return [
    'home' => 'works', // replace 'works' with the slug of your works page
];

return [
    'thumbs' => [
        'driver' => 'im',
        'interlace' => true, // Use Imagick for better performance with large images
        'quality' => 100,  // Set image quality to 80
        'presets' => [
            'default' => ['width' => 1024, 'quality' => 100],
            'highres' => ['width' => 2048, 'quality' => 100],
        ],
        'maxMemory' => '256M', // Increase memory limit for thumbnail generation
        'maxTime' => 60,       // Increase maximum execution time
    ],
];
