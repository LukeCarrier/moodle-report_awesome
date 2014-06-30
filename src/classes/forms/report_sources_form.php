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

    /**
     * Commit changes.
     *
     * @return \report_awesome\report The post-modification report object.
     */
    public function commit() {
        global $DB;

        if (($data = $this->get_data()) === null) {
            return null;
        }

        $report = report::instance($data->id);

        foreach (source_factory::index() as $sourcename) {
            $source = $report->get_source($sourcename);

            $source->isprimary = property_exists($data, "{$sourcename}_isprimary");

            if (property_exists($data, "{$sourcename}_display")) {
                $source->set_display_fields($data->{"{$sourcename}_display"});
            }
        }

        $report->commit();

        return $report;
    }

    /**
     * @override \moodleform
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        foreach (source_factory::index() as $sourcename) {
            $source = source_factory::new_instance($sourcename);

            $mform->addElement('header', $sourcename,
                               static::lang_string("source:{$sourcename}"));

            // XXX: sources in use in a report shouldn't be collapsed

            $mform->addElement('checkbox', "{$sourcename}_isprimary",
                               static::lang_string('isprimary'));

            $element = $mform->addElement('select', "{$sourcename}_display",
                                          static::lang_string('display'),
                                          static::field_select_options($source));
            $element->setMultiple(true);
        }

        $this->add_action_buttons();
    }

    /**
     * Generate <options> for a <select>.
     *
     * @param \report_awesome\abstract_source $source The report source object
     *                                                to generate options for.
     *
     * @return string[] An array of the options ready for passing to the form's
     *                  addElement method.
     */
    protected function field_select_options($source) {
        $options    = array();
        $sourcename = $source->base_name();

        foreach ($source->available_fields() as $field) {
            $options[$field] = static::lang_string("source:{$sourcename}:{$field}");
        }

        return $options;
    }

    /**
     * @override \moodleform
     *
     * @param stdClass $report The report to set defaults for.
     */
    public function set_data($report) {
        $data = array('id' => $report->id);

        foreach ($report->get_sources() as $sourcename => $source) {
            $data["{$sourcename}_isprimary"] = $source->isprimary;

            $data["{$sourcename}_display"] = array();
            foreach ($source->get_display_fields() as $fieldname => $field) {
                $data["{$sourcename}_display"][] = $fieldname;
            }
        }

        parent::set_data($data);
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
            if (array_key_exists("{$sourcename}_isprimary", $data)) {
                $primarysources[] = $sourcename;
            }
        }

        $numprimarysources = count($primarysources);
        if ($numprimarysources !== 1) {
            $primarysources = $numprimarysources > 1 ? $primarysources : $sources;
            foreach ($primarysources as $sourcename) {
                $errors["{$sourcename}_isprimary"] = static::lang_string_now('error:oneprimary', $numprimarysources);
            }
        }

        // XXX: Secondary sources chained to one another

        // XXX: All sources either have at least one field selected for display or joining

        return $errors;
    }
}
