<?php

    // Classes.
    use \lithium\action\Dispatcher;
    use \lithium\core\Libraries;

    /**
     * This filter attempts to automatically determine the model to use for the controller
     * if it doesn't already have one set. We'll base our determination by pluralizing the
     * name of the controller.
     */
    Dispatcher::applyFilter(
        '_callable',
        function($Self, $parameters, $Chain) {
            $Controller = $Chain->next($Self, $parameters, $Chain);
            $Reflection = new ReflectionObject($Controller);
            $Property   = $Reflection->getProperty('_classes');
            $Property->setAccessible(true);

            // Only attempt to determine the model if the controller doesn't have it.
            if (!array_key_exists('model', $Property->getValue($Controller))) {
                $Property->setValue(
                    $Controller,
                    array_merge(
                        array(
                            'model' => Libraries::locate(
                                'models',
                                substr(
                                    get_class($Controller),
                                    strrpos(
                                        get_class($Controller),
                                        '\\'
                                    ) + 1,
                                    -10
                                )
                            )
                        ),
                        $Property->getValue($Controller)
                    )
                );
            }

            return $Controller;
        }
    );