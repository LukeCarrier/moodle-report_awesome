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

namespace report_awesome\sources;

use report_awesome\source;

defined('MOODLE_INTERNAL') || die;

/**
 * User source.
 */
class user_source extends abstract_database_source implements source {
    const TABLE_USER = 'user';

    public function base_alias() {
        return 'u';
    }

    public function base_name() {
        return 'user';
    }

    public function fields() {
        return array(
            'id',
            'username',
        );
    }
}
