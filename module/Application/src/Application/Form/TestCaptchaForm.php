<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form;

/**
 * Description of TestCaptchaForm
 *
 * @author ahmed
 */
use Zend\Form\Form,
    Zend\Form\Element\Captcha,
    Zend\Captcha\Image as CaptchaImage;

class TestCaptchaForm extends Form {

    public function __construct($urlcaptcha = null) {
        parent::__construct('Test Form Captcha');
        $this->setAttribute('method', 'post');

        $dirdata = './data';

        //pass captcha image options
        $captchaImage = new CaptchaImage(array(
            'font' => $dirdata . '/fonts/arial.ttf',
            'width' => 250,
            'height' => 100,
            'dotNoiseLevel' => 40,
            'lineNoiseLevel' => 3)
        );
        $captchaImage->setImgDir($dirdata . '/captcha');
        $captchaImage->setImgUrl($urlcaptcha);

        //add captcha element...
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human',
                'captcha' => $captchaImage,
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Test Captcha Now'
            ),
        ));
    }

}
