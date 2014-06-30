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

defined('MOODLE_INTERNAL') || die;

// Module metadata
$string['pluginname'] = 'Awesome';

// Capabilities
$string['awesome:manage'] = 'Manage awesome reports';
$string['awesome:view']   = 'View awesome reports';

// Report administration and details tab
$string['confirmdelete'] = 'Are you sure you wish to delete the "{$a->name}" report?';
$string['createreport']  = 'Create an awesome report';
$string['deletereport']  = 'Delete "{$a->name}" report';
$string['details']       = 'Details';
$string['editreport']    = 'Edit "{$a->name}" report';
$string['sources']       = 'Sources';
$string['managereports'] = 'Manage awesome reports';

// Report sources tab
$string['display']          = 'Fields to display';
$string['error:oneprimary'] = 'There must be exactly <strong><em>1</em></strong> primary source, but <strong><em>{$a}</em></strong> were selected';
$string['isprimary']        = 'Primary?';

// Report model
$string['reportname'] = 'Name';

// Sources
$string['source:user']          = 'User';
$string['source:user:id']       = 'ID';
$string['source:user:username'] = 'Username';

// Exceptions
$string['invalideditparam'] = 'Invalid edit parameter';
