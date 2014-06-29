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
 * Report source interface.
 *
 * Report sources form the basis of Awesome reports. They can be connected
 * together and filtered to produce complex reports.
 */
interface source {
    /**
     * Return source's base alias.
     *
     * The base alias refers to the shortened name of the source's table.
     *
     * @return string
     */
    public function base_alias();

    /**
     * Return source's name
     *
     * The source's name should match its class name. This method exists to
     * avoid use of slow reflection.
     *
     * @return string
     */
    public function base_name();

    /**
     * Return a list of available fields.
     *
     * @return string[]
     */
    public function fields();
}
