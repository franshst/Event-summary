<?php
/**
 * @package    Event Summary
 *
 * @author     Frans Stuurman
 * @copyright  Frans Stuurman
 * @license    MIT see LICENSE
 *
 */

namespace EventSummaryNamespace\Module\EventSummary\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

class EventSummaryHelper
{
    public static function getEventData()
    {
        $db = Factory::getContainer()->get('DatabaseDriver');
        $query = "
            SELECT
                e.id,
                e.title,
                e.event_date,
                SUM(CASE WHEN r.published = 1 THEN r.number_registrants ELSE 0 END) AS current_registrations,
                SUM(CASE WHEN r.published = 1 AND r.checked_in > 0 THEN r.number_registrants ELSE 0 END) AS checked_in,
                (
                    SUM(CASE WHEN r.published = 1 THEN r.number_registrants ELSE 0 END) -
                    SUM(CASE WHEN r.published = 1 AND r.checked_in > 0 THEN r.number_registrants ELSE 0 END)
                ) AS not_checked_in
            FROM
                `#__eb_events` AS e
            LEFT JOIN
                `#__eb_registrants` AS r ON e.id = r.event_id
            WHERE
                e.published = 1
            GROUP BY
                e.id, e.title, e.event_date
            HAVING
                current_registrations > 0
            ORDER BY
                e.event_date DESC;
        ";

        $db->setQuery($query);
        return $db->loadObjectList();
    }

    public static function getLocations()
    {
        $db = Factory::getContainer()->get('DatabaseDriver');
        $query = $db->getQuery(true)
            ->select($db->quoteName(['id', 'name']))
            ->from($db->quoteName('#__eb_locations'))
            ->where($db->quoteName('published') . ' = 1')
            ->order($db->quoteName('name'));
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    public static function getCategories()
    {
        $db = Factory::getContainer()->get('DatabaseDriver');
        $query = $db->getQuery(true)
            ->select($db->quoteName(['id', 'name']))
            ->from($db->quoteName('#__eb_categories'))
            ->where($db->quoteName('published') . ' = 1')
            ->order($db->quoteName('name'));
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    public static function getYears()
    {
        $db = Factory::getContainer()->get('DatabaseDriver');
        $query = $db->getQuery(true)
            ->select('DISTINCT YEAR(event_date) AS year')
            ->from($db->quoteName('#__eb_events'))
            ->where($db->quoteName('published') . ' = 1')
            ->order('year DESC');
        $db->setQuery($query);
        return $db->loadColumn();
    }
}
