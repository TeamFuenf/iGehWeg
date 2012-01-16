<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// Fehlerseiten
$route['404_override'] = '';

// Hauptseiten
$route["default_controller"] = "base/login_control";
$route["friends"] = "friends/friends_control";

// Map
$route["map"] = "map/map";
$route["map/snippet/(:any)"] = "map/map/snippet";

// Events & Timeline
$route["timeline"] = "timeline/timeline";
$route["event"] = "timeline/timeline/event";
$route["event/new"] = "event/event/newevent";
$route["event/new/(:any)"] = "event/event/newevent";
$route["event/update/basedata"] = "event/event/updateBasedata";
$route["event/update/location"] = "event/event/updateLocation";
$route["event/update/member"] = "event/event/updateMember";
$route["event/update/status/(:any)"] = "event/event/updateStatus";
$route["event/update/comment"] = "event/event/insertComment";
$route["event/edit/(:any)"] = "event/event/editevent";
$route["event/delete/(:any)"] = "event/event/deleteevent";
$route["event/ical/(:any)"] = "helper/external/ical";
$route["event/check"] = "event/event/checkPlausibility";
$route["event/show/(:any)"] = "helper/external/showevent";
$route["event/(:any)"] = "event/event/showevent";

// übler workaround aber geht nicht anders, da pfade in meetupp.js nicht von Coderigniter geparst werden
$route["event/event/update/basedata"] = "event/event/updateBasedata";
$route["event/event/update/location"] = "event/event/updateLocation";
$route["event/event/update/member"] = "event/event/updateMember";
$route["event/event/update/status/(:any)"] = "event/event/updateStatus";
$route["event/event/update/comment"] = "event/event/updateComment";
// ---


// Nachrichtensystem
$route["mail/delete/(:any)"] = "messaging/messaging/hide";
$route["mail/inbox"] = "messaging/messaging/inbox";
$route["mail/send"] = "messaging/messaging/send";
$route["mail/(:any)"] = "messaging/messaging/show";


// Location
$route["location/add/(:any)"] = "location/add";
$route["location/location/getnewlocation/(:any)"] = "location/location/getnewlocation";
$route["location/(:any)"] = "location/location/getLocation";

/* End of file routes.php */
/* Location: ./application/config/routes.php */