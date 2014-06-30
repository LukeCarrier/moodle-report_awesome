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

namespace report_awesome\exceptions;

use moodle_exception;

defined('MOODLE_INTERNAL') || die;

/**
 * Invalid field exception.
 *
 * Thrown when attempting to get an instance of a field which does not exist
 * within the relevant source.
 */
class invalid_field_exception extends moodle_exception {
    /**
     * @override \moodle_exception
     */
    public function __construct() {
        parent::__construct('invalidfield', 'report_awesome');
    }
}
