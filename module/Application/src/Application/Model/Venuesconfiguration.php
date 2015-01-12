<?php

namespace Application\Model;

class Venuesconfiguration {

    /**
     * Venue configuration ID
     *
     * @var int
     */
    private $_id;

    /**
     * Venue ID
     *
     * @var int
     */
    private $_venue_id = Array();

    /**
     * vct ID
     *
     * @var int
     */
    private $_vct_id;

    /**
     * map ID
     *
     * @var int
     */
    private $_map_id = Array();

    public function exchangeArray($data) {
        $this->_id = (!empty($data['vc_id'])) ? $data['vc_id'] : null;
        $this->_venue_id = (!empty($data['vc_venue_id'])) ? $data['vc_venue_id'] : null;
        $this->_vct_id = (!empty($data['vc_vct_id'])) ? $data['vc_vct_id'] : null;
        $this->_map_id = (!empty($data['vc_map_id'])) ? $data['vc_map_id'] : null;
    }

    /**
     * Get Configuration ID
     *
     * @return int
     */
    public function get_id() {
        return $this->_id;
    }

    /**
     * Get venue ID
     *
     * @return int
     */
    public function get_venue_id() {
        return $this->_venue_id;
    }

    /**
     * Get vct ID
     *
     * @return int
     */
    public function get_vct_id() {
        return $this->_vct_id;
    }

    /**
     * Get map ID
     *
     * @return int
     */
    public function get_map_id() {
        return $this->_map_id;
    }

    /**
     * Set configuration ID
     *
     * @param int $_id
     * 
     */
    public function set_id($_id) {
        $this->_id = $_id;
    }

    /**
     * Set venue ID
     *
     * @param int $_venue_id
     * 
     */
    public function set_venue_id($_venue_id) {
        $this->_venue_id = $_venue_id;
    }

    /**
     * Set vct ID
     *
     * @param int $_vct_id
     * 
     */
    public function set_vct_id($_vct_id) {
        $this->_vct_id = $_vct_id;
    }

    /**
     * Set map ID
     *
     * @param int $_map_id
     * 
     */
    public function set_map_id($_map_id) {
        $this->_map_id = $_map_id;
    }

}
