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

    /**
     * @todo make sure to adapt the calling script to new constructor
     */
    public function __construct($date) {
        $this->date  = $date;
        $d           = strtotime($this->date);
        if($d === false) throw new \InvalidArgumentException('The date ' . print_r($date, true) . ' cannot be parsed.');
        $d           = getdate($d);
        $this->day   = $d['mday'];
        $this->month = $d['mon'];
        $this->year  = $d['year'];
    }

    public function __get($name) {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
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

