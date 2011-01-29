<?php

namespace OrangeCubed\Calendar;

/**
 * Represents a single day in the calender. Essentially a placeholder for
 * a bunch of flags, such as whether it is a weekend day, a weekday, today
 * or the first day of a week.
 */
class Day {
    /**
     * Number of the month for this date.
     * @var Integer
     */
    private $month;

    /**
     * Year for this date.
     * @var Integer
     */
    private $year;

    /**
     * Number of the day in the week for this date.
     * @var Integer
     */
    private $weekday;

    /**
     * Number of the day in the month for this date.
     * @var Integer
     */
    public $day;

    /**
     * Flag whether this is a day in the working week.
     * @var Boolean
     */
    public $is_weekday;

    /**
     * Flag whether this is a day in the weekend.
     * @var Boolean
     */
    public $is_weekend;

    /**
     * Flag whether this is the first day of a week.
     * @var Boolean
     */
    public $is_first_day_of_week;

    /**
     * Flag whether this is the first day of a week.
     * @var Boolean
     */
    public $is_last_day_of_week;

    /**
     * Flag whether the date has past
     * @var Boolean
     */
    public $is_past;

    /**
     * List of all events on this day
     * @var Array<Event>
     */
    public $events;

    /**
     * List of all event categories for this day
     * @var Array<String>
     */
    public $categories;

    /**
     * Create a new Day with basic date coordinates.
     *
     * @param Integer $day
     * @param Integer $month
     * @param Integer $year
     */
    public function __construct($day, $month, $year) {
        $this->day        = $day;
        $this->month      = $month;
        $this->year       = $year;
        $date             = getdate(mktime(0, 0, 0, $this->month, $this->day, $this->year));
        $this->weekday    = $date['wday'];
        $this->events     = array();
        $this->categories = array();
        $this->setFlags();
    }

    /**
     * Associate events with this day
     *
     * @param Array<Event>
     */
    public function setEvents(array $events = array()) {
        $this->events = $events;
        $this->setFlags();
    }

    /**
     * Sets a bunch of flags on this objects based on its date.
     */
    private function setFlags() {
        $this->is_first_day_of_week = $this->weekday === 1;
        $this->is_last_day_of_week  = $this->weekday === 0;
        $this->is_weekday           = $this->weekday > 0 && $this->weekday < 6;
        $this->is_weekend           = $this->weekday == 0 || $this->weekday == 6;
        $today                      = getdate();
        $this->is_today             = $this->month == $today['mon'] && $this->year == $today['year'] && $this->day == $today['mday'];
        $this->is_past              = $this->month <= $today['mon'] && $this->year <= $today['year'] && $this->day < $today['mday'];
        $this->has_event            = count($this->events) > 0;
        foreach($this->events as $event) {
            $this->categories[]= $event->category;
        }
        $this->categories = array_unique($this->categories);
    }
}

