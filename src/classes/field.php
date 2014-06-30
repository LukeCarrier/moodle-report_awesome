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
 * Report source field.
 *
 * Fields contain individual pieces of data found in reports.
 */
class field extends abstract_model {
    /**
     * Field source ID.
     *
     * @var integer
     */
    protected $sourceid;

    /**
     * Field name, as per abstract_source::get_available_fields().
     *
     * @var string
     */
    protected $field;

    /**
     * Should the field be displayed in the report?
     *
     * @var boolean
     */
    protected $display;

    /**
     * Initialiser.
     *
     * @param integer $sourceid Field source ID.
     * @param string  $field    Field name, as per
     *                          abstract_source::get_available_fields().
     * @param boolean $display  Should the field be displayed in the report?
     */
    public function __construct($sourceid=null, $field=null, $display=null) {
        $this->sourceid = $sourceid;
        $this->field    = $field;
        $this->display  = $display;
    }

    /**
     * @override \report_awesome\abstract_model
     */
    public static function dml_fields() {
        return array('display', 'field', 'sourceid');
    }

    /**
     * @override \report_awesome\abstract_model
     */
    public static function dml_table() {
        return 'awe_fields';
    }

    /**
     * Get field objects for a source.
     *
     * @param integer $sourceid The ID of the source for which to retrieve
     *                          fields.
     *
     * @return \report_awesome\field[] An array of report field objects.
     */
    public static function existing_instances($sourceid) {
        global $DB;

        $records = $DB->get_records(static::dml_table(), array('sourceid' => $sourceid));
        $fields  = array();

        foreach ($records as $record) {
            $fields[$record->field] = static::from_dml($record);
        }

        return $fields;
    }
}
