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
 * @package   report_tdmmodaccess
 * @author    Luke Carrier <luke@tdm.co>
 * @copyright (c) 2014 The Development Manager Ltd
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_awesome\traits;

use lang_string;

/**
 * Language string trait.
 *
 * Provides shorthand methods for obtaining language strings.
 */
trait lang {
    /**
     * The name of the module to load strings for.
     *
     * @var string
     */
    static $LANG_MODULE = 'report_awesome';

    /**
     * Shorthand method for obtaining lazy-loadable language strings.
     *
     * @param string $string The name of the language string to obtain.
     * @param mixed  $a      Substitions in some form; can vary from string
     *                       to string.
     *
     * @return \lang_string The Moodle language string object.
     */
    protected static function lang_string($string, $a=null) {
        return new lang_string($string, static::$LANG_MODULE, $a);
    }

    /**
     * Shorthand method for obtaining language strings immediately.
     *
     * Use this method only for bits of Moodle that require it.
     *
     * @param string $string The name of the language string to obtain.
     * @param mixed  $a      Substitions in some form; can vary from string
     *                       to string.
     *
     * @return string The language string.
     */
    protected static function lang_string_now($string, $a=null) {
        return get_string($string, static::$LANG_MODULE, $a);
    }
}
