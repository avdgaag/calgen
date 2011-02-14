<?php

class WeekTest extends CalendarTestCase {
    public function setUp() {
        $this->week = new OrangeCubed\Calendar\Week();
        $this->day = new OrangeCubed\Calendar\Day(11, 2, 2011);
    }

    public function testShouldStartWithNoDays() {
        $this->assertAttributeInternalType('array', 'days', $this->week);
        $this->assertAttributeEmpty('days', $this->week);
    }

    public function testShouldAddOneDay() {
        $this->week->addDay($this->day);
        $this->assertcontains($this->day, $this->week->days);
    }

    public function testShouldNotAddOtherThanDay() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $this->week->addDay('foo');
    }

    public function testShouldNotAllowMoreThanSevenDays() {
        for($i = 0; $i <= 6; $i++) {
            $this->week->addDay(new OrangeCubed\Calendar\Day($i, 2, 2011));
        }
        try {
            $this->week->addDay(new OrangeCubed\Calendar\Day(8, 2, 2011));
        } catch(OrangeCubed\Calendar\TooManyDaysException $e) {
            return;
        }
        $this->fail('Expected week to not allow more than 7 days');
    }
}
