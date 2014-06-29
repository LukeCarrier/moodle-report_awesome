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
 * TDM: Course module access report.
 *
 * @package   report_awesome
 * @author    Luke Carrier <luke@carrier.im>
 * @copyright (c) 2014 Luke Carrier
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_awesome\forms;

use moodleform;
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
     * @override \moodleform
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'name', static::lang_string('reportname'));
        $mform->setType('name', PARAM_TEXT);

        $this->add_action_buttons();

        if ($this->_customdata['report'] !== null) {
            $this->set_defaults_from_customdata();
        }
    }

    /**
     * Set defaults from custom data.
     *
     * Sets constant and default values from those contained within the form's
     * custom data.
     *
     * @return void
     */
    protected function set_defaults_from_customdata() {
        $mform  = $this->_form;
        $report = $this->_customdata['report'];

        $mform->setConstant('id', $report->id);

        $mform->setDefault('name', $report->name);
    }
}
