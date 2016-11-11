<?php

/*
 * This file is part of Laravel Hashids.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'salt' => '!@#$%^',
            'length' => '11',
            'alphabet' => 'qi15jJp9FsbQITuh7k3cygEBmRS2wNzvGAPXrZVfnHt8MadDLlOWUe4YC6oKx',
        ],

        'alternative' => [
            'salt' => '!@#$%^123456',
            'length' => '11',
            'alphabet' => 'OHTAIerl5ofQdGvR7KiXEFPM9gazcmZpyL1nCw3hWqUSxs8NVtJj2Y6kbB4Du',
        ],

    ],

];
