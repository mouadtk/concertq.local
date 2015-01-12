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

class CityController extends AbstractActionController {

    protected $CitiesTable;
    protected $EventTable;

    public function getEventsTable() {
        if (!$this->EventTable) {
            $sm = $this->getServiceLocator();
            $this->EventTable = $sm->get('Application\Model\EventsTable');
        }
        return $this->EventTable;
    }

    public function getCitiesTable() {
        if (!$this->CitiesTable) {
            $sm = $this->getServiceLocator();
            $this->CitiesTable = $sm->get('Application\Model\CitiesTable');
        }
        return $this->CitiesTable;
    }

    protected $router;

    public function getRouter() {
        if (!$this->router) {
            $sm = $this->getServiceLocator();
            $this->router = $sm->get('router');
        }
        return $this->router;
    }

    public function cityAction() {
        
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
        header('Access-Control-Allow-Origin: *'); // . $this->getRequest()->getServer('HTTP_HOST'));

        /*         * ********************** Allow Ajax From This Website *********************************** */

        //get performer name from url
        
        
        $city_url = $this->params()->fromRoute('subdomain');
        $offset = $this->params()->fromQuery('offset');
        $offset = (int) $offset;

        $ajax = $this->params()->fromQuery('ajax');
        $ajax = (int) $ajax;

        $cityTable = $this->getCitiesTable();


        $city = $cityTable->getCityByDash($city_url);

        if (!$city || $city->count() == 0) {
            //Performer not found
            $this->getResponse()->setStatusCode(404);
            $viewM = new ViewModel();
            $viewM->setTemplate('error/404');
            return $viewM;
        }
//    exit;
//        $eventTable = $this->getEventsTable();
//
//
//        
//

        $data['city'] = $city->current();



        $data['offset'] = $offset;

        $data['ajax'] = $ajax;

        $eventTable = $this->getEventsTable();


        //       FILTER VENUE

        $venueid = $this->params()->fromQuery('venue');
        $venueid = explode(",", $venueid);
        foreach ($venueid as $key => $value) {
            $venueid[$key] = ((int) $value);
        }
        //venue filter
        if (count($venueid) >= 1 && $venueid[0]) {
            $events = $eventTable->getEventsByVenues($venueid);

            $events->buffer();

            $data['events'] = $events;

            $data['eventsCount'] = $data['events']->count();

            return $data;
        }


        //get 5 events
        $events = $eventTable->getEventsByCity($data['city']->get_id(), false, 2, $offset, 7);

        if (!$events) {

            $viewM = new ViewModel();
            if ($ajax == false) {
                $viewM->setTemplate('error/no_event');
            }
            return $viewM;
        }
//        

        $data['events'] = $events;
        $data['events']->buffer();





        //get events count
        $data['eventsCount'] = $eventTable->getEventsByCity($data['city']->get_id(), true)->current()->get_id();

//        
//        //get events cities and venues
        $data['groupvenues'] = $eventTable->getEventsByCityGroupedVenues($data['city']->get_id(), $data['eventsCount'], 2);
        //make it reusable
        $data['groupvenues']->buffer();
        $countE = 7;
        $data['countE'] = $countE;
        if ($ajax) {
            return $data;
        }

        // *********************** Meta City ***************************    

        $event = $data['groupvenues']->current();

        $categorie = 'Concert'; //Concert
        $description = 'Find ' . $categorie . ' tickets - ' . $data['city']->get_name() . ' schedule at ' . 'concertq.com';
        $keywords = $data['city']->get_name().' '.$categorie ;
        $title = $categorie . ' Tickets ' . $data['city']->get_name() . ' - ' . $event->getVenue()->get_name();

        $OGmetas = array(
            'og:title' => 'Buy concert tickets and get the latest tour info and artist news on concertq.com ',
            'og:type' => 'website',
            'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/logo-bold.png.png",
            'og:url' => 'http://www.concertq.com',
            'og:description' => ' Find the latest '.$data['city']->get_name().' concerts schedule and shows at concertq.com',
            'og:sitename' => 'Concertq.com');

        $MetaEvent = array(
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords
        );
        $data['OGmetas'] = $OGmetas;
        $data['MetaEvent'] = $MetaEvent;

        //   ************************ End Meta City ***********************

        $data['groupperformers'] = $eventTable->getEventsByCityGroupedPerformers($data['city']->get_id());
        $data['groupperformers']->buffer();
        //create the view to use
        $viewM = new ViewModel($data);
        return $viewM;
    }

    public function indexAction() {
//        $viewM=new ViewModel();
//       $viewM->setTemplate('application/event/index' );
//        return $viewM;
    }

    private function test() {
        $viewM = new ViewModel();
        $viewM->setTemplate('performer/city');
        return $viewM;
    }

}
