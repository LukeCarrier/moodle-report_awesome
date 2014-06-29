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

$url = new moodle_url('/report/awesome/index.php');

admin_externalpage_setup('reportawesomemanage');
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);

$renderer = $PAGE->get_renderer('report_awesome');

$reports = $DB->get_recordset('awe_reports', null, null, 'id, name') ?: array();

echo $OUTPUT->header(),
     $OUTPUT->heading(new lang_string('managereports', 'report_awesome')),
     $renderer->report_list_table($reports),
     $renderer->report_add_button(),
     $OUTPUT->footer();

$reports->close();
