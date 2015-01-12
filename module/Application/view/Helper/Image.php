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

namespace view\Helper;

use Zend\View\Helper\AbstractHelper;

class ImageHelper extends AbstractHelper {

    public function __invoke($performer_link_dash) {

        $suffix = "-concert-tickets.jpg";
        $prefix="a";
        $img = "images/" . $performer_link_dash . $suffix;
        
        echo $img;
        
        if (file_exists("public/".$img))
            return $img;
        else
            return "images/".$prefix.$suffix;
    }

}
