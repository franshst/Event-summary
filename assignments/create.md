# assignment
- create a joomla module called mod_eventsummary
- the purpose is to show a table of events with date of event, the number of current registrations, the current checked-ins, and the number of not yet checked in participants.
# format
- a table, flexible so that it adjusts to screen width and is readeable on small screens like smartphones
# filtering
- filters on event name, location, category, year
- filter on events without any participants or check-ins
- filters should persist for the user when renewing the page
# defaults
- fixed default: only show events with participants 
# source sql
- table: jml_eb_events will contain most information
- please ask user to execute sql select statements that will give you information about the fields.
- store database information in a file for later reference
# translation
- create a translation for dutch
# setup 
- project Event-chart contains a similar joomla module. copy the files to Event-reg-summary and remove unneeded logic
# work method
- work step by step.
- First create the skeleton of the module
- Design sql, have the user execute the sql and confirm the result is what is needed
- Test by simply have the module php echo the list from sql
- run release.py to get a zip file with the module
- when confirmed by user to be working, create javascript to display the table
- again, have user test

