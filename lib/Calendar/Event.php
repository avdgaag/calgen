<?php
/**
 * Defines Event class
 *
 * @package Calendar
 */

namespace OrangeCubed\Calendar;

/**
 * An event is a collection of properties that can trigger a day on a calendar
 * to get highlighted. An event has a date, so implicitly a single day on the
 * calendar can have any number of events associated with it.
 *
 * An event must have a date; other properties are optional.
 *
 * Note that the parsed date is available as read-only properties, like so:
 *
 *     $event = new Event('2011-02-12');
 *     echo $event->day; # => 12
 *     $event->day = 13; # => error
 *
 *
 * @package Calendar
 */
class Event {
    /**
     * This event's summary title.
     * @var String
     */
    public $title;

    /**
     * This event's location.
     * @var String
     */
    public $location;

    /**
     * This event's internal timestamp.
     * @var String
     */
    private $date;

    /**
     * This event's category.
     * @var String
     */
    public $category;

    /**
     * Cached parse result for this event's month day number.
     * @var String
     */
    private $day;

    /**
     * Cached parse result for this event's month number.
     * @var String
     */
    private $month;

    /**
     * Cached parse result for this event's year.
     * @var String
     */
    private $year;

    public function __construct($date) {
        $d           = strtotime($date);
        if($d === false) throw new \InvalidArgumentException('The date ' . print_r($date, true) . ' cannot be parsed.');
        $d           = getdate($d);
        $this->day   = $d['mday'];
        $this->month = $d['mon'];
        $this->year  = $d['year'];
    }

    public function __get($name) {
        if(property_exists($this, $name)) return $this->$name;
    }

    /**
     * Whether this event is on a given date
     *
     * @param Integer $day
     * @param Integer $month
     * @param Integer $year
     * @return Boolean
     */
    public function isOnDate($day, $month, $year) {
        return $this->month == $month && $this->day == $day && $this->year == $year;
    }
}

