<?php

class TableFormatterTest extends CalendarTestCase {
    public function setUp() {
        $calendar = new OrangeCubed\Calendar(date('m'), date('Y'));
        $this->output = $calendar->render(new OrangeCubed\Calendar\TableFormatter());
    }

    public function testShouldSetCaption() {
        $this->assertRegExp('|<caption>' . date('F') . ' ' . date('Y') . '</caption>|', $this->output);
    }
}
