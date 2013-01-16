<?php

    // Classes.
    use \lithium\core\Libraries;

    /**
     * Here we setup some defaults if the developer has failed
     * to provide them.
     */
    Libraries::add(
        'alkali3',
        array_merge(
            array(
                /**
                 * Library default configuration will go here.
                 */
            ),
            array_merge(
                Libraries::get('alkali3'),
                array(
                    'bootstrap' => false
                )
            )
        )
    );

    // Filters for execution.
    require __DIR__ . '/bootstrap/filters.php';
