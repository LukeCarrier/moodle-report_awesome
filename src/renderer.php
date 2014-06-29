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

use report_awesome\report_form_factory;
use report_awesome\traits\lang;

defined('MOODLE_INTERNAL') || die;

/**
 * Renderer.
 *
 * Generates HTML strings for output.
 */
class report_awesome_renderer extends plugin_renderer_base {
    use lang;

    /**
     * Delete base URL.
     *
     * @var \moodle_url
     */
    protected $deleteurl;

    /**
     * Edit base URL.
     *
     * @var \moodle_url
     */
    protected $editurl;

    /**
     * Delete icon.
     *
     * @var \pix_icon
     */
    protected $deleteicon;

    /**
     * Edit icon.
     *
     * @var \pix_icon
     */
    protected $editicon;

    /**
     * Editing tabs.
     *
     * @var \tabobject[]
     */
    protected $tabs;

    /**
     * @override \plugin_renderer_base
     */
    public function __construct(moodle_page $page, $target) {
        parent::__construct($page, $target);

        $this->deleteurl = new moodle_url('/report/awesome/delete.php');
        $this->editurl   = new moodle_url('/report/awesome/edit.php');

        $this->deleteicon = new pix_icon('t/delete', new lang_string('delete'));
        $this->editicon   = new pix_icon('t/edit',   new lang_string('edit'));

        $this->tabs = array();
        foreach (report_form_factory::index() as $formname) {
            $urlparams = $formname === 'details' ? null : array('edit' => $formname);
            $this->tabs[] = new tabobject($formname,
                                          new moodle_url('/report/awesome/edit.php', $urlparams),
                                          static::lang_string($formname));
        }
    }

    /**
     * Render report action buttons for use in a table.
     *
     * @param stdClass $report The report to render the action buttons for.
     *
     * @return string Rendered HTML.
     */
    public function report_action_buttons($report) {
        $delete = $this->action_icon($this->deleteurl->out(false, array('id' => $report->id)),
                                     $this->deleteicon);
        $edit   = $this->action_icon($this->editurl->out(false, array('id' => $report->id)),
                                     $this->editicon);

        return $edit . $delete;
    }

    /**
     * Render report add button.
     *
     * @param string $url The base URL of the page.
     *
     * @return string Rendered HTML.
     */
    public function report_add_button() {
        return $this->single_button($this->editurl->out(false, array('id' => 0)),
                                    static::lang_string('createreport'),
                                    'get');
    }

    /**
     * Render report editing tabs.
     *
     * @param stdClass $report   The report to render the tabs for.
     * @param string   $selected The tab to mark as currently selected.
     *
     * @return string Rendered HTML.
     */
    public function report_tabs($report, $selected='details') {
        foreach ($this->tabs as $tab) {
            $tab->link->param('id', $report->id);
        }

        return $this->tabtree($this->tabs, $selected);
    }

    /**
     * Render a table of report records.
     *
     * @param stdClass[] $reports An array of stdClass objects representing
     *                            reports. Only the id and name fields are
     *                            required.
     *
     * @return string Rendered HTML.
     */
    public function report_list_table($reports) {
        $table = new html_table();
        $table->head = array(
            new lang_string('name'),
            new lang_string('actions'),
        );

        foreach ($reports as $report) {
            $table->data[] = array(
                $report->name,
                $this->report_action_buttons($report),
            );
        }

        return html_writer::table($table);
    }
}
