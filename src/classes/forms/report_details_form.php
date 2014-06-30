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
 * Report: Awesome.
 *
 * @package   report_awesome
 * @author    Luke Carrier <luke@carrier.im>
 * @copyright (c) 2014 Luke Carrier
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_awesome\forms;

use moodleform;
use report_awesome\report;
use report_awesome\traits\lang;

defined('MOODLE_INTERNAL') || die;

/**
 * Report details form.
 *
 * Allows users to edit a report's metadata.
 */
class report_details_form extends moodleform {
    use lang;

    /**
     * Commit changes.
     *
     * @return void
     */
    public function commit() {
        global $DB;

        if (($data = $this->get_data()) === null) {
            return null;
        }

        $record = new report($data->name);
        if ($data->id > 0) {
            $record->id = $data->id;
        }
        $record->commit();

        return $record;
    }


    /**
     * @override \moodleform
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'name', static::lang_string('reportname'));
        $mform->setType('name', PARAM_TEXT);

        $this->add_action_buttons();
    }

    /**
     * @override \moodleform
     *
     * @param stdClass $report The report to set defaults for.
     */
    public function set_data($report) {
        parent::set_data(array(
            'id'   => $report->id,
            'name' => $report->name,
        ));
    }
}
