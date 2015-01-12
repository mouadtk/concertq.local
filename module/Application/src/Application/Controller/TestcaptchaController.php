<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;

/**
 * Description of TestcaptchaController
 *
 * @author ahmed
 */
use Zend\Mvc\Controller\AbstractActionController,
    Test\Form\TestCaptchaForm;

class TestcaptchaController extends AbstractActionController {

    public function generateAction() {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', "image/png");

        $id = $this->params('id', false);

        if ($id) {

            $image = './data/captcha/' . $id;

            if (file_exists($image) !== false) {
                $imagegetcontent = @file_get_contents($image);

                $response->setStatusCode(200);
                $response->setContent($imagegetcontent);

                if (file_exists($image) == true) {
                    unlink($image);
                }
            }
        }

        return $response;
    }

    public function formAction() {
        $form = new TestCaptchaForm($this->getRequest()->getBaseUrl() . '/test/testcaptcha/captcha/');
        $request = $this->getRequest();
        if ($request->isPost()) {
            //set data post
            $form->setData($request->getPost());

            if ($form->isValid()) {
                echo "captcha is valid ";
            }
        }

        return array('form' => $form);
    }

}
