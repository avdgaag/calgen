PHP Calendar Utility

A simple library for generating montly calendars, optionally with highlighted events per day. Currently it comes with only HTML table output, but more output formats could be defined.

Simple usage example:

    $calendar     = new OrangeCubed\Calendar(1, 2011);
    $event        = new OrangeCubed\Calendar\Event('2011-01-15');
    $event->title = 'My new event';
    $calendar->addEvent($event);
    echo $calendar->render(new OrangeCubed\TableFormatter());

Proper documentation pending, but you can always generate the inline docs using the 'doc' Rake task.

## TODO

* Let events have any number of properties via a dynamic properties array.
* Let an event be created with other date notations, too.
* Use a default renderer for the calendar

## Credits

Author: Arjan van der Gaag <hello@orangecubed.nl>
URL: http://orangecubed.nl

For a history of changes, see CHANGELOG.md
For license see LICENSE
