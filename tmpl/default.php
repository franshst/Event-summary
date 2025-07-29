<?php
/**
 * Displays a responsive table of event registration summaries.
 *
 * @package    Event Summary
 * @author     Frans Stuurman
 * @copyright  Frans Stuurman
 * @license    MIT see LICENSE
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use EventSummaryNamespace\Module\EventSummary\Site\Helper\EventSummaryHelper;

// Fetch data for filters
$locations = EventSummaryHelper::getLocations();
$categories = EventSummaryHelper::getCategories();
$years = EventSummaryHelper::getYears();

?>
<style>
    .eventsummary-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 15px;
    }
    .eventsummary-filters .filter-item {
        display: flex;
        flex-direction: column;
    }
    .eventsummary-table-wrapper {
        overflow-x: auto;
    }
    .eventsummary-table {
        width: 100%;
        border-collapse: collapse;
    }
    .eventsummary-table th,
    .eventsummary-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .eventsummary-table th {
        background-color: #f2f2f2;
    }
</style>

<form action="" method="post" name="eventsummary-filters-form">
    <div class="eventsummary-filters">
        <div class="filter-item">
            <label for="filter_title"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_TITLE'); ?></label>
            <input type="text" name="filter_title" id="filter_title" value="">
        </div>
        <div class="filter-item">
            <label for="filter_location_id"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_LOCATION'); ?></label>
            <select name="filter_location_id" id="filter_location_id">
                <option value="0"><?php echo Text::_('MOD_EVENTSUMMARY_ALL'); ?></option>
                <?php foreach ($locations as $location) : ?>
                    <option value="<?php echo (int)$location->id; ?>"><?php echo htmlspecialchars($location->name, ENT_COMPAT, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-item">
            <label for="filter_category_id"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_CATEGORY'); ?></label>
            <select name="filter_category_id" id="filter_category_id">
                <option value="0"><?php echo Text::_('MOD_EVENTSUMMARY_ALL'); ?></option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo (int)$category->id; ?>"><?php echo htmlspecialchars($category->name, ENT_COMPAT, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-item">
            <label for="filter_year"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_YEAR'); ?></label>
            <select name="filter_year" id="filter_year">
                <option value="0"><?php echo Text::_('MOD_EVENTSUMMARY_ALL'); ?></option>
                <?php foreach ($years as $year) : ?>
                    <option value="<?php echo (int)$year; ?>"><?php echo (int)$year; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-item">
            <label for="filter_show_empty"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_SHOW_EMPTY'); ?></label>
            <input type="checkbox" name="filter_show_empty" id="filter_show_empty" value="1">
        </div>
        <div class="filter-item">
            <button type="submit"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_BUTTON'); ?></button>
        </div>
    </div>
</form>

<div class="eventsummary-table-wrapper">
    <table class="eventsummary-table">
        <thead>
            <tr>
                <th><?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_EVENT'); ?></th>
                <th><?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_DATE'); ?></th>
                <th><?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_REGISTRATIONS'); ?></th>
                <th><?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_CHECKED_IN'); ?></th>
                <th><?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_NOT_CHECKED_IN'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($eventData)) : ?>
                <?php foreach ($eventData as $event) : ?>
                    <tr>
                        <td data-label="<?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_EVENT'); ?>"><?php echo htmlspecialchars($event->title, ENT_COMPAT, 'UTF-8'); ?></td>
                        <td data-label="<?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_DATE'); ?>"><?php echo JHtml::_('date', $event->event_date, 'd-m-Y'); ?></td>
                        <td data-label="<?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_REGISTRATIONS'); ?>"><?php echo (int)$event->current_registrations; ?></td>
                        <td data-label="<?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_CHECKED_IN'); ?>"><?php echo (int)$event->checked_in; ?></td>
                        <td data-label="<?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_NOT_CHECKED_IN'); ?>"><?php echo (int)$event->not_checked_in; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5"><?php echo Text::_('MOD_EVENTSUMMARY_NO_EVENTS_FOUND'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>