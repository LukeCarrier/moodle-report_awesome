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

use stdClass;

defined('MOODLE_INTERNAL') || die;

/**
 * Abstract model.
 *
 * Eases working with the Report: Awesome database tables. Child classes have
 * been created for each of the tables we add to the Moodle database.
 *
 * When extending this class, you need only do the following:
 *
 * - declare protected properties for each field of the table
 * - implement the dml_fields() and dml_table() methods to return the
 *   appropriate data
 * - implement a constructor with parameters for each of your properties
 *
 * All of the other methods are already implemented for convenience.
 */
abstract class abstract_model {
    /**
     * Record ID.
     *
     * The ID field is mapped in this class because it's a requirement of
     * Moodle's DML API. All other fields are mapped in child classes.
     *
     * @var integer
     */
    protected $id;

    /**
     * Assemble a record instance from a raw DML record.
     *
     * @param stdClass $record The raw record from the DML API.
     *
     * @return \report_awesome\report The report object.
     */
    public static function from_dml($record) {
        $instance = new static();
        $instance->populate($record);

        return $instance;
    }

    /**
     * Get an instance of a report by its ID.
     *
     * @param integer $id The ID of the report in the reports table.
     *
     * @return \report_awesome\report The report object.
     */
    public static function instance($id) {
        global $DB;

        $record = $DB->get_record(static::dml_table(), array('id' => $id),
                                  '*', MUST_EXIST);

        return static::from_dml($record);
    }

    /**
     * Property accessor.
     *
     * Allow read-only access to all internal state.
     *
     * @param string $property The property of the report object to access.
     *
     * @return mixed The value of the requested property.
     */
    public function __get($property) {
        return $this->{$property};
    }

    /**
     * Property writer.
     *
     * Allow write access to internal state.
     *
     * @param string $property The property of the report object to set.
     * @param mixed  $value    The value to apply to the property.
     *
     * @return void
     */
    public function __set($property, $value) {
        $this->{$property} = $value;
    }

    /**
     * Commit changes to the report and associated sources.
     *
     * @return void
     */
    public function commit() {
        global $DB;

        $record = $this->to_dml();
        $table  = static::dml_table();

        if ($this->id !== null) {
            $DB->update_record($table, $record);
        } else {
            $this->id = $DB->insert_record($table, $record);
        }
    }

    /**
     * DML fields.
     *
     * @return string[]
     */
    //abstract public static function dml_fields();

    /**
     * DML table.
     *
     * @return string
     */
    //abstract public static function dml_table();

    /**
     * Populate this instance from a DML record.
     *
     * @param stdClass $record The raw record from the DML API.
     *
     * @return void
     */
    public function populate($record) {
        foreach (static::dml_fields() as $field) {
            $this->{$field} = $record->{$field};
        }

        $this->id = $record->id;
    }

    /**
     * Export a DML object representing this object.
     *
     * @return stdClass A DML record object representing the object's fields.
     */
    public function to_dml() {
        $record = new stdClass();
        foreach (static::dml_fields() as $field) {
            $record->{$field} = $this->{$field};
        }

        $record->id = $this->id;

        return $record;
    }
}
