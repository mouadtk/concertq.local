<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

/**
 * Description of Maps
 *
 * @author ahmed
 */
class Maps {

    /**
     * Maps Id
     * @var integer
     */
    private $_mapId;

    /**
     * Maps URL 
     * @var string
     *
     */
    private $_mapUrl;

    /**
     * Maps Interactive
     * @var string
     *
     */
    private $_mapInteractiveUrl;

    /**
     * Maps Path
     * @var string
     * 
     */
    private $_mapPath;

    public function exchangeArray($data) {
        $this->_mapId = (!empty($data['map_id'])) ? $data['map_id'] : null;
        $this->_mapUrl = (!empty($data['map_url'])) ? $data['map_url'] : null;
        $this->_mapInteractiveUrl = (!empty($data['map_interactive_url'])) ? $data['map_interactive_url'] : null;
        $this->_mapPath = (!empty($data['map_path'])) ? $data['map_path'] : null;
    }

    public function getMapId() {
        return $this->_mapId;
    }

    public function getMapUrl() {
        if (!preg_match('#' . preg_quote($this->_mapPath) . '/#i', $this->_mapUrl)) {
            $this->_mapUrl = $this->_mapPath . '/' . $this->_mapUrl;
        }
        return $this->_mapUrl;
    }

    public function getMapInteractiveUrl() {
        if (!preg_match('#' . preg_quote($this->_mapPath) . '/#i', $this->_mapInteractiveUrl)) {
            $this->_mapInteractiveUrl = $this->_mapPath . '/' . $this->_mapInteractiveUrl;
        }
        return $this->_mapInteractiveUrl;
    }

    public function getMapPath() {
        return $this->_mapPath;
    }

    public function setMapId($_mapId) {
        $this->_mapId = $_mapId;
    }

    public function setMapUrl($_mapUrl) {
        $this->_mapUrl = $_mapUrl;
    }

    public function setMapInteractiveUrl($_mapInteractiveUrl) {
        $this->_mapInteractiveUrl = $_mapInteractiveUrl;
    }

    public function setMapPath($_mapPath) {
        $this->_mapPath = $_mapPath;
    }

}
