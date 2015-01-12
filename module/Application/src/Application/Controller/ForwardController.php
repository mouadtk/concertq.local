<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

/* $some_name = session_name("some_name");
  session_set_cookie_params(0, '/', '.concertq.com');
  session_start(); */

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ForwardController extends AbstractActionController {

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

    protected $CitiesTable;

    public function getCitiesTable() {
        if (!$this->CitiesTable) {
            $sm = $this->getServiceLocator();
            $this->CitiesTable = $sm->get('Application\Model\CitiesTable');
        }
        return $this->CitiesTable;
    }

    public function indexAction() {


        /*         * ********************** Allow Ajax From This Website *********************************** */

        /* //Get the router
          $router = $this->getRouter();

          //check if the request has come from an existing route
          $matchedRoute = $router->match($this->getRequest());
          if (null == $matchedRoute) {
          //Cross-site scripting (XSS)
          exit;
          }
          //allow the ajax request
          header('Access-Control-Allow-Origin: ' . $this->getRequest()->getServer('HTTP_HOST'));

          #        * ********************** Allow Ajax From This Website ***********************************


          //Array containing  data passed to the view
          $data = array();

          //ajax identifier
          $ajax = $this->params()->fromQuery('ajax');
          $ajax = (int) $ajax;

          $data['ajax'] = $ajax;

          //offset of the current data displayed (Events)
          $offset = $this->params()->fromQuery('offset');
          $offset = (int) $offset;

          $data['offset'] = $offset; */
        //get performer name from url
        $subdomain_url = $this->params()->fromRoute('subdomain');

        //test if is there any city with dash link : $subdomain_url        
        $cityTable = $this->getCitiesTable();
        $city = $cityTable->getCityByDashForward($subdomain_url);
        if ($city ) {
            return $this->forward()->dispatch('\Application\Controller\City', array('action'=>'city', 'subdomain' => $subdomain_url));
        } else {
            return $this->forward()->dispatch('\Application\Controller\Event', array('action'=>'event', 'subdomain' => $subdomain_url));
        }
    }

}
