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

JFactory::getLanguage()->load('mod_eventsummary', JPATH_SITE);
$eventData = EventSummaryHelper::getEventData();
// $locationData = EventSummaryHelper::getLocationData();
// $categoryData = EventSummaryHelper::getCategoryData();

require ModuleHelper::getLayoutPath('mod_eventsummary', $params->get('layout', 'default'));
