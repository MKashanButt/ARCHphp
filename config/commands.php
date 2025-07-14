<?php

use ARCHphp\Scripts\Server;
use ARCHphp\Scripts\Projects;
use ARCHphp\Scripts\Models;
use ARCHphp\Scripts\Controllers;
use ARCHphp\Scripts\Migrations;

return [
    "start" => [
        "handler" => [Server::class, 'run'],
        "description" => "Start the development server"
    ],
    'new' => [
        "handler" => [Projects::class, 'create'],
        "description" => "Create a new project"
    ],
    'make:model' => [
        "handler" => [Models::class, 'create'],
        "description" => "Create a new model"
    ],
    'delete:model' => [
        "handler" => [Models::class, 'delete'],
        "description" => "Delete an existing model"
    ],
    'make:controller' => [
        "handler" => [Controllers::class, 'create'],
        "description" => "Create a new controller"
    ],
    'migrate' => [
        'handler' => [Migrations::class, 'migrate'],
        'description' => 'Run database migrations'
    ],
    'rollback' => [
        'handler' => [Migrations::class, 'rollback'],
        'description' => 'Rollback the last batch of migrations'
    ],
    'help' => [
        'handler' => fn() => null,
        'description' => 'Show this help message',
    ]
];
