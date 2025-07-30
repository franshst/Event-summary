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

$app = Factory::getApplication();
$input = $app->input;
$session = Factory::getSession();

// Check if the filter form was submitted by checking for the submit button's name
if ($input->get('eventsummary_submit'))
{
	// If submitted, get all filter values from the request.
	// For the checkbox, getInt will correctly return 0 if it's not present (unchecked).
	$filters = [
		'title'       => $input->getString('filter_title', ''),
		'location_id' => $input->getInt('filter_location_id', 0),
		'category_id' => $input->getInt('filter_category_id', 0),
		'year'        => $input->getInt('filter_year', 0),
		'show_empty'  => $input->getInt('filter_show_empty', 0),
	];
	// Save the complete, fresh set of filters to the session.
	$session->set('eventsummary.filters', $filters);
}
else
{
	// If the form was not submitted, get the filters from the session.
	// If the session is empty, provide a default set of filters.
	$filters = $session->get('eventsummary.filters', [
		'title'       => '',
		'location_id' => 0,
		'category_id' => 0,
		'year'        => 0,
		'show_empty'  => 0,
	]);
}

// Fetch the main event data using the final, correct filters.
$eventData = EventSummaryHelper::getEventData($filters);

// Fetch data needed to display the filter dropdowns.
$locations  = EventSummaryHelper::getLocations();
$categories = EventSummaryHelper::getCategories();
$years      = EventSummaryHelper::getYears();

require ModuleHelper::getLayoutPath('mod_eventsummary', $params->get('layout', 'default'));
