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
 *
 * Eases working with the Report: Awesome database tables.
 */
class report {
    /**
     * Field database table.
     *
     * @var string
     */
    const TABLE_FIELDS = 'awe_fields';

    /**
     * Report database table.
     *
     * @var string
     */
    const TABLE_REPORTS = 'awe_reports';

    /**
     * Source database table.
     *
     * @var string
     */
    const TABLE_SOURCES = 'awe_sources';

    /**
     * Report ID.
     *
     * @var integer
     */
    protected $id;

    /**
     * Report name.
     *
     * @var string
     */
    protected $name;

    /**
     * Report sources.
     *
     * @var \report_awesome\source[]
     */
    protected $sources;

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

        $record = $DB->get_record(static::TABLE_REPORTS, array('id' => $id),
                                  '*', MUST_EXIST);

        return static::from_dml($record);
    }

    /**
     * Initialiser.
     *
     * @param string                   $name    Report name.
     * @param \report_awesome\source[] $sources Report sources.
     */
    public function __construct($name=null, $sources=null) {
        $this->name = $name;
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
     * Add a source to the report.
     */
    public function add_source(source $source) {
    }

    /**
     * Commit changes to the report and associated sources.
     */
    public function commit() {
    }

    /**
     * Populate this instance from a DML record.
     *
     * @param stdClass $record The raw record from the DML API.
     *
     * @return void
     */
    public function populate($record) {
        $this->id   = $record->id;
        $this->name = $record->name;

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

        $records = $DB->get_records(static::TABLE_SOURCES,
                                    array('reportid' => $this->id));

        $this->sources = array();
        foreach ($records as $record) {
            $source = source_factory::instance($record->source);
            $source->populate($record);

            $this->sources[] = $source;
        }
    }

    public function to_dml() {
        return (object) array(
            'id'   => $this->id,
            'name' => $this->name,
        );
    }
}
