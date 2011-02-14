<?php

class EventTest extends CalendarTestCase {
    public function setUp() {
        $this->event = new OrangeCubed\Calendar\Event('2011-01-05 12:23');
    }

    public function testIsOnDate() {
        $this->assertTrue($this->event->isOnDate(5, 1, 2011));

        // Check another day
        $this->assertFalse($this->event->isOnDate(29, 1, 2011));

        // Check wrong notation
        $this->assertFalse($this->event->isOnDate(1, 5, 2011));
    }

    public function testShouldTellItsDay() {
        $this->assertEquals(5, $this->event->day);
    }

    public function testShouldTellItsMonth() {
        $this->assertEquals(1, $this->event->month);
    }

    public function testShouldTellItsYear() {
        $this->assertEquals(2011, $this->event->year);
    }

    public function testShouldThrowWhenDataCannotBeParsed() {
        $this->setExpectedException('InvalidArgumentException');
        $event = new OrangeCubed\Calendar\Event('foo');
    }

    public function testShouldRequireADateOnCreation() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $event = new OrangeCubed\Calendar\Event();
    }

    public function testShouldBeAbleToSetATitle() {
        $this->event->title = 'foo';
        $this->assertEquals('foo', $this->event->title);
    }

    public function testShouldBeAbleToSetALocation() {
        $this->event->location = 'foo';
        $this->assertEquals('foo', $this->event->location);
    }

    public function testShouldBeAbleToSetACategory() {
        $this->event->category = 'foo';
        $this->assertEquals('foo', $this->event->category);
    }

    public function testShouldNotBeAbleToChangeTheDay() {
        $this->markTestIncomplete();
        $this->setExpectedException('PHPUnit_Framework_Error');
        $this->event->day = 10;
    }

    public function testShouldNotBeAbleToChangeTheMonth() {
        $this->markTestIncomplete();
        $this->setExpectedException('PHPUnit_Framework_Error');
        $this->event->month = 4;
    }

    public function testShouldNotBeAbleToChangeTheYear() {
        $this->markTestIncomplete();
        $this->setExpectedException('PHPUnit_Framework_Error');
        $this->event->year = 2010;
    }
}
