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

class GenerateContent extends AbstractHelper {

    public static $CITY = 1;
    public static $PERFORMER = 1;
    public static $suffix = "-concert.txt";

    public function __invoke($link_dash, $type = "performer") {





        if ($type === "city") {
            $bashPath = "cities/";
        } else {
            $bashPath = "performers/";
        }

        $cnt = $link_dash . self::$suffix;
        $contentG = "data/" . $bashPath . $cnt;
        if (file_exists($contentG)) {
            return file_get_contents($contentG);
        }

        throw new \Exception($contentG);
    }

}
