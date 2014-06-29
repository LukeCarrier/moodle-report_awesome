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
 * Report source base class.
 *
 * Report sources form the basis of Awesome reports. They can be connected
 * together and filtered to produce complex reports.
 */
abstract class abstract_source extends abstract_model {
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
     * Is the source the report's primary source?
     *
     * @var boolean
     */
    protected $primary;

    /**
     * Initialiser.
     *
     * @param string $name Report name.
     */
    public function __construct($reportid=null, $primary=null) {
        $this->reportid = $reportid;
        $this->primary  = $primary;

        $this->source = $this->base_name();
    }

    /**
     * @override \report_awesome\abstract_model
     */
    public static function dml_fields() {
        return array('reportid', 'source', 'primary');
    }

    /**
     * @override \report_awesome\abstract_model
     */
    public static function dml_table() {
        return 'awe_sources';
    }

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
     * Return a list of available fields.
     *
     * @return string[]
     */
    abstract public function fields();
}
