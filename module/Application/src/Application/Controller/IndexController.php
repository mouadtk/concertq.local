<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;

/**
 * Description of IndexController
 *
 * @author smail
 */
$some_name = session_name("some_name");
session_set_cookie_params(0, '/', '.concertq.com');
session_start();

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Http\Request;

class IndexController extends AbstractActionController {

    protected $ZipcodesTable;
    protected $CountriesTable;
    protected $VenuesTable;
    protected $GeolocationTable;
    protected $PerformerTable;
    protected $EventsTable;
    protected $CitiesTable;

    public function getZipcodesTable() {
        if (!$this->ZipcodesTable) {
            $sm = $this->getServiceLocator();
            $this->ZipcodesTable = $sm->get('Application\Model\ZipcodesTable');
        }
        return $this->ZipcodesTable;
    }

    public function getCitiesTable() {
        if (!$this->CitiesTable) {
            $sm = $this->getServiceLocator();
            $this->CitiesTable = $sm->get('Application\Model\CitiesTable');
        }
        return $this->CitiesTable;
    }

    public function getCountriesTable() {
        if (!$this->CountriesTable) {
            $sm = $this->getServiceLocator();
            $this->CountriesTable = $sm->get('Application\Model\CountriesTable');
        }
        return $this->CountriesTable;
    }

    public function getStatesTable() {
        if (!$this->StatesTable) {
            $sm = $this->getServiceLocator();
            $this->StatesTable = $sm->get('Application\Model\StatesTable');
        }
        return $this->StatesTable;
    }

    public function getVenuesConfigurationsTypesTable() {
        if (!$this->VenuesConfigurationsTypesTable) {
            $sm = $this->getServiceLocator();
            $this->VenuesConfigurationsTypesTable = $sm->get('Application\Model\VenuesConfigurationsTypesTable');
        }
        return $this->VenuesConfigurationsTypesTable;
    }

    public function getVenuesTable() {
        if (!$this->VenuesTable) {
            $sm = $this->getServiceLocator();
            $this->VenuesTable = $sm->get('Application\Model\VenuesTable');
        }
        return $this->VenuesTable;
    }

    public function getPerformerTable() {
        if (!$this->PerformerTable) {
            $sm = $this->getServiceLocator();
            $this->PerformerTable = $sm->get('Application\Model\PerformerTable');
        }
        return $this->PerformerTable;
    }

    public function getEventsTable() {
        if (!$this->EventsTable) {
            $sm = $this->getServiceLocator();
            $this->EventsTable = $sm->get('Application\Model\EventsTable');
        }
        return $this->EventsTable;
    }

    public function getGeoTable() {
        if (!$this->GeolocationTable) {
            $sm = $this->getServiceLocator();
            $this->GeolocationTable = $sm->get('Application\Model\LocationTable');
        }
        return $this->GeolocationTable;
    }

    public function getDistinctVenues($TopVenues) {
        $TOPdistinctvenues = array();
        $usedvenues = array();

        foreach ($TopVenues as $value) {
            $t = $value->getVenue()->get_name();
            if (in_array($t, $usedvenues) == false) {
                array_push($TOPdistinctvenues, $value);
            } else if (in_array($t, $usedvenues) != false) {
                array_push($usedvenues, $t);
            }
            array_push($usedvenues, $t);
        }
        return $TOPdistinctvenues;
    }

    protected $router;

    public function getRouter() {
        if (!$this->router) {
            $sm = $this->getServiceLocator();
            $this->router = $sm->get('router');
        }
        return $this->router;
    }

    public function indexAction() {
        /*         * ********************** Allow Ajax From This Website *********************************** */


        
        

        /*         * ********************** Allow Ajax From This Website *********************************** */
        $metas = array(
            'title' => 'Concert Q ' . date('Y') . ' & Schedule & Tickets | Concertq.com',
            'description' => 'Find information about local Concerts in your city and score the best tickets at  concertq.com ',
            'keywords' => 'Concert Tickets',
            'og:title' => 'Buy tickets to the latest gigs and concerts. Find listings and concert information at Concertq.com.',
            'og:type' => 'website',
            'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "img/logo-bold.png",
            'og:url' => 'http://www.concertq.com',
            'og:description' => 'Buy tickets for pop and rock concerts at concertq',
            'og:sitename' => 'Concertq.com'
        );
        $OGmetas = array('og:title' => 'Buy concert tickets and get the latest tour info and artist news on concertq.com',
            'og:type' => 'website',
            'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "img/logo-bold.png",
            'og:url' => 'http://www.concertq.com',
            'og:description' => 'Get cheap concert tickets to the hottest shows and events at Concertq.com',
            'og:sitename' => 'Concertq.com');

        $this->facebookv2();


        


        if (strpos($this->getRequest()->getUri()->getHost(), 'www') !== FALSE)
            $link = 1;
        else
            $link = 0;

        $cityidtab = array();
        
        $NbCities = 40;
        $NbPerformers = 50;
        $checkip = FALSE;
        $venuefilter = array();
        $request = $this->getRequest();


    
        /*         * ****************************** Ajax + Offset ******************************************* */
        //ajax identifier
        $ajax = $this->params()->fromQuery('ajax');
        $ajax = (int) $ajax;

        //offset of the current data displayed (Events)
        $offset = $this->params()->fromQuery('offset');
        $offset = (int) $offset;



        /*         * ************************************* Ajax + Offset ****************************************** */

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
        
       
        
           if($zipcities->count() == 0 ) 
                array_push($cityidtab, '12');
               $CityID = $this->getEventsTable()->getEvents2($cityidtab,$offset);
        
        
        
        } else  {

            $CityID = $this->getEventsTable()->getEvents2(array('t' => '12'),$offset);
            array_push($cityidtab, '12');
        }

