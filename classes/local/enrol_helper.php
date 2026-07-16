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

namespace enrol_coursecompleted\local;

use core\context;
use core\output\pix_icon;
use moodle_url;
use stdClass;

/**
 * GCHLOL Enrolment Helper.
 *
 * @package    enrol_coursecompleted
 * @copyright  2026 Gold Coast Health
 * @author     Nicholas Lambell
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_helper {

    /**
     * Get action icon for enrol existing users.
     *
     * @param int $enrolid Enrolment instance ID.
     * @return string Action icon HTML.
     */
    public static function get_action_icon(int $enrolid): string {
        global $OUTPUT;

        $managelink = new moodle_url(
            '/enrol/coursecompleted/manage.php',
            [
                'enrolid' => $enrolid,
                'existing' => true,
            ]
        );
        $icon = new pix_icon(
            't/addcontact',
            get_string('enrolusersall', 'enrol_coursecompleted'),
            'core',
            [ 'class' => 'iconsmall' ]
        );

        return $OUTPUT->action_icon($managelink, $icon);
    }

    /**
     * Get enrolled users in a given context with optional enrolment instance filter.
     *
     * @param context $context Enrolment context.
     * @param int $enrolid Optional specific enrolment instance ID to get enrolments for. Defaults to all instances.
     * @return array<int, stdClass> List of user objects indexed by ID. Note, object only contains `id`.
     */
    public static function get_enrolled_users(context $context, int $enrolid = 0): array {
        global $DB;

        [ $sql, $params ] = get_enrolled_sql(
            context: $context,
            onlyactive: true,
            enrolid: $enrolid
        );

        return $DB->get_records_sql($sql, $params);
    }
}
