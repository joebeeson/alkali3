<?php

    // Classes.
    use \lithium\core\Environment;

    /**
     * Convenience function for quickly printing out an arbitrary
     * variable.
     *
     * @param $variable mixed
     * @return void
     */
    function pr($variable) {
        if (!Environment::is('production')) {
            if (is_bool($variable)) {
                var_dump($variable);
            } else {
                echo '<pre>' . print_r($variable, true) . '</pre>';
            }
        }
    }