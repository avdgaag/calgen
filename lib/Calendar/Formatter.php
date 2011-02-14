<?php
/**
 * Defines Formatter interface
 *
 * @package Calendar
 */

namespace OrangeCubed\Calendar;

/**
 * Common interface for Formatter classes, which should have a render method.
 *
 * @package Calendar
 */
interface Formatter {
    public function render(\OrangeCubed\Calendar $calendar);
}