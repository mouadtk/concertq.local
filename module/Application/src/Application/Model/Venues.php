<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Application\Model\Cities;
use Application\Model\Zipcodes;

/**
 * Description of Venues
 *
 * @author ahmed
 */
class Venues {

    /**
     * Venue Id
     * @var integer
     *
     */
    private $_id;

    /**
     * Venue Name
     * @var string
     *
     */
    private $_name;

    /**
     * Venue Link Underscore
     * @var string
     *
     */
    private $_link_underscore;

    /**
     * Venue Link Dash
     * @var string
     *
     */
    private $_link_dash;

    /**
     * Venue Address
     * @var string
     *
     */
    private $_address;

    /**
     * Venue Rank
     * @var integer
     *
     */
    private $_rank;

    /**
     * Venue City
     * @var \Cities
     *
     */
    private $_city;

    /**
     * Venue Zipcode
     * @var \Zipcodes
     *
     */
    private $_zipcode;

    public function exchangeArray($data) {
        $this->_id = (!empty($data['venue_id'])) ? $data['venue_id'] : null;
        $this->_name = (!empty($data['venue_name'])) ? $data['venue_name'] : null;
        $this->_link_underscore = (!empty($data['venue_link_underscore'])) ? $data['venue_link_underscore'] : null;
        $this->_link_dash = (!empty($data['venue_link_dash'])) ? $data['venue_link_dash'] : null;
        $this->_address = (!empty($data['venue_address'])) ? $data['venue_address'] : null;
        $this->_rank = (!empty($data['venue_rank'])) ? $data['venue_rank'] : null;

        $this->_zipcode = (!empty($data['venue_zipcode'])) ? $data['venue_zipcode'] : null;
        $this->_city = (!empty($data['venue_city_id'])) ? $data['venue_city_id'] : null;


        if (isset($data['city_id'])) {
            $this->_city = new Cities();
            $this->_city->exchangeArray($data);
        }
        if (isset($data['zipcode'])) {
            $this->_zipcode = new Zipcodes();
            $this->_zipcode->exchangeArray($data);
        }
    }

    public function getCity() {
        return $this->_city;
    }

    public function getZipcode() {
        return $this->_zipcode;
    }

    public function setCity($_venue_city) {
        $this->_city = $_venue_city;
        return $this;
    }

    public function setZipcode($_venue_zipcode) {
        $this->_zipcode = $_venue_zipcode;
        return $this;
    }

    public function get_id() {
        return $this->_id;
    }

    public function get_name() {
        return $this->_name;
    }

    public function get_link_underscore() {
        return $this->_link_underscore;
    }

    public function get_link_dash() {
        return $this->_link_dash;
    }

    public function get_address() {
        return $this->_address;
    }

    public function get_rank() {
        return $this->_rank;
    }

    public function set_id($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function set_name($_name) {
        $this->_name = $_name;
        return $this;
    }

    public function set_link_underscore($_link_underscore) {
        $this->_link_underscore = $_link_underscore;
        return $this;
    }

    public function set_link_dash($_link_dash) {
        $this->_link_dash = $_link_dash;
        return $this;
    }

    public function set_address($_address) {
        $this->_address = $_address;
        return $this;
    }

    public function set_rank($_rank) {
        $this->_rank = $_rank;
        return $this;
    }

}
