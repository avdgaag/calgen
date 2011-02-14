<?php
/**
 * Defines TableFormatter class
 *
 * @package Calendar
 */

namespace OrangeCubed\Calendar;

/**
 * Formatter object that can render a Calendar object to an HTML table.
 *
 * @package Calendar
 */
class TableFormatter implements Formatter {
    /**
     * The calender to generate HTML for
     * @var Calendar
     */
    private $calendar;

    /**
     * Generate HTML representation of the given calendar
     *
     * @param Calendar $calender
     * @return String
     */
    public function render(\OrangeCubed\Calendar $calender) {
        $this->calendar = $calender;
        $output = <<<EOS
<table cellspacing="0" cellpadding="0" class="calendar">
    <caption>%s</caption>
    <thead>
        <tr>
            <th>Ma</th>
            <th>Di</th>
            <th>Wo</th>
            <th>Do</th>
            <th>Vr</th>
            <th>Za</th>
            <th>Zo</th>
        </tr>
    </thead>
    <tbody>
%s
    </tbody>
</table>
EOS;
        return sprintf($output, $this->caption(), $this->rows());
    }

    /**
     * Generates the caption for the table.
     *
     * @return String
     */
    private function caption() {
        return sprintf('%s %s', $this->calendar->month_name, $this->calendar->year);
    }

    /**
     * Generates all the rows for the table, to be used in the <tbody> tag.
     *
     * @return String
     */
    private function rows() {
        $output = array();
        $n = count($this->calendar->weeks);
        foreach($this->calendar->weeks as $week) {
            $n--;
            $output[]= $this->row($week, ($n ? '' : 'last'));
        }
        return implode("\n", $output);
    }

    /**
     * Generate a row in the table, matching one week in the calendar.
     *
     * @param Week $week
     * @return String
     */
    private function row(Week $week, $class_name = null) {
        $class_name = $class_name ? " class=\"$class_name\"" : '';
        $output = "        <tr%s>\n%s\n        </tr>";
        $cells = array();
        foreach($week->days as $day) {
            $cells[]= $this->cell($day);
        }
        if(count($week->days) < 7) {
            $spacer = $this->spacer(7 - count($week->days));
            if($week->days[0]->day == 1) {
                array_unshift($cells, $spacer);
            } else {
                array_push($cells, $spacer);
            }
        }
        return sprintf($output, $class_name, implode("\n", $cells));
    }

    /**
     * Generate the spacer cell in the table to cover the days of the week
     * that fall outside the current month. This will return a cell spanning
     * a number of columns.
     *
     * @param Integer $span
     * @return String
     */
    private function spacer($span) {
        return '            <td class="spacer" colspan="' . $span . '"></td>';
    }

    /**
     * Generate a table cell for a given day in the week. All appropriate
     * content and classes will be applied.
     *
     * @param Day $day
     * @return String
     */
    private function cell(Day $day) {
        $classes = array();
        $content = $day->day;
        if($day->is_weekend) $classes[]= 'weekend';
        if($day->is_weekday) $classes[]= 'weekday';
        if($day->is_today)   $classes[]= 'today';
        if($day->is_past)    $classes[]= 'past';
        if($day->is_last_day_of_week) $classes[]= 'last';
        if($day->has_event)  $classes[]= 'with-event';
        foreach($day->categories as $category) {
            $classes[]= 'event-category-' . strtolower($category);
        }
        return sprintf('            <td class="%s"><div>%s<span></span></div></td>', implode(' ', $classes), $content);
    }
}


