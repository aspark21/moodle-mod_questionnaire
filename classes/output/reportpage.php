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
 * Contains class mod_questionnaire\output\viewpage
 *
 * @package    mod_questionnaire
 * @copyright  2016 Mike Churchward (mike.churchward@poetgroup.org)
 * @author     Mike Churchward
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_questionnaire\output;

defined('MOODLE_INTERNAL') || die();

class reportpage implements \renderable, \templatable {

    /**
     * The questionnaire object
     *
     * @var object
     */
    protected $questionnaire;

    /**
     * The data to be exported.
     * @var array
     */
    protected $data;

    /**
     * Construct the renderable.
     * @param array $content The array of rows.
     */
    public function __construct($questionnaire) {
        $this->questionnaire = $questionnaire;
        $this->data = new \stdClass();
    }

    /**
     * Add data for export.
     * @param string The index for the data.
     * @param string The content for the index.
     */
    public function add_to_page($element, $content) {
        if ($element === 'responses') {
            $this->data->{$element}[] = ['response' => $content];
        } else if ($element === 'myheaders') {
            $this->data->{$element}['myheader'] =
                empty($this->data->{$element}['myheader']) ? $content : ($this->data->{$element}['myheader'] . $content);
        } else if ($element === 'feedbacknotes') {
            $this->data->{$element}['feedbacknote'] =
                empty($this->data->{$element}['feedbacknote']) ? $content : ($this->data->{$element}['feedbacknote'] . $content);
        } else if ($element === 'feedbackmessages') {
            $this->data->{$element}['feedbackmessage'] =
                empty($this->data->{$element}['feedbackmessage']) ? $content : ($this->data->{$element}['feedbackmessage'] .
                    $content);
        } else {
            $this->data->{$element} = empty($this->data->{$element}) ? $content : ($this->data->{$element} . $content);
        }
    }

    /**
     * Export the data for template.
     * @param \renderer_base $output
     */
    public function export_for_template(\renderer_base $output) {
        return $this->data;
    }

}