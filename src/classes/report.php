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

namespace report_awesome;

defined('MOODLE_INTERNAL') || die;

/**
 * Report object.
 */
class report extends abstract_model {
    /**
     * Report name.
     *
     * @var string
     */
    protected $name;

    /**
     * Report sources.
     *
     * @var \report_awesome\abstract_source[]
     */
    protected $sources;

    /**
     * Initialiser.
     *
     * @param string $name Report name.
     */
    public function __construct($name=null) {
        $this->name = $name;
    }

    /**
     * Add a source to the report.
     */
    public function add_source(source $source) {
    }

    /**
     * @override \report_awesome\abstract_model
     */
    public static function dml_fields() {
        return array('id', 'name');
    }

    /**
     * @override \report_awesome\abstract_model
     */
    public static function dml_table() {
        return 'awe_reports';
    }

    /**
     * @override \report_awesome\abstract_model
     */
    public function populate($record) {
        parent::populate($record);

        $this->reload_sources();
    }

    /** 
     * Reload the report's sources from the database.
     *
     * After making modifications to the record's source associations, you'll
     * want to call this method in order to ensure the two don't fall out of
     * sync.
     *
     * @return void
     */
    public function reload_sources() {
        global $DB;

        //

        $this->sources = array();
        // foreach ($records as $record) {
        //     // $source = source_factory::instance($record->source);
        //     // $source->populate($record);

        //     $this->sources[] = $source;
        // }
    }
}
