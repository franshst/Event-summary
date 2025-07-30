<?php
/**
 * Main driver of Event Summary module
 *
 * @package    Event Summary
 *
 * @author     Frans Stuurman
 * @copyright  Frans Stuurman
 * @license    MIT see LICENSE
 *
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use EventSummaryNamespace\Module\EventSummary\Site\Helper\EventSummaryHelper;
use Joomla\CMS\Factory;

JFactory::getLanguage()->load('mod_eventsummary', JPATH_SITE);
$eventData = EventSummaryHelper::getEventData();
$locations = EventSummaryHelper::getLocations();
$categories = EventSummaryHelper::getCategories();
$years = EventSummaryHelper::getYears();
$session = Factory::getSession();
$filters = [
    'title' => $session->get('eventsummary.filter_title', ''),
    'location_id' => $session->get('eventsummary.filter_location_id', 0),
    'category_id' => $session->get('eventsummary.filter_category_id', 0),
    'year' => $session->get('eventsummary.filter_year', 0),
    'show_empty' => $session->get('eventsummary.filter_show_empty', 0),
];

require ModuleHelper::getLayoutPath('mod_eventsummary', $params->get('layout', 'default'));
