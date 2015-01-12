<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;

/**
 * Description of AjaxController
 *
 * @author Ahmed
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AjaxController extends AbstractActionController {

    protected $router;

    public function getRouter() {
        if (!$this->router) {
            $sm = $this->getServiceLocator();
            $this->router = $sm->get('router');
        }
        return $this->router;
    }

    public function ticketsAction() {
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
        
        $event_id = $this->getRequest()->getPost('event_id');
        $tgData = file_get_contents('http://www.ticketsreview.com/ajax/ticket-feed-results-to-small-websites/?event_id=' . $event_id);
        $viewModel = new ViewModel(array('tgData' => $tgData));
        $viewModel->setTerminal(TRUE);
        return $viewModel;
    }

}
