<?php

namespace OrangeCubed\Calendar;

/**
 * Common interface for Formatter classes, which should have a render method.
 */
interface Formatter {
    public function render(\OrangeCubed\Calendar $calendar);
}