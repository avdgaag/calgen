<?php

class CalendarTest extends CalendarTestCase {
    public function testShouldRequireAMonthAndYear() {
        try {
            $calendar = new OrangeCubed\Calendar();
        } catch(PHPUnit_Framework_Error $e) {
            $calendar = new OrangeCubed\Calendar(11, 2010);
            return;
        }
        $this->fail('Expected Calendar to require month and year');
    }

    public function invalidMonthsAndYears() {
        return array(
            array(-1,   2010),
            array(0,    2010),
            array(13,   2010),
            array(2.5,  2010),
            array(1,    3.2),
            array('ba', 2010),
            array(1,    'foo')
        );
    }

    /**
     * @dataProvider invalidMonthsAndYears
     */
    public function testShouldValidateMonthAndYearOrThrow($m, $y) {
        $this->setExpectedException('InvalidArgumentException');
        $calendar = new OrangeCubed\Calendar($m, $y);
    }

    public function testShouldGetNumberOfDaysInMonth() {
        $jan = new OrangeCubed\Calendar(1, 2011);
        $this->assertEquals(31, $jan->number_of_days);
        $jan = new OrangeCubed\Calendar(2, 2011);
        $this->assertEquals(28, $jan->number_of_days);
    }

    public function testShouldStartWithNoEvents() {
        $cal = new OrangeCubed\Calendar(1, 2011);
        $this->assertAttributeInternalType('array', 'events', $cal);
        $this->assertAttributeEmpty('events', $cal);
    }

    public function testShouldAddEvent() {
        $cal = new OrangeCubed\Calendar(1, 2011);
        $event = new OrangeCubed\Calendar\Event('2011-01-01');
        $cal->addEvent($event);
        $this->assertContains($event, $cal->events);
    }

    public function testShouldNotAddAnythingOtherThanEvent() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $cal = new OrangeCubed\Calendar(1, 2011);
        $cal->addEvent('foo');
    }

    public function testShouldStartWithoutWeeks() {
        $cal = new OrangeCubed\Calendar(1, 2011);
        $this->assertAttributeInternalType('array', 'weeks', $cal);
        $this->assertAttributeEmpty('weeks', $cal);
    }

    // use the mock formatter defined in TestHelper.php
    public function testShouldLetAFormatterRenderOutput() {
        $cal = new OrangeCubed\Calendar(1, 2011);
        $this->assertEquals('foo', $cal->render(new MockFormatter('foo')));
    }

    public function testShouldRequireAFormatterWhenRendering() {
        $cal = new OrangeCubed\Calendar(1, 2011);
        $this->setExpectedException('PHPUnit_Framework_Error');
        $cal->render('foo');
    }
}
