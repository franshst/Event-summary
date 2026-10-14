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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

?>

<?php if (!empty($ebMissing)) : ?>
    <div class="alert alert-warning" role="alert"><?php echo Text::_('MOD_EVENTSUMMARY_EB_MISSING'); ?></div>
    <?php return; ?>
<?php endif; ?>

<form action="" method="post" name="eventsummary-filters-form" class="mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md">
            <label for="filter_title" class="form-label"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_TITLE'); ?></label>
            <input type="text" name="filter_title" id="filter_title" class="form-control" value="<?php echo htmlspecialchars($filters['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="col-md">
            <label for="filter_location_id" class="form-label"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_LOCATION'); ?></label>
            <select name="filter_location_id" id="filter_location_id" class="form-select">
                <option value="0"><?php echo Text::_('MOD_EVENTSUMMARY_ALL'); ?></option>
                <?php foreach ($locations as $location) : ?>
                    <option value="<?php echo (int)$location->id; ?>" <?php if ($filters['location_id'] == $location->id) echo 'selected'; ?>><?php echo htmlspecialchars($location->name, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md">
            <label for="filter_category_id" class="form-label"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_CATEGORY'); ?></label>
            <select name="filter_category_id" id="filter_category_id" class="form-select">
                <option value="0"><?php echo Text::_('MOD_EVENTSUMMARY_ALL'); ?></option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo (int)$category->id; ?>" <?php if ($filters['category_id'] == $category->id) echo 'selected'; ?>><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md">
            <label for="filter_year" class="form-label"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_YEAR'); ?></label>
            <select name="filter_year" id="filter_year" class="form-select">
                <option value="0"><?php echo Text::_('MOD_EVENTSUMMARY_ALL'); ?></option>
                <?php foreach ($years as $year) : ?>
                    <option value="<?php echo (int)$year; ?>" <?php if ($filters['year'] == $year) echo 'selected'; ?>><?php echo (int)$year; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto d-flex align-items-end">
            <div class="form-check">
                <input type="checkbox" name="filter_show_future" id="filter_show_future" class="form-check-input" value="1" <?php if (!empty($filters['show_future'])) echo 'checked'; ?>>
                <label for="filter_show_future" class="form-check-label"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_SHOW_FUTURE'); ?></label>
            </div>
        </div>
        <div class="col-auto d-flex align-items-end">
            <button type="submit" name="eventsummary_submit" class="btn btn-primary"><?php echo Text::_('MOD_EVENTSUMMARY_FILTER_BUTTON'); ?></button>
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-light">
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
                        <td data-label="<?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_EVENT'); ?>"><?php echo htmlspecialchars($event->title, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td data-label="<?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_DATE'); ?>"><?php echo HTMLHelper::_('date', $event->event_date, 'd-m-Y'); ?></td>
                        <td data-label="<?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_REGISTRATIONS'); ?>"><?php echo (int)$event->current_registrations; ?></td>
                        <td data-label="<?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_CHECKED_IN'); ?>"><?php echo (int)$event->checked_in; ?></td>
                        <td data-label="<?php echo Text::_('MOD_EVENTSUMMARY_TABLE_HEADER_NOT_CHECKED_IN'); ?>"><?php echo (int)$event->not_checked_in; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center"><?php echo Text::_('MOD_EVENTSUMMARY_NO_EVENTS_FOUND'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
