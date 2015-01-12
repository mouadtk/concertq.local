<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

$some_name = session_name("some_name");
session_set_cookie_params(0, '/', '.concertq.com');
session_start();

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EventController extends AbstractActionController {

    protected $PerformerTable;
    protected $EventTable;
    protected $ZipcodesTable;
    protected $VenuesTable;
    protected $GeolocationTable;
    protected $EventkeywordTable;

    public function getPerformerTable() {
        if (!$this->PerformerTable) {
            $sm = $this->getServiceLocator();
            $this->PerformerTable = $sm->get('Application\Model\PerformerTable');
        }
        return $this->PerformerTable;
    }

    public function getEventsTable() {
        if (!$this->EventTable) {
            $sm = $this->getServiceLocator();
            $this->EventTable = $sm->get('Application\Model\EventsTable');
        }
        return $this->EventTable;
    }

    public function getZipcodesTable() {
        if (!$this->ZipcodesTable) {
            $sm = $this->getServiceLocator();
            $this->ZipcodesTable = $sm->get('Application\Model\ZipcodesTable');
        }
        return $this->ZipcodesTable;
    }

    public function getVenuesTable() {
        if (!$this->VenuesTable) {
            $sm = $this->getServiceLocator();
            $this->VenuesTable = $sm->get('Application\Model\VenuesTable');
        }
        return $this->VenuesTable;
    }

    public function getGeoTable() {
        if (!$this->GeolocationTable) {
            $sm = $this->getServiceLocator();
            $this->GeolocationTable = $sm->get('Application\Model\LocationTable');
        }
        return $this->GeolocationTable;
    }

    public function getEventkeywordTable() {
        if (!$this->EventkeywordTable) {
            $sm = $this->getServiceLocator();
            $this->EventkeywordTable = $sm->get('Application\Model\EventkeywordTable');
        }
        return $this->EventkeywordTable;
    }

    protected $router;

    public function getRouter() {
        if (!$this->router) {
            $sm = $this->getServiceLocator();
            $this->router = $sm->get('router');
        }
        return $this->router;
    }

    public function searchAction() {
        /*         * ********************** Search *********************************** */

        $ajax = $this->params()->fromQuery('ajax');
        $ajax = (int) $ajax;

        $search = $this->params()->fromPost('search');


        if (isset($search)) {
            if (!empty($search)) {
                //make the search like : +los +angeles + lakers

                $data = array();
                $searchable = $search;
                $search = explode(' ', preg_replace('/\s{2,}|%20/', ' ', $search));

                $search = '+' . implode(' +', $search);

                //Escape html tag
                $escaper = new \Zend\Escaper\Escaper('utf-8');
                $search = $escaper->escapeHtml($search);

                //Quote Sql value : 'value's ' => 'value\'s '
                $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                $search = $dbAdapter->getPlatform()->quoteValue($search);


                $data['search'] = $searchable;


                //ajax identifier


                $data['ajax'] = $ajax;


                //offset of the current data displayed (Events)
                $offset = $this->params()->fromQuery('offset');
                $offset = (int) $offset;

                $data['offset'] = $offset;



                // echo "$search";
                //get 20 result which match the search 
                $eventkeywordTable = $this->getEventkeywordTable();
                $eventsK = $eventkeywordTable->searchBy($search, false, $offset);
                $eventsK->buffer();

                $data['eventsK'] = $eventsK;

                //Get count of found events from the search
                if ($eventsK->count() >= 1) {
                    $data['eventsCount'] = $eventkeywordTable->searchBy($search, true)->current()->get_event_id();
                } else {
                    $data['eventsCount'] = $eventsK->count();
                }



                if ($ajax) {
                    return $data;
                }

                /*                 * ********************** Search Meta Event *********************************** */

                $description = 'desc';
                $keywords = $searchable;

                $title = "search for : " . $searchable;
                $robots = "noindex,follow";

                $OGmetas = array(
                    'og:title' => 'Buy concert tickets on concertq.com ',
                    'og:type' => 'website',
                    'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/logo-bold.png.png",
                    'og:url' => 'http://www.concertq.com',
                    'og:description' => 'Find Q Event concert ' . date('Y') . ' dates and schedule at concertq.com.',
                    'og:sitename' => 'Concertq.com');

                $MetaEvent = array(
                    'title' => $title,
                    'description' => $description,
                    'keywords' => $keywords,
                    'robots' => $robots
                );
                $data['OGmetas'] = $OGmetas;
                $data['MetaEvent'] = $MetaEvent;

                /*                 * ********************** Search Meta Event *********************************** */

                return $data;
            }
        }

        //search is empty
        //redirect to index page
        if (!$ajax) {
            return $this->redirect()->toRoute('www');
        }
        exit;
        /*         * ********************** Search *********************************** */
    }

    public function eventAction() {
       
        $performer_url = $this->params()->fromRoute('subdomain');

        /*         * ********************** Allow Ajax From This Website *********************************** */

        //Get the router
        $router = $this->getRouter();

        //check if the request has come from an existing route
        $matchedRoute = $router->match($this->getRequest());
        if (null == $matchedRoute) {
            //Cross-site scripting (XSS)
            exit;
        }
        //allow the ajax request
        header('Access-Control-Allow-Origin: ' . $this->getRequest()->getServer('HTTP_HOST'));

        /*         * ********************** Allow Ajax From This Website *********************************** */


        //Array containing  data passed to the view
        $data = array();

        //ajax identifier
        $ajax = $this->params()->fromQuery('ajax');
        $ajax = (int) $ajax;

        $data['ajax'] = $ajax;

        //offset of the current data displayed (Events)
        $offset = $this->params()->fromQuery('offset');
        $offset = (int) $offset;

        $data['offset'] = $offset;






//        echo $offset;
        //retrieve Mapper instance

        $performerTable = $this->getPerformerTable();

        //get performer by given param from url
        //$performer = $performerTable->getPerformerByCatAndNameDash(2,$performer_url);

        $performer = $performerTable->existInCat(2, $performer_url);
//echo "eeeeee";
//        exit;
        if (!$performer) {
            //Performer not found
            $this->getResponse()->setStatusCode(404);
            $viewM = new ViewModel();
            $viewM->setTemplate('error/404');
            return $viewM;
        }

        $data['performer'] = $performer;



        /*         * ********************** Geo Location *********************************** */

        $cityidtab = array();
        $ip_test = $_SERVER['REMOTE_ADDR'];

        if (preg_match('/bot|spider|crawler|curl|^$/i', $_SERVER['HTTP_USER_AGENT']) === 0) {
            $GetLatLongfromIp = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip_test));
            $GeoLatitude = $GetLatLongfromIp['geoplugin_latitude'];
            $GeoLongitude = $GetLatLongfromIp['geoplugin_longitude'];



            $DistanceMiles = 150;


            $ZipcodeLatitude = $GeoLatitude;
            $ZipcodeLongitude = $GeoLongitude;
            $Latitude1 = $ZipcodeLatitude - $DistanceMiles / 69;
            $Latitude2 = $ZipcodeLatitude + $DistanceMiles / 69;
            $Longitude1 = $ZipcodeLongitude - $DistanceMiles / (abs(cos(deg2rad($ZipcodeLatitude)) * 69));
            $Longitude2 = $ZipcodeLongitude + $DistanceMiles / (abs(cos(deg2rad($ZipcodeLatitude)) * 69));
            $zipcities = $this->getVenuesTable()->getZipCity($ZipcodeLatitude, $ZipcodeLongitude, $Latitude1, $Latitude2, $Longitude1, $Longitude2);
            foreach ($zipcities as $value) {

                array_push($cityidtab, $value->getCity());
            }
            if (count($cityidtab) === 0) {
                array_push($cityidtab, 12);
            }
            $CityID = $this->getEventsTable()->getEventsGeolocation($performer->get_id(), $cityidtab);
        } else {


            array_push($cityidtab, 12);
            $CityID = $this->getEventsTable()->getEventsGeolocation($performer->get_id(), $cityidtab);
        }


        $data['CityID'] = $CityID;
        $data['CityID']->buffer();

        /*         * ********************** Geo Location *********************************** */



        $eventTable = $this->getEventsTable();


        /*         * ********************** City Filter *********************************** */

        $cityid = $this->params()->fromQuery('city');
        $cityid = explode(",", $cityid);
        foreach ($cityid as $key => $value) {
            $cityid[$key] = ((int) $value);
        }

        if (count($cityid) >= 1 && $cityid[0]) {
            $events = $eventTable->getEventsByPerformerAndCities($performer->get_id(), $cityid);

            $events->buffer();

            $data['events'] = $events;

            $data['eventsCount'] = $data['events']->count();

            return $data;
        }


        /*         * ********************** City Filter *********************************** */






