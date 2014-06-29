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
use moodle_url;

defined('MOODLE_INTERNAL') || die;

/**
 * Invalid edit parameter.
 *
 * Raised when attempting to edit properties of a report for which no form
 * exists.
 */
class invalid_edit_param_exception extends moodle_exception {
    /**
     * @override \moodle_exception
     */
    public function __construct() {
        parent::__construct('invalideditparam', 'report_awesome',
                            new moodle_url('/report/awesome/index.php'));
    }
}
