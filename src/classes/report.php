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

        $this->sources = array();
    }

    /**
     * @override \report_awesome\abstract_model
     */
    public function commit() {
        parent::commit();

        foreach ($this->sources as $source) {
            $source->reportid = $this->id;
            $source->commit();
        }
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
     * Get or add a source to the report.
     *
     * @param string $sourcename The name of the source to retrieve or add.
     *
     * @return \report_awesome\abstract_source The source object.
     */
    public function get_source($sourcename) {
        $this->maybe_reload_sources();

        if (!array_key_exists($sourcename, $this->sources)) {
            $this->sources[$sourcename] = source_factory::new_instance($sourcename);
        }

        return $this->sources[$sourcename];
    }

    /**
     * Get an array of all sources associated with the report.
     *
     * @return \report_awesome\abstract_source[] An array of associated source
     *                                           objects.
     */
    public function get_sources() {
        $this->maybe_reload_sources();

        return $this->sources;
    }

    /**
     * Reload sources if empty.
     *
     * @return void
     */
    public function maybe_reload_sources() {
        if (count($this->sources) === 0) {
            $this->reload_sources();
        }
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
        $this->sources = source_factory::existing_instances($this->id);
    }
}
