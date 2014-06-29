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
 * Report: awesome.
 *
 * @package   report_awesome
 * @author    Luke Carrier <luke@carrier.im>
 * @copyright (c) 2014 Luke Carrier
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once dirname(dirname(__DIR__)) . '/config.php';
require_once "{$CFG->libdir}/adminlib.php";

use report_awesome\forms\report_details_form;
use report_awesome\report;

$reportid  = optional_param('id',      null,  PARAM_INT);
$confirmed = optional_param('confirm', false, PARAM_BOOL);

$report = report::instance($reportid);

$url       = new moodle_url('/report/awesome/delete.php', array('id' => $reportid));
$heading   = new lang_string('deletereport', 'report_awesome', $report);
$targeturl = new moodle_url('/report/awesome/index.php');

admin_externalpage_setup('reportawesomemanage');
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->navbar->add($heading, $PAGE->url->out(false));

if ($confirmed && confirm_sesskey()) {
    $DB->delete_records('awe_reports', array('id' => $reportid));
    redirect($targeturl);
} else {
    echo $OUTPUT->header(),
         $OUTPUT->heading($heading),
         $OUTPUT->confirm(new lang_string('confirmdelete', 'report_awesome', $report),
                          $url->out(false, array('confirm' => true, 'sesskey' => sesskey())),
                          $targeturl);
         $OUTPUT->footer();
}
