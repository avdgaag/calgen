<?php

namespace OrangeCubed\Calendar;

/**
 * Container object for days, making it convenient to work with rows of days
 * as calendars are typically displayed in table-like fashion.
 *
 * @see Day()
 */
class Week {
    /**
     * Collection of Day objects.
     * @var Array
     */
    private $days;

    public function __construct() {
        $this->days = array();
    }

    public function __get($name) {
        if(property_exists($this, $name)) return $this->$name;
    }

    /**
     * Add a day to this week.
     *
     * @see Day()
     * @param Day $day
     */
    public function addDay(Day $day) {
        if(count($this->days) >= 7) throw new TooManyDaysException();
        $this->days[]= $day;
    }
}