        $Top40Cities = $this->getCitiesTable()->getTopCities($NbCities);
        $Top50Performers = $this->getPerformerTable()->getTopPerformers($NbPerformers);
        $CityID->buffer();
        $Top50Performers->buffer();

        $TopVenues = $CityID;


        // AJAX REQUEST
        if ($this->getRequest()->isXmlHttpRequest()) {
            $par = $this->params()->fromQuery('cities');
            $par1 = $this->params()->fromQuery('venues');
            $par2 = $this->params()->fromQuery('performers');
            $CityID = $this->getEventsTable()->getEventsFilter($par, $par1, $par2, $cityidtab);
            $CityID->buffer();

            $TopVenues = $CityID;
            $Viewarray = array('link' => $link, 'venues' => $CityID, 'topcities' => $Top40Cities, 'topperformers' => $Top50Performers, 'topvenues' => $this->getDistinctVenues($TopVenues), 'offset' => $offset, 'ajax' => $ajax, 'limit' => 20, 'OGmetas' => $OGmetas);

            $t = new ViewModel($Viewarray);
            $t->setTerminal(TRUE);
            return $t;
        }



        $Viewarray = array('link' => $link, 'venues' => $CityID, 'topcities' => $Top40Cities, 'topperformers' => $Top50Performers, 'topvenues' => $this->getDistinctVenues($TopVenues), 'metas' => $metas, 'OGmetas' => $OGmetas, 'offset' => $offset, 'ajax' => $ajax, 'limit' => 20, 'OGmetas' => $OGmetas);
        $this->layout()->metas = $metas;
        return new ViewModel($Viewarray);
    }

    public function facebookv2() {

        FacebookSession::setDefaultApplication('246335522225102', 'e519c9d85df0933f06c19f5e2ef141c8');


// login helper with redirect_uri
        $helper = new FacebookRedirectLoginHelper('http://www.concertq.com/');

// see if a existing session exists
        if (isset($_SESSION) && isset($_SESSION['fb_token'])) {
            // create new session from saved access_token
            $session = new FacebookSession($_SESSION['fb_token']);

            // validate the access_token to make sure it's still valid
            try {
                if (!$session->validate()) {
                    $session = null;
                }
            } catch (Exception $e) {
                // catch any exceptions
                $session = null;
            }
        } else {
            // no session exists

            try {
                $session = $helper->getSessionFromRedirect();
            } catch (FacebookRequestException $ex) {
                // When Facebook returns an error
                // handle this better in production code
                print_r($ex);
            } catch (Exception $ex) {
                // When validation fails or other local issues
                // handle this better in production code
                print_r($ex);
            }
        }

// see if we have a session
        if (isset($session)) {

            // save the session
            $_SESSION['fb_token'] = $session->getToken();
            // create a session using saved token or the new one we generated at login
            $session = new FacebookSession($session->getToken());

            // graph api request for user data
            $request = new FacebookRequest($session, 'GET', '/me');
            $response = $request->execute();
            // get response
            $graphObject = $response->getGraphObject()->asArray();




            $_SESSION['username'] = $graphObject['name'];
            $_SESSION['profilepic'] = "https://graph.facebook.com/" . $graphObject['id'] . "/picture?type=small";
            $_SESSION['logouturl'] = '<a href="' . $helper->getLogoutUrl($session, 'http://www.concertq.com/logout.html') . '">Logout</a>';
            $_SESSION['sessionfb'] = $session;
            $_SESSION['facebooklogin'] = null;





            // print profile data
//  echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
//  
//
        } else {
            //     $this->layout()->urlfacebook = 
            $_SESSION['facebooklogin'] = $helper->getLoginUrl(array('public_profile', 'email', 'user_friends', 'publish_stream', 'manage_pages', 'publish_actions', 'status_update', 'user_likes ', 'photo_upload'));
            // show login url
//  echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends' ) ) . '">Login</a>';
        }
    }

}
