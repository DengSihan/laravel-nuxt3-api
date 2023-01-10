<?php 

return [
    /**
     * Interface frequency limitation
     */
    'rate_limits' => [
        // general data
        'ordinary' =>  env('RATE_LIMITS_ORDINARY', '60,1'),
        // advanced
        'advanced' =>  env('RATE_LIMITS_ADVANCED', '20,1'),
        // vital important
        'extreme' => env('RATE_LIMITS_EXTREME', '10,1')
    ],
];