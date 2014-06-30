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

namespace report_awesome;

use report_awesome\exceptions\invalid_field_exception;

defined('MOODLE_INTERNAL') || die;

/**
 * Report source base class.
 *
 * Report sources form the basis of Awesome reports. They can be connected
 * together and filtered to produce complex reports.
 */
abstract class abstract_source extends abstract_model {
    /**
     * Associated fields.
     *
     * @var \report_awesome\field[]
     */
    protected $fields;

    /**
     * Is the source the report's primary source?
     *
     * @var boolean
     */
    protected $isprimary;

    /**
     * Report ID.
     *
     * @var integer
     */
    protected $reportid;

    /**
     * Source name.
     *
     * @var string
     */
    protected $source;

    /**
     * Initialiser.
     *
     * @param string  $reportid  Report ID.
     * @param boolean $isprimary Whether or not the source is the primary
     *                           source in the report.
     */
    public function __construct($reportid=null, $isprimary=null) {
        $this->reportid  = $reportid;
        $this->isprimary = $isprimary;

        $this->source = $this->base_name();
        $this->fields = array();
    }

    /**
     * Return a list of available fields.
     *
     * @return string[]
     */
    abstract public function available_fields();

    /**
     * Return source's base alias.
     *
     * The base alias refers to the shortened name of the source's table.
     *
     * @return string
     */
    abstract public function base_alias();

    /**
     * Return source's name
     *
     * The source's name should match its class name. This method exists to
     * avoid use of slow reflection.
     *
     * @return string
     */
    abstract public function base_name();

    /**
     * @override \report_awesome\abstract_model
     */
    public function commit() {
        parent::commit();

        foreach ($this->get_fields() as $field) {
            $field->sourceid = $this->id;
            $field->commit();
        }
    }

    /**
     * @override \report_awesome\abstract_model
     */
    public static function dml_fields() {
        return array('isprimary', 'reportid', 'source');
    }

    /**
     * @override \report_awesome\abstract_model
     */
    public static function dml_table() {
        return 'awe_sources';
    }

    /**
     * Get fields selected for display.
     *
     * @return \report_awesome\field[] An array of field objects.
     */
    public function get_display_fields() {
        $this->maybe_reload_fields();

        $displayfields = array();

        foreach ($this->fields as $fieldname => $field) {
            if ($field->display) {
                $displayfields[$fieldname] = $field;
            }
        }

        return $displayfields;
    }

    /**
     * Get or add a field to the source.
     *
     * @param string $fieldname The name of the field to retrieve or add.
     *
     * @return \report_awesome\field The field object.
     */
    public function get_field($fieldname) {
        $this->maybe_reload_fields();

        if (!in_array($fieldname, $this->available_fields())) {
            throw new invalid_field_exception();
        }

        if (!array_key_exists($fieldname, $this->fields)) {
            $this->fields[$fieldname] = new field($this->id, $fieldname);
        }

        return $this->fields[$fieldname];
    }

    /**
     * Get an array of all fields associated with the source.
     *
     * @return \report_awesome\field[] An array of associated field objects.
     */
    public function get_fields() {
        $this->maybe_reload_fields();

        return $this->fields;
    }

    /**
     * Reload fields if empty.
     *
     * @return void
     */
    protected function maybe_reload_fields() {
        if (count($this->fields) === 0) {
            $this->reload_fields();
        }
    }

    /**
     * Reload the source's fields from the database.
     *
     * After making modifications to the record's field associations, you'll
     * want to call this method in order to ensure the two don't fall out of
     * sync.
     *
     * @return void
     */
    public function reload_fields() {
        $this->fields = field::existing_instances($this->id);
    }

    /**
     * Set the fields to be displayed.
     *
     * @param string[] $fieldnames The names of the fields to be displayed.
     *
     * @return void
     */
    public function set_display_fields($fieldnames) {
        foreach ($this->available_fields() as $fieldname) {
            $field = $this->get_field($fieldname);
            $field->display = in_array($fieldname, $fieldnames);
        }
    }
}
