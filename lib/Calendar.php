<?php
/**
 * Defines Calendar class and loads all other library parts
 *
 * @package Calendar
 */

namespace OrangeCubed;

/**
 * A calender is a container of weeks which contain days. Given a month and
 * a year, this object will generate Day objects for all days in the month.
 *
 * You can render a Calendar object to some form of output using a formatter
 * object.
 *
 * @package Calendar
 */
class Calendar {

    /**
     * Library version number in format major.minor.patch
     * @var String
     */
    const VERSION = '0.1.0';

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
     *
     * @throws InvalidArgumentException when the month or year numbers are
     *   invalid.
     * @param Mixed $month_number an integer between 1 and 12
     * @param Mixed $year any valid year number
     */
    public function __construct($month_number, $year) {
        self::assertValidMonthAndYear($month_number, $year);
        $this->month_number    = (int)$month_number;
        $this->year            = (int)$year;
        $this->events          = array();
        $this->weeks           = array();
        $last_day_of_the_month = getdate(mktime(0, 0, 0, $this->month_number + 1, 0, $this->year));
        $this->number_of_days  = $last_day_of_the_month['mday'];
        $this->month_name      = $last_day_of_the_month['month'];
    }

    /**
     * Throws an exception when the given month and year numbers are invalid
     * -- that is, they are not integers or the month is not between 1 and 12.
     *
     * @param Mixed $m month number
     * @param Mixed $y year number
     * @throws InvalidArgumentException
     */
    private static function assertValidMonthAndYear($m, $y) {
        if(
            !is_numeric($m) ||
            !is_numeric($y) ||
            is_float($m) ||
            is_float($y) ||
            $m < 1 ||
            $m > 12
        ) throw new \InvalidArgumentException('Calendar requires an integer month number between 1 and 12, and an integer year number.');
    }

    /**
     * Add an event to this calendar
     */
    public function addEvent(Calendar\Event $event) {
        $this->events[]= $event;
    }

    public function __get($name) {
        if(property_exists($this, $name)) return $this->$name;
    }

    /**
     * Generate all the Week and Day objects for this calendar.
     * This needs to be run before trying to render this instance into some
     * kind of output.
     *
     * @see render()
     */
    private function generate() {
        $week = new Calendar\Week();
        for($i = 1; $i <= $this->number_of_days; $i++) {
            $day = new Calendar\Day($i, $this->month_number, $this->year);
            $day->setEvents($this->eventsOnDay($i, $this->month_number, $this->year));
            if($day->is_first_day_of_week) {
                $this->weeks[]= $week;
                $week = new Calendar\Week();
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
    public function render(Calendar\Formatter $formatter) {
        $this->generate();
        return $formatter->render($this);
    }
}

require dirname(__FILE__) . '/Calendar/Exceptions.php';
require dirname(__FILE__) . '/Calendar/Formatter.php';
require dirname(__FILE__) . '/Calendar/Day.php';
require dirname(__FILE__) . '/Calendar/Week.php';
require dirname(__FILE__) . '/Calendar/TableFormatter.php';
require dirname(__FILE__) . '/Calendar/Event.php';
