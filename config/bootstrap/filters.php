<?php

    /**
     * Eh, it's a bit messy looking but this will utilize the SPL
     * for getting any PHP files beneath our filters folder and then
     * include them.
     */
    foreach (
        new RegexIterator(
            new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    __DIR__ . '/filters'
                )
            ),
            '/^.+\.php$/i'
        )
        as $SplFileInfo
    ) {
        include $SplFileInfo->getRealPath();
    }
