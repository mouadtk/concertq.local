<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Image
 *
 * @author ahmed
 */

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Image extends AbstractHelper {

    public function __invoke($link_dash,$type ,$id) {

//        $prefix = "a";
        $suffix = "-concert.jpg";
        $num= $id%40;

        if ($type === "city") {
            $bashPath = "images/cities/";
            
        } elseif($type=="event") {
            $bashPath = "images/performers/event/";
            
        }else
            {$bashPath = "images/performers/index/";}

        $img = $link_dash . $suffix;
        if (file_exists("public/" .$bashPath. $img))
        {
            return $bashPath.$img;
        }
        else
        {
            return $bashPath . $num. $suffix;
        }
    }

}
