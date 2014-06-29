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

use moodle_url;

defined('MOODLE_INTERNAL') || die;

/**
 * Report form factory.
 *
 * Allows for accessing forms by prettier, shorter names, and keeps a little
 * complexity out of index.php.
 */
class report_form_factory {
    /**
     * Map of form names names to classes.
     *
     * @var string[]
     */
    protected static $classmap = array(
        'details' => '\report_awesome\forms\report_details_form',
        'sources' => '\report_awesome\forms\report_sources_form',
    );

    /**
     * Return an array of known form names.
     *
     * @return string[] An array of known form names.
     */
    public static function index() {
        return array_keys(static::$classmap);
    }

    /**
     * Get an instance.
     *
     * @param string  $name       The name of the class to retrieve.
     * @param mixed[] $customdata The data to be retained in the form's
     *                            custom data attribute.
     *
     * @return \moodleform The form.
     */
    public static function instance($name, $customdata) {
        if (!array_key_exists($name, static::$classmap)) {
            return false;
        }

        $action = $name === 'details' ? null
                : new moodle_url('/report/awesome/edit.php', array('edit' => $name));
        $classname = static::$classmap[$name];

        return new $classname($action, $customdata);
    }
}
