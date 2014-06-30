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

defined('MOODLE_INTERNAL') || die;

/**
 * Source factory.
 *
 * The source factory creates instances of sources for use in reports.
 */
class source_factory {
    /**
     * Map of report names to source classes.
     *
     * @var string[]
     */
    protected static $classmap = array(
        'user' => '\report_awesome\sources\user_source',
    );

    /**
     * Get source objects for a report.
     *
     * @param integer $reportid The ID of the report for which to retrieve
     *                          sources.
     *
     * @return \report_awesome\abstract_source[] An array of report source
     *                                           objects.
     */
    public static function existing_instances($reportid) {
        global $DB;

        $records = $DB->get_records('awe_sources', array('reportid' => $reportid));
        $sources = array();

        foreach ($records as $record) {
            $sources[$record->source] = static::instance_from_dml($record);
        }

        return $sources;
    }

    /**
     * Return an index of all known source names.
     *
     * @return string[] An index of all known source names.
     */
    public static function index() {
        return array_keys(static::$classmap);
    }

    /**
     * Assemble a record instance from a raw DML record.
     *
     * @param stdClass $record The raw record from the DML API.
     *
     * @return \report_awesome\abstract_source The source object.
     */
    protected static function instance_from_dml($record) {
        $classname = static::resolve($record->source);

        return $classname::from_dml($record);
    }

    /**
     * Return an instance of the named source.
     *
     * @paramn string $sourcename The name of the source.
     *
     * @return \report_awesome\abstract_source An instance of the source.
     */
    public static function new_instance($sourcename) {
        $classname = static::resolve($sourcename);

        return new $classname();
    }

    /**
     * Resolve a class name from a source name.
     *
     * @param string $sourcename The name of the source.
     *
     * @return string The source's class name.
     */
    protected static function resolve($sourcename) {
        if (!array_key_exists($sourcename, static::$classmap)) {
            return false;
        }

        return static::$classmap[$sourcename];
    }
}
