<?php

namespace Application\Model;

use Application\Model\Venues;

/**
 * Description of Events
 *
 * @author ahmed
 */
class Events {

    private $_id;
    private $_name;
    private $_date;
    private $_time;
    private $_insert_time = 'CURRENT_TIMESTAMP';
    private $_vc_id;
    //***Dependencies***/
    //Venue
    private $_venue;
    private $_venue_id;
    //Host
    private $_host;
    private $_host_id;
    //Map
    private $_map;
    private $_map_id;
    //Category
    private $_category;
    private $_category_id;

    private function dependency($data) {
        if (!empty($data['venue_id'])) {
            $this->_venue = new Venues;
            $this->_venue->exchangeArray($data);
            $this->_venue_id = $this->_venue;
        }
        if ((!empty($data['performer_id']))) {
            $this->_host = new Performer();
            $this->_host->exchangeArray($data);
            $this->_host_id = $this->_host;
        }
        if (!empty($data['category_id'])) {
            $this->_category_id = new Category;
            $this->_category_id->exchangeArray($data);
            $this->_category = $this->_category_id;
        }
        if (!empty($data['map_id'])) {
            $this->_map_id = new Maps();
            $this->_map_id->exchangeArray($data);
            $this->_map = $this->_map_id;
        }
    }

    public function exchangeArray($data) {

        $this->_id = (!empty($data['event_id'])) ? $data['event_id'] : null;
        $this->_name = (!empty($data['event_name'])) ? $data['event_name'] : null;
        $this->_date = (!empty($data['event_date'])) ? new \DateTime($data['event_date']) : null;
        $this->_time = (!empty($data['event_time'])) ? new \DateTime($data['event_time']) : null;
        $this->_insert_time = (!empty($data['event_insert_time'])) ? $data['event_insert_time'] : null;
        $this->_host_id = (!empty($data['event_host_id'])) ? $data['event_host_id'] : null;
        $this->_vc_id = (!empty($data['event_vc_id'])) ? $data['event_vc_id'] : null;
        $this->_venue_id = (!empty($data['event_venue_id'])) ? $data['event_venue_id'] : null;
        $this->_map_id = (!empty($data['event_map_id'])) ? $data['event_map_id'] : null;
        $this->_category_id = (!empty($data['event_category_id'])) ? $data['event_category_id'] : null;

        $this->dependency($data);
    }

    public function getHost() {
        return $this->_host;
    }

    public function setHost($_event_host) {
        $this->_host = $_event_host;
        return $this;
    }

    public function getVenue() {
        return $this->_venue;
    }

    public function setVenue($_venue) {
        $this->_venue = $_venue;
        return $this;
    }

    public function getMap() {
        return $this->_map;
    }

    public function setMap($map) {
        $this->_map = $map;
        return $this;
    }

    public function getCategory() {
        return $this->_category;
    }

    public function setCategory($category) {
        $this->_category = $category;
        return $this;
    }
    public function get_id() {
        return $this->_id;
    }

    public function get_name() {
        return $this->_name;
    }

    public function get_date() {
        return $this->_date;
    }

    public function get_time() {
        return $this->_time;
    }

    public function get_insert_time() {
        return $this->_insert_time;
    }

    public function get_vc_id() {
        return $this->_vc_id;
    }

    public function set_id($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function set_name($_name) {
        $this->_name = $_name;
        return $this;
    }

    public function set_date($_date) {
        $this->_date = $_date;
        return $this;
    }

    public function set_time($_time) {
        $this->_time = $_time;
        return $this;
    }

    public function set_insert_time($_insert_time) {
        $this->_insert_time = $_insert_time;
        return $this;
    }

    public function set_vc_id($_vc_id) {
        $this->_vc_id = $_vc_id;
        return $this;
    }
}
