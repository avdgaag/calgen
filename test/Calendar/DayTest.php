<?php

class DayTest extends CalendarTestCase {
    public function testShouldNotBeCreatedWithoutADate() {
        $this->setExpectedException('InvalidArgumentException');
        new OrangeCubed\Calendar\Day();
    }

    public function testShouldNotBeCreatedWithoutNumericalArguments() {
        $this->setExpectedException('InvalidArgumentException');
        new OrangeCubed\Calendar\Day('foo', 'bar', 'baz');
    }

    public function testShouldBeCreatedWithStringNumbers() {
        $day = new OrangeCubed\Calendar\Day('1', '2', '3');
        $this->assertNotNull($day);
    }

    public function testShouldBeCreatedWithIntegers() {
        $day = new OrangeCubed\Calendar\Day(1, 2, 3);
        $this->assertNotNull($day);
    }

    public function testShouldIndicateFirstDayOfTheWeek() {
        $day = new OrangeCubed\Calendar\Day(24, 1, 2011);
        $this->assertTrue($day->is_first_day_of_week);
    }

    public function testShouldIndicateLastDayOfTheWeek() {
        $day = new OrangeCubed\Calendar\Day(30, 1, 2011);
        $this->assertTrue($day->is_last_day_of_week);
    }

    public function testShouldIndicateWeekday() {
        $friday   = new OrangeCubed\Calendar\Day(28, 1, 2011);
        $saturday = new OrangeCubed\Calendar\Day(29, 1, 2011);
        $monday   = new OrangeCubed\Calendar\Day(24, 1, 2011);
        $this->assertTrue($friday->is_weekday);
        $this->assertFalse($saturday->is_weekday);
        $this->assertTrue($monday->is_weekday);
    }

    public function testShouldIndicateWeekend() {
        $friday   = new OrangeCubed\Calendar\Day(28, 1, 2011);
        $saturday = new OrangeCubed\Calendar\Day(29, 1, 2011);
        $sunday   = new OrangeCubed\Calendar\Day(30, 1, 2011);
        $this->assertFalse($friday->is_weekend);
        $this->assertTrue($saturday->is_weekend);
        $this->assertTrue($sunday->is_weekend);
    }

    public function testShouldIndicateToday() {
        $month     = date("n");
        $day       = date("j");
        $year      = date("Y");
        $today     = new OrangeCubed\Calendar\Day($day, $month, $year);
        $yesterday = new OrangeCubed\Calendar\Day(28, 1, 2011);
        $this->assertTrue($today->is_today);
        $this->assertFalse($yesterday->is_today);
    }

    public function testShouldIndicatePast() {
        $month     = date("n");
        $day       = date("j");
        $year      = date("Y");
        $today     = new OrangeCubed\Calendar\Day($day, $month, $year);
        $yesterday = new OrangeCubed\Calendar\Day(28, 1, 2011);
        $this->assertTrue($yesterday->is_past);
        $this->assertFalse($today->is_past);
    }

    public function testShouldIndicateFuture() {
        $month    = date("n");
        $day      = date("j");
        $year     = date("Y");
        $today    = new OrangeCubed\Calendar\Day($day, $month, $year);

        $tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));
        $month    = date("n", $tomorrow);
        $day      = date("j", $tomorrow);
        $year     = date("Y", $tomorrow);
        $tomorrow = new OrangeCubed\Calendar\Day($day, $month, $year);

        $this->assertTrue($tomorrow->is_future);
        $this->assertFalse($today->is_future);
    }

    public function testShouldIndicateEvents() {
        $day = new OrangeCubed\Calendar\Day(29, 1, 2011);
        $this->assertFalse($day->has_event);
        $event = (object)array('category' => 'foo');
        $day->setEvents(array($event));
        $this->assertTrue($day->has_event);
    }
}
