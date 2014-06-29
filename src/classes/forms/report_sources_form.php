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
 * @package   report_tdmmodaccess
 * @author    Luke Carrier <luke@tdm.co>
 * @copyright (c) 2014 The Development Manager Ltd
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_awesome\forms;

use lang_string;
use moodleform;
use report_awesome\source_factory;
use report_awesome\traits\lang;

defined('MOODLE_INTERNAL') || die;

/**
 * Report details form.
 *
 * Allows users to edit a report's metadata.
 */
class report_sources_form extends moodleform {
    use lang;

    public function field_select_options($source) {
        $options    = array();
        $sourcename = $source->base_name();

        foreach ($source->fields() as $field) {
            $options[$field] = static::lang_string("source:{$sourcename}:{$field}");
        }

        return $options;
    }

    /**
     * @override \moodleform
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        foreach (source_factory::index() as $sourcename) {
            $source = source_factory::instance($sourcename);

            $mform->addElement('header', $sourcename,
                               static::lang_string("source:$sourcename"));

            // XXX: sources in use in a report shouldn't be collapsed

            $mform->addElement('checkbox', "{$sourcename}_primary",
                               static::lang_string('primary'));

            $element = $mform->addElement('select', "{$sourcename}_display",
                                          static::lang_string('display'),
                                          static::field_select_options($source));
            $element->setMultiple(true);
        }

        $this->set_defaults_from_customdata();

        $this->add_action_buttons();
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
    }

    /**
     * @override \moodleform
     */
    public function validation($data, $files) {
        $errors  = array();
        $sources = source_factory::index();

        /*
         * Exactly one primary source
         */

        $primarysources = array();
        foreach ($sources as $sourcename) {
            if (array_key_exists("{$sourcename}_primary", $data)) {
                $primarysources[] = $sourcename;
            }
        }

        $numprimarysources = count($primarysources);
        if ($numprimarysources >= 0) {
            $primarysources = $numprimarysources > 1 ? $primarysources : $sources;
            foreach ($primarysources as $sourcename) {
                $errors["{$sourcename}_primary"] = static::lang_string_now('error:oneprimary', $numprimarysources);
            }
        }

        // XXX: Secondary sources chained to one another

        // XXX: All sources either have at least one field selected for display or joining

        return $errors;
    }
}
