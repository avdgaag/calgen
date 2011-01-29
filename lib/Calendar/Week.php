<?php

namespace OrangeCubed\Calendar;

/**
 * Container object for days.
 */
class Week {
    public $days;

    public function __construct() {
        $this->days = array();
    }

    public function addDay(Day $day) {
        $this->days[]= $day;
    }
}
