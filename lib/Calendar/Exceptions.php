<?php

namespace OrangeCubed\Calendar;

/**
 * Generic library exception that all other custom exceptions inherit from.
 */
class CalendarException extends \Exception {}

/**
 * Custom exception thrown when adding more than seven days to a Week object.
 */
class TooManyDaysException extends CalendarException {}