<?php
/**
 * Defines all custom exceptions
 *
 * @package Calendar
 */

namespace OrangeCubed\Calendar;

/**
 * Generic library exception that all other custom exceptions inherit from.
 *
 * @package Calendar
 */
class CalendarException extends \Exception {}

/**
 * Custom exception thrown when adding more than seven days to a Week object.
 *
 * @package Calendar
 */
class TooManyDaysException extends CalendarException {}