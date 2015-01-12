<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;

use Zend\Http\Request;

/**
 * Description of IndexController
 *
 * @author smail
 */
$some_name = session_name("some_name");
session_set_cookie_params(0, '/', '.concertq.com');
session_start();

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TicketController extends AbstractActionController {

    protected $TicketsTable;
    protected $EventsTable;
    protected $PerformerTable;
    protected $VenuesTable;
    protected $CitiesTable;
    protected $StatesTable;

    public function getTicketsTable() {
        if (!$this->TicketsTable) {
            $sm = $this->getServiceLocator();
            $this->TicketsTable = $sm->get('Application\Model\TicketTable');
        }
        return $this->TicketsTable;
    }

    public function getEventsTable() {
        if (!$this->EventsTable) {
            $sm = $this->getServiceLocator();
            $this->EventsTable = $sm->get('Application\Model\EventsTable');
        }
        return $this->EventsTable;
    }

    public function getCitiesTable() {
        if (!$this->CitiesTable) {
            $sm = $this->getServiceLocator();
            $this->CitiesTable = $sm->get('Application\Model\CitiesTable');
        }
        return $this->CitiesTable;
    }

    public function getPerformerTable() {
        if (!$this->PerformerTable) {
            $sm = $this->getServiceLocator();
            $this->PerformerTable = $sm->get('Application\Model\PerformerTable');
        }
        return $this->PerformerTable;
    }

    public function getVenuesTable() {
        if (!$this->VenuesTable) {
            $sm = $this->getServiceLocator();
            $this->VenuesTable = $sm->get('Application\Model\VenuesTable');
        }
        return $this->VenuesTable;
    }

    public function getStatesTable() {
        if (!$this->StatesTable) {
            $sm = $this->getServiceLocator();
            $this->StatesTable = $sm->get('Application\Model\StatesTable');
        }
        return $this->StatesTable;
    }

    protected $router;

    public function getRouter() {
        if (!$this->router) {
            $sm = $this->getServiceLocator();
            $this->router = $sm->get('router');
        }
        return $this->router;
    }

    public function ticketAction() {
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

        $GOOGLE_API_KEY = 'AIzaSyBkYiZJsJ-ST1vT6z6GGzoyfKZK_TVWMhw';



        $eventid = $this->params()->fromQuery('eventid');
        //$venueid = $this->getRequest()->getPost('venueId');
        $performerdash = $this->getEvent()->getRouteMatch()->getParam('subdomain');
        $venuedash = $this->params()->fromRoute('venue');

//        $citydash = preg_replace_callback(
//                '/([A-Z])/', function ($matches) {
//            return strtolower('-' . $matches[1]);
//        }, $citydash
//        );
        //echo $citydash;
        $performer = $this->getPerformerTable()->getPerformerByLink($performerdash);
        if (!$performer) {
            return $this->redirect()->toRoute('www', array());
        }

        $city = $this->getVenuesTable()->getVenuesbyLink($venuedash);

        if (!$city) {
            return $this->redirect()->toRoute('subdomain', array(
                        'subdomain' => $performer->get_link_dash()
            ));
        }


        $data = array();
        //si on event id
        if (!empty($eventid)) {
            $comingfromgoogle = 0;

            $event = $this->getEventsTable()->getEvents($eventid)->current();
            if(!$event)
            {
                return $this->redirect()->toRoute('subdomain', array('subdomain' => $performerdash))->setStatusCode(301);
            }
//            if ($event->getEventDate()->format("Ymd") <= new \DateTime(date("Ymd")) && $event->getEventTime()->format("His") <= new \DateTime(date("His"))) {
//                //301 redirection
//                return $this->redirect()->toRoute('subdomain', array('subdomain' => $performerdash))->setStatusCode(301);
//            }
            $nextevents = $this->getEventsTable()->getNextEvents($performer->get_id(), $event->get_date()->format("Y-m-d"));
            $Otherdates = $this->getEventsTable()->getEventsByVenue($performer->get_id(), $event->getVenue()->get_id(), $eventid);
            $Otherdates->buffer();
            $OGmetas = array(
                'og:title' => 'Buy concert tickets and get the latest tour info and artist news on concertq.com ',
                'og:type' => 'website',
                'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/logo-bold.png",
                'og:url' => 'http://www.concertq.com',
                'og:description' => 'Get cheap concert tickets to the hottest shows and events at Concert.com',
                'og:sitename' => 'Concert.com');
            $metas = array(
                'title' => $event->getVenue()->getCity()->get_name() . ' concert tickets in ' . $event->getVenue()->get_name() . ' ' . $event->get_date()->format("M d Y") . ' | concertq.com',
                'description' => 'Buy ' . $event->getVenue()->getCity()->get_name() . " tickets at concertq.com on " . $event->get_date()->format("F dS"),
                'keywords' => $event->get_name() . ', ' . $event->getVenue()->get_name() . ', ' . $event->getVenue()->getCity()->get_name() . ' ' . $event->get_date()->format("F d, Y"),
            );
            $url_city = '<a alt="'
                    .$event->getVenue()->getCity()->get_name()
                    .'" href="'
                    .$this->url()->fromRoute('subdomain',array('subdomain' =>$event->getVenue()->getCity()->get_link_dash()))
                    .'">'
                    .strtoupper($event->getVenue()->getCity()->get_name())
                    .'</a>';
            $htagsticket = array(
                'Htag1' => strtoupper($event->getHost()->get_name()) . ' ' . $event->getVenue()->getCity()->get_name() . ' Concert tickets ' . $event->get_date()->format("Y-m-d"),
                'Htag2' => strtoupper($event->getHost()->get_name()) . ' ' . $event->getVenue()->get_name() . ' tickets ',
                'Htag1_html' => strtoupper($event->getHost()->get_name()).' '.$url_city. strtoupper(' Concert tickets ' .$event->get_date()->format("m-d-Y")),
                'Htag3' => strtoupper($event->getHost()->get_name()) . ' ' . $event->getVenue()->get_name() . ' Concert ' . $event->get_date()->format("M dS"));
                
            $data['OGmetas'] = $OGmetas;
            $data['metas'] = $metas;
            $data['otherdates'] = $Otherdates;
            $data['htagsticket'] = $htagsticket;
            $data['event'] = $event;
            $data['nextevents'] = $nextevents;
            $data['comingfromgoogle'] = 0;
        }



        //sinon, on a juste performerlink + citylink
        elseif (!empty($performerdash) && !empty($city)) {
            $event = $this->getEventsTable()->getEvents(NULL, NULL, $performer, NULL, $city)->current();
            $data['event'] = $event;

             if(!$event)
            {
                return $this->redirect()->toRoute('subdomain', array('subdomain' => $performerdash))->setStatusCode(301);
            }
//            if ($event->getEventDate()->format("Ymd") <= new \DateTime(date("Ymd")) && $event->getEventTime()->format("His") <= new \DateTime(date("His"))) {
//                //301 redirection
//                return $this->redirect()->toRoute('subdomain', array('subdomain' => $performerdash))->setStatusCode(301);
//            }
            $nextevents = $this->getEventsTable()->getNextEvents($performer->get_id(), $event->get_date()->format("Y-m-d"));
            $data['nextevents'] = $nextevents;
            //$Otherdates = $this->getEventsTable()->getEventsByPerformerAndCity($performerdash, $citydash);
            $Otherdates = $this->getEventsTable()->getEvents(NULL, Null, $performer, Null, $city, NULL);
            $Otherdates->buffer();
            $data['otherdates'] = $Otherdates;
            $comingfromgoogle = 1;
            $data['comingfromgoogle'] = $comingfromgoogle;
            $OGmetas = array(
                'og:title' => 'Buy concert tickets and get the latest tour info and artist news on concertq.com ',
                'og:type' => 'website',
                'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/concertq-logo.png",
                'og:url' => 'http://www.concertq.com',
                'og:description' => 'Get cheap concert tickets to the hottest shows and events at Concert.com',
                'og:sitename' => 'Concert.com');
            $metas = array(
                'title' => $event->getVenue()->getCity()->get_name() . ' concert tickets in ' . $event->getVenue()->get_name() . ' ' . $event->get_date()->format("M d Y") . ' | concertq.com',
                'description' => 'Buy ' . $event->getVenue()->getCity()->get_name() . " tickets at concertq.com on " . $event->get_date()->format("F dS"),
                'keywords' => $event->get_name() . ', ' . $event->getVenue()->get_name() . ', ' . $event->getVenue()->getCity()->get_name() . ' ' . $event->get_date()->format("F d, Y"),
            );
            $data['metas'] = $metas;
            $data['OGmetas'] = $OGmetas;
            $url_city = '<a alt="'
                    .$event->getVenue()->getCity()->get_name()
                    .'" href="'
                    .$this->url()->fromRoute('subdomain',array('subdomain' =>$event->getVenue()->getCity()->get_link_dash()))
                    .'">'
                    .strtoupper($event->getVenue()->getCity()->get_name())
                    .'</a>';
            $htagsticket = array(
            'Htag1' => strtoupper($event->getHost()->get_name()).' '.$url_city. ' Concert tickets ' .$event->get_date()->format("m-d-Y"),
            'Htag1_html' => strtoupper($event->getHost()->get_name()).' '.$url_city. strtoupper(' Concert tickets ' .$event->get_date()->format("m-d-Y")),
            'Htag2' => strtoupper($event->getHost()->get_name()) . ' ' . $event->getVenue()->get_name() . ' tickets ',
            'Htag3' => strtoupper($event->getHost()->get_name()) . ' ' . $event->getVenue()->get_name() . ' Concert '.$event->get_date()->format("M dS"));
            $data['htagsticket'] = $htagsticket;
        }


        /* if (!empty($eventid) ) {
          $Ticketinfo = $this->getTicketsTable()->getTicketsByEvent($eventid);

          if (empty($Ticketinfo)) {
          return $this->redirect()->toUrl('http://' . $performerdash . '.concertq.com')->setStatusCode(301);
          }

          $Otherdates = $this->getEventsTable()->getEventsByVenue($performerid, $venueid, $eventid);
          $Otherdates->buffer();
          $metas = array(
          'title' => $Ticketinfo->get_event_id()->getEventName().' concert '.$Ticketinfo->get_event_id()->getEventVenueId()->getVenueCity()->get_name().' - '.$Ticketinfo->get_event_id()->getEventVenueId()->getVenueName(),
          'description' => 'Buy Venue Event concert City tickets at concertq.com.',
          'keywords' => $Ticketinfo->get_event_id()->getEventName().', '.$Ticketinfo->get_event_id()->getEventVenueId()->getVenueName().', '.$Ticketinfo->get_event_id()->getEventVenueId()->getVenueCity()->get_name()
          );
          }

          else {

          $Ticketinfogoogle = $this->getEventsTable()->getEventsByPerformerAndCity($performerdash, $citydash);
          $metas = array(
          'title' => '',
          'description' => '',
          'keywords' => ''
          );
          } */
        if (isset($event) && $event->getVenue()->get_name() != '' && $event->getVenue()->get_address() != '' && $event->getVenue()->getZipcode()->get_latitude() != '' && $event->getVenue()->getZipcode()->get_longitude() != '') {
            $address = $event->getVenue()->get_address() . ', ' . $event->getVenue()->getCity()->get_name() . ', ' . $event->getVenue()->getCity()->getState()->get_abbreviation() . ', ' . $event->getVenue()->getZipcode()->getZipcode();
            $data['address'] = $address;
            $big_map_url = 'http://maps.google.com/maps?q=' . urlencode($event->getVenue()->get_name(true)) . '&ll=' . $event->getVenue()->getZipcode()->get_latitude() . ',' . $event->getVenue()->getZipcode()->get_longitude() . '&z=13&key=' . $GOOGLE_API_KEY;
            $data['big_map_url'] = $big_map_url;
            $image_url = 'https://maps.googleapis.com/maps/api/staticmap?center=' . urlencode($address) . '&zoom=13&size=656x246&markers=color:blue%7Clabel:' . urlencode(substr($event->getVenue()->get_name(), 0, 1)) . '|' . $event->getVenue()->getZipcode()->get_latitude() . ',' . $event->getVenue()->getZipcode()->get_longitude() . '&key=' . $GOOGLE_API_KEY . '&sensor=false';
            $data['image_url'] = $image_url;
        }

        $cityConcat = preg_replace_callback(
                '/-([a-z])/', function ($matches) {
            return $matches[1];
        }, $event->getVenue()->getCity()->get_link_dash()
        );

        $data['cityConcat'] = $cityConcat;
        $data['venuedash'] = $venuedash;
        $data['performerdash'] = $performerdash;

        $viewModel = new ViewModel($data);
        return $viewModel;
    }

}

//echo '<pre>';var_dump($this->params()->fromRoute());echo '</pre>';
