<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Escaper;
use Zend\Mail\Transport\Sendmail;

$some_name = session_name("some_name");
session_set_cookie_params(0, '/', '.concertq.com');
session_start();


class StaticController extends AbstractActionController {

    public function contactAction() {

        $MetaEvent = array(
            'title' => 'Concert tickets Q ' . date('Y') . ' | Concert.com',
            'description' => 'Find cheap Concert tickets at a discount at  Concert.com. ',
            'keywords' => 'Concert Tickets Q',
            'og:title' => 'Buy concert tickets and get the latest tour info and artist news on concertq.com',
            'og:type' => 'website',
            'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/concertq-logo.png",
            'og:url' => 'http://www.concertq.com',
            'og:description' => 'Get cheap concert tickets to the hottest shows and events at ConcertTicketsq.com',
            'og:sitename' => 'concertq.com'
        );
        $OGmetas = array('og:title' => 'Buy concert tickets and get the latest tour info and artist news on concertq.com',
            'og:type' => 'website',
            'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/concertq-logo.png",
            'og:url' => 'http://www.concertq.com',
            'og:description' => 'Get cheap concert tickets to the hottest shows and events at ConcertTicketsq.com',
            'og:sitename' => 'concertq.com');

        $data['MetaEvent'] = $MetaEvent;
        $data['OGmetas'] = $OGmetas;
       
        // contact form 
        
        if( $this->params()->fromPost() ){
            $first_name = $this->params()->fromPost('first_name');
            $last_name = $this->params()->fromPost('last_name');
            $email = $this->params()->fromPost('email');
            $phone = $this->params()->fromPost('phone');
            $preference = $this->params()->fromPost('preference');
            $reason = $this->params()->fromPost('reason');
            $message = $this->params()->fromPost('message');
            
            $escaper = new Escaper\Escaper('utf-8');
            $body_message = "Message :\n" . $escaper->escapeHtmlAttr($message) . "\n\n
                    ------------------------------------------------------------\n\n
                    Contact Informations :\n\n
                    First name : " . $escaper->escapeHtmlAttr($first_name) . "\n
                    Last name : " . $escaper->escapeHtmlAttr($last_name) . "\n
                    Email : " . $email . "\n
                    Phone number : " . $escaper->escapeHtmlAttr($phone) . "\n
                    Contact preference : " . $escaper->escapeHtmlAttr($preference) . "\n
                    Contact reason : " . $escaper->escapeHtmlAttr($reason) . "\n";
            
            $mail = new Message();
            $mail->setBody($body_message)->setEncoding('UTF-8');
            $mail->setFrom('info@concertq.com');
            $mail->addTo('james@concertq.com');
//            $mail->addTo('info@concertq.com');
            $mail->setSubject('ConcertTicketsQ : New contact');

            $transport = new Sendmail();
            $transport->send($mail);
            $data['transport']=$transport;
            //$data['email']=$email;
        }
        
        // ************
         $viewM = new ViewModel($data);
         return $viewM;
    }

    public function aboutAction() {

        $MetaEvent = array(
            'title' => 'Concert tickets Q ' . date('Y') . ' | Concert.com',
            'description' => 'Find cheap Concert tickets at a discount at  Concert.com. ',
            'keywords' => 'Concert Tickets Q',
            'og:title' => 'Buy concert tickets and get the latest tour info and artist news on concertq.com',
            'og:type' => 'website',
            'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/concertq-logo.png",
            'og:url' => 'http://www.concertq.com',
            'og:description' => 'Get cheap concert tickets to the hottest shows and events at ConcertTicketsq.com',
            'og:sitename' => 'concertq.com'
        );
        $OGmetas = array('og:title' => 'Buy concert tickets and get the latest tour info and artist news on concertq.com',
            'og:type' => 'website',
            'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/concertq-logo.png",
            'og:url' => 'http://www.concertq.com',
            'og:description' => 'Get cheap concert tickets to the hottest shows and events at ConcertTicketsq.com',
            'og:sitename' => 'concertq.com');

        $data['MetaEvent'] = $MetaEvent;
        $data['OGmetas'] = $OGmetas;
        $viewM = new ViewModel($data);
        //$viewM->setTemplate('application/static/contact');
        return $viewM;
    }

    public function helpAction() {

        $MetaEvent = array(
            'title' => 'Concert tickets Q ' . date('Y') . ' | Concert.com',
            'description' => 'Find cheap Concert tickets at a discount at  Concert.com. ',
            'keywords' => 'Concert Tickets Q',
            'og:title' => 'Buy concert tickets and get the latest tour info and artist news on concertq.com',
            'og:type' => 'website',
            'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/concertq-logo.png",
            'og:url' => 'http://www.concertq.com',
            'og:description' => 'Get cheap concert tickets to the hottest shows and events at ConcertTicketsq.com',
            'og:sitename' => 'concertq.com'
        );
        $OGmetas = array('og:title' => 'Buy concert tickets and get the latest tour info and artist news on concertq.com',
            'og:type' => 'website',
            'og:image' => "http://" . $this->getRequest()->getUri()->getHost() . $this->getRequest()->getUri()->getPath() . "/img/concertq-logo.png",
            'og:url' => 'http://www.concertq.com',
            'og:description' => 'Get cheap concert tickets to the hottest shows and events at ConcertTicketsq.com',
            'og:sitename' => 'concertq.com');

        $data['MetaEvent'] = $MetaEvent;
        $data['OGmetas'] = $OGmetas;
        $viewM = new ViewModel($data);
        //$viewM->setTemplate('application/static/contact');
        return $viewM;
    }

}
