<?php

use Rmsramos\Activitylog\Resources\ActivitylogResource;

return [
    'resources' => [
        'label'                  => 'Activity Log',
        'plural_label'           => 'Activity Logs',
        'navigation_group'       => 'Settings',
        'navigation_icon'        => 'heroicon-o-shield-check',
        'navigation_sort'        => null,
        'navigation_count_badge' => false,
        'resource'               => ActivitylogResource::class,
    ],
    'datetime_format' => 'd/m/Y H:i:s',
];
