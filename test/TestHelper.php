<?php
/**
 * The TestHelper.php file is loaded before running a test suite,
 * so it can be used to bootstrap the test suite with common helpers,
 * and configuration.
 */

// Require system under test
require dirname(__FILE__) . '/../lib/Calendar.php';

/**
 * Generic project-specific test case, where helper methods available
 * to all other test cases can be defined.
 */
class CalendarTestCase extends \PHPUnit_Framework_TestCase {

}

class MockFormatter implements OrangeCubed\Calendar\Formatter {
    private $return_value;

    public function __construct($return_value) {
        $this->return_value = $return_value;
    }

    public function render(\OrangeCubed\Calendar $calendar) {
        return $this->return_value;
    }
}

