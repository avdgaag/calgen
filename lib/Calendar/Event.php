<?php

namespace OrangeCubed\Calendar;

class Event {
    public $title;
    public $location;
    public $date;
    public $category;
    private $day;
    private $month;
    private $year;

    public function __construct($title, $location, $date, $category) {
        $this->title    = $title;
        $this->location = $location;
        $this->date     = $date;
        $this->category = $category;
        $d              = getdate(strtotime($this->date));
        $this->day      = $d['mday'];
        $this->month    = $d['mon'];
        $this->year     = $d['year'];
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