//        $venueid = $this->params()->fromQuery('venue');
//        $venueid = explode(",", $venueid);
//        foreach ($venueid as $key => $value) {
//            $venueid[$key] = ((int) $value);
//        }
//        //venue filter
//        if (count($venueid) >= 1 && $venueid[0]) {
////            echo implode(",", $cityid);
//            $events = $eventTable->getEventsByPerformerAndVenue($performer->get_id(), $venueid);
//
//            $events->buffer();
//
//            $data['events'] = $events;
//
//            $data['eventsCount'] = $data['events']->count();
//
//            return $data;
//        }



        /*         * ********************** Related performers *********************************** */


        $relatedPerformers = $performerTable->getRelatedPerformer($performer->get_name());

        $relatedPerformers->buffer();
        $data['relatedPerformers'] = $relatedPerformers;


        /*         * ********************** Related performers *********************************** */



        /*         * ********************** Performer events *********************************** */

        //get 5 events
        $events = $eventTable->getEventsByPerformerIdBigBoss($performer->get_id(), $offset);


        if (!$events) {
            //Event exists
//            foreach ($events as $value) {
//                echo $value->getEventId().'<br/>';
//                $location = $eventTable->getLocation($value->getEventId());
//                foreach ($location as $loc) {
//                    echo "<br/>";
//                }
//                exit;
//            }
            $viewM = new ViewModel();
            if ($ajax == false) {
                $viewM->setTemplate('error/no_event');
            }
            return $viewM;
        }

        $data['events'] = $events;
        $data['events']->buffer();

        //get events count
        $data['eventsCount'] = $eventTable->getEventsByPerformerId($performer->get_id(), true)->current()->get_id();
        $countE = 7;
        $data['countE'] = $countE;
        if ($ajax) {
            return $data;
        }

        //get events cities and venues
        $data['allEvents'] = $eventTable->getEventsByPerformerIdBigBoss($performer->get_id(), 0, $data['eventsCount']);
        //make it reusable
        $data['allEvents']->buffer();

        /*         * ********************** Performer events *********************************** */

        /*         * ********************** Meta Event *********************************** */




        $event = $CityID->current();
        if ($CityID->count() === 0) {
            $event = $events->current();
        }
        $categorie = 'Concert'; //Concert
        $description = 'Find ' . $performer->get_name() . ' ' . $categorie . ' ' . date('Y') . ' dates and schedule at ' . 'concertq.com';
        $keywords = $performer->get_name() . ' ' . $categorie ;
        $title = $performer->get_name() . ' ' . $categorie . ' tickets - ' . $event->getVenue()->get_name();
        // Modif
        $OGmetas = array(
            'og:title' => $performer->get_name() . ' ' . $categorie . ' - ' . $event->getVenue()->get_name(),
            'og:type' => 'website',
            'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/logo-bold.png.png",
            'og:url' => 'http://www.concertq.com',
            'og:description' => $description,
            'og:sitename' => 'Concertq.com');
        // End
        $MetaEvent = array(
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords
        );
        if (!$performer->inTopRank()) {
            $robots = "noindex,follow";
            $MetaEvent['robots'] = $robots;
        }

        $data['MetaEvent'] = $MetaEvent;
        $data['OGmetas'] = $OGmetas;


        /*         * ********************** Meta Event *********************************** */

        $viewM = new ViewModel($data);
        return $viewM;
    }

    public function indexAction() {
//        $viewM=new ViewModel();
//       $viewM->setTemplate('application/event/index' );
//        return $viewM;
    }

}
