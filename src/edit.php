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

use report_awesome\exceptions\invalid_edit_param_exception;
use report_awesome\report_form_factory;

$editform = optional_param('edit', 'details', PARAM_ALPHA);
$reportid = optional_param('id',   0,         PARAM_INT);

$url       = new moodle_url('/report/awesome/edit.php');
$cancelurl = new moodle_url('/report/awesome/index.php');

if ($reportid === 0) {
    $report  = null;
    $heading = new lang_string('createreport', 'report_awesome');
} else {
    $report  = $DB->get_record('awe_reports', array('id' => $reportid), '*', MUST_EXIST);
    $heading = new lang_string('editreport', 'report_awesome', $report);

    $url->param('id', $reportid);
}

admin_externalpage_setup('reportawesomemanage');
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->navbar->add($heading, $PAGE->url->out(false));

if (!$mform = report_form_factory::instance($editform, array('report' => $report))) {
    throw new invalid_edit_param_exception();
}
$renderer = $PAGE->get_renderer('report_awesome');

if ($mform->is_cancelled()) {
    redirect($cancelurl);
} elseif ($data = $mform->get_data()) {
    $record = (object) array(
        'name' => $data->name,
    );

    if ($data->id > 0) {
        $record->id = $data->id;
        $DB->update_record('awe_reports', $record);
    } else {
        $record->id = $DB->insert_record('awe_reports', $record);
    }

    redirect($url->out(false, array('id' => $record->id)));
} else {
    echo $OUTPUT->header(),
         $OUTPUT->heading($heading);
    if ($report !== null) {
        echo $renderer->report_tabs($report, $editform);
    }
    $mform->display();
    echo $OUTPUT->footer();
}
