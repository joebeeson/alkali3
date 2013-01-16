<?php

    // Classes.
    use lithium\net\http\Router;

    /**
     * We'll want these routes, just in case the main application
     * doesn't define these.
     */
    Router::connect(
        '/{:controller}/read/{:id}',
        array(
            'action' => 'read'
        )
    );

    Router::connect(
        '/{:controller}/update/{:id}',
        array(
            'action' => 'update'
        )
    );

    Router::connect(
        '/{:controller}/delete/{:id}',
        array(
            'action' => 'delete'
        )
    );