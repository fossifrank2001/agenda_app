<?php
// app/helpers.php

// app/helpers.php

if (!function_exists('set_active')) {
    function set_active($routeNames, $class = 'active') {
        if (is_array($routeNames)) {
            foreach ($routeNames as $routeName) {
                if (request()->routeIs($routeName)) {
                    return $class;
                }
            }
            return '';
        }

        return request()->routeIs($routeNames) ? $class : '';
    }
}

