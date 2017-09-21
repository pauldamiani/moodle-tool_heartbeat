<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Performs a progress bar test
 *
 * @package    tool_heartbeat
 * @copyright  2017 Rossco Hellmans <rossco@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_OUTPUT_BUFFERING', true); // progress bar is used here

require(__DIR__ . '/../../../config.php');

$syscontext = context_system::instance();
$PAGE->set_url('/admin/tool/heartbeat/compresscheck.php');
$PAGE->set_context($syscontext);
$PAGE->set_cacheable(false);

$ttfb = optional_param('ttfb', 1, PARAM_INT);
// Default fixed size is 50KB.
$fixedsize = optional_param('fixedsize', 51200, PARAM_INT);

sleep($ttfb);

$header = $OUTPUT->header();
$heading = $OUTPUT->heading(get_string('compresscheck', 'tool_heartbeat'));
$help = get_string('compresscheckhelp', 'tool_heartbeat');
$footer = $OUTPUT->footer();

$remainingsize = $fixedsize - strlen($header) - strlen($heading) - strlen($help) - strlen($footer);

echo $header;
echo $heading;
echo $help;

$string = '';

for ($i = 0; $i < $remainingsize; $i = $i + 2) {
    $string .= '. ';

    if ($i % 10240 === 0) {
        sleep(1);
        echo $string;
        $string = '';
    }
}

sleep(1);
echo $string;

echo $footer;
