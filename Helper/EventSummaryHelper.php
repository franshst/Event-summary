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
use Joomla\Database\DatabaseInterface;

class EventSummaryHelper
{
    public static function isEventsBookingAvailable()
    {
        $db = Factory::getContainer()->get(DatabaseInterface::class);
        return in_array($db->getPrefix() . 'eb_events', $db->getTableList(), true);
    }

    public static function getEventData($filters)
    {
        $db = Factory::getContainer()->get(DatabaseInterface::class);
        $query = $db->getQuery(true);

        $query->select([
            'e.id',
            'e.title',
            'e.event_date',
            'SUM(CASE WHEN r.published = 1 THEN r.number_registrants ELSE 0 END) AS current_registrations',
            'SUM(CASE WHEN r.published = 1 AND r.checked_in > 0 THEN r.number_registrants ELSE 0 END) AS checked_in',
            '(SUM(CASE WHEN r.published = 1 THEN r.number_registrants ELSE 0 END) - SUM(CASE WHEN r.published = 1 AND r.checked_in > 0 THEN r.number_registrants ELSE 0 END)) AS not_checked_in'
        ])
        ->from($db->quoteName('#__eb_events', 'e'))
        ->leftJoin($db->quoteName('#__eb_registrants', 'r') . ' ON ' . $db->quoteName('e.id') . ' = ' . $db->quoteName('r.event_id'))
        ->where($db->quoteName('e.published') . ' = 1')
        ->group($db->quoteName(['e.id', 'e.title', 'e.event_date']))
        ->order($db->quoteName('e.event_date') . ' DESC');

        // Apply filters
        if (!empty($filters['title'])) {
            $query->where($db->quoteName('e.title') . ' LIKE ' . $db->quote('%' . $db->escape($filters['title'], true) . '%', false));
        }
        if (!empty($filters['location_id'])) {
            $query->where($db->quoteName('e.location_id') . ' = ' . (int)$filters['location_id']);
        }
        if (!empty($filters['category_id'])) {
            $query->innerJoin($db->quoteName('#__eb_event_categories', 'ec') . ' ON ' . $db->quoteName('e.id') . ' = ' . $db->quoteName('ec.event_id'));
            $query->where($db->quoteName('ec.category_id') . ' = ' . (int)$filters['category_id']);
        }
        if (!empty($filters['year'])) {
            $query->where('YEAR(' . $db->quoteName('e.event_date') . ') = ' . (int)$filters['year']);
        }
        if (empty($filters['show_future'])) {
            $query->where('CAST(' . $db->quoteName('e.event_date') . ' AS DATE) <= CURDATE()');
        }

        $db->setQuery($query);
        return $db->loadObjectList();
    }

    public static function getLocations()
    {
        $db = Factory::getContainer()->get(DatabaseInterface::class);
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
        $db = Factory::getContainer()->get(DatabaseInterface::class);
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
        $db = Factory::getContainer()->get(DatabaseInterface::class);
        $query = $db->getQuery(true)
            ->select('DISTINCT YEAR(event_date) AS year')
            ->from($db->quoteName('#__eb_events'))
            ->where($db->quoteName('published') . ' = 1')
            ->order('year DESC');
        $db->setQuery($query);
        return $db->loadColumn();
    }
}
