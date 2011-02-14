<?php

namespace OrangeCubed;

/**
 * A calender is a container of weeks which contain days. Given a month and
 * a year, this object will generate Day objects for all days in the month.
 *
 * You can render a Calendar object to some form of output using a formatter
 * object.
 */
class Calendar {

    /**
     * Library version number in format major.minor.patch
     * @var String
     */
    const VERSION = '0.0.0';

    /**
     * The calendar month number (e.g. 1)
     * @var Integer
     */
    public  $month_number;

    /**
     * The calendar year
     * @var Integer
     */
    public  $year;

    /**
     * Collection of weeks in this month
     * @var Array
     */
    public  $weeks;

    /**
     * The month name (e.g. january)
     * @var String
     */
    public  $month_name;

    /**
     * The total number of days in this month
     * @var Integer
     */
    public  $number_of_days;

    /**
     * The month number
     * @var Integer
     */
    private $events;

    /**
     * Create a new calendar for a given month and year.
     */
    public function __construct($month_number, $year) {
        $this->month_number    = $month_number;
        $this->year            = (int)$year;
        $this->events          = array();
        $this->weeks           = array();
        $last_day_of_the_month = getdate(mktime(0, 0, 0, $this->month_number + 1, 0, $this->year));
        $this->number_of_days  = $last_day_of_the_month['mday'];
        $this->month_name      = $last_day_of_the_month['month'];
    }

    /**
     * Add an event to this calendar
     */
    public function addEvent(Event $event) {
        $this->events[]= $event;
    }

    /**
     * Generate all the Week and Day objects for this calendar.
     */
    private function generate() {
        $week = new Week();
        for($i = 1; $i <= $this->number_of_days; $i++) {
            $day = new Day($i, $this->month_number, $this->year);
            $day->setEvents($this->eventsOnDay($i, $this->month_number, $this->year));
            if($day->is_first_day_of_week) {
                $this->weeks[]= $week;
                $week = new Week();
            }
            $week->addDay($day);
        }
        $this->weeks[]= $week;
    }

    /**
     * Array of all events occuring on a given date
     *
     * @param Integer $day
     * @param Integer $month
     * @param Integer $year
     * @return Array<Event>
     */
    private function eventsOnDay($day, $month, $year) {
        $output = array();
        foreach($this->events as $event) {
            if($event->isOnDate($day, $month, $year)) {
                $output[]= $event;
            }
        }
        return $output;
    }

    /**
     * Render this calendar to some kind of output using a formatter.
     *
     * @param Formatter $formatter is the object that generates the output.
     * @return Mixed whatever the formatter will return.
     */
    public function render($formatter) {
        $this->generate();
        return $formatter->render($this);
    }
}

require dirname(__FILE__) . '/Calendar/Day.php';
require dirname(__FILE__) . '/Calendar/Week.php';
require dirname(__FILE__) . '/Calendar/TableFormatter.php';
require dirname(__FILE__) . '/Calendar/Event.php';
