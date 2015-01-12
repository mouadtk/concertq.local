<?php

namespace Application\Model;

use Application\Model\States;

class Cities {

    /**
     * City ID
     *
     * @var int
     */
    private $_id;

    /**
     * City Name
     *
     * @var string
     */
    private $_name;

    /**
     * City Link Underscore
     *
     * @var string
     */
    private $_link_underscore;

    /**
     * City Link Dash
     *
     * @var string
     */
    private $_link_dash;

    /**
     * City Abbreviation
     *
     * @var string
     */
    private $_abbreviation;

    /**
     * City Latitude
     *
     * @var int
     */
    private $_latitude;

    /**
     * City Longitude
     *
     * @var int
     */
    private $_longitude;

    /**
     * City State ID
     *
     * @var int
     */
    private $_state_id;

    /**
     * City Country ID
     *
     * @var int
     */
    private $_country_id;

    /**
     * City Rank
     *
     * @var int
     */
    private $_rank;
    
    /******************* get set *****************************/

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

    public function get_abbreviation() {
        return $this->_abbreviation;
    }

    public function get_latitude() {
        return $this->_latitude;
    }

    public function get_longitude() {
        return $this->_longitude;
    }

    public function get_state_id() {
        return $this->_state_id;
    }

    public function get_country_id() {
        return $this->_country_id;
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

    public function set_abbreviation($_abbreviation) {
        $this->_abbreviation = $_abbreviation;
        return $this;
    }

    public function set_latitude($_latitude) {
        $this->_latitude = $_latitude;
        return $this;
    }

    public function set_longitude($_longitude) {
        $this->_longitude = $_longitude;
        return $this;
    }

    public function set_state_id($_state_id) {
        $this->_state_id = $_state_id;
        return $this;
    }

    public function set_country_id($_country_id) {
        $this->_country_id = $_country_id;
        return $this;
    }

        
    /************************************************************************/
    private $_city_state;
    private $_city_country;

    public function exchangeArray($data) {

        

        $this->_id = (isset($data['city_id'])) ? $data['city_id'] : null;
        $this->_name = (isset($data['city_name'])) ? $data['city_name'] : null;
        $this->_link_underscore = (isset($data['city_link_underscore'])) ? $data['city_link_underscore'] : null;
        $this->_link_dash = (isset($data['city_link_dash'])) ? $data['city_link_dash'] : null;
        $this->_abbreviation = (isset($data['city_abbreviation'])) ? $data['city_abbreviation'] : null;
        $this->_latitude = (isset($data['city_latitude'])) ? $data['city_latitude'] : null;
        $this->_longitude = (isset($data['city_longitude'])) ? $data['city_longitude'] : null;
        $this->_state_id = (isset($data['city_state_id'])) ? $data['city_state_id'] : null;
        $this->_country_id = (isset($data['city_country_id'])) ? $data['city_country_id'] : null;
        $this->_rank = (isset($data['city_rank'])) ? $data['city_rank'] : null;
        
        
        if (!empty($data['state_id'])) {
            $this->_city_state = new States();
            $this->_city_state->exchangeArray($data);
            $this->_state_id =$this->_city_state;
        }

        if (!empty($data['country_id'])) {
            $this->_city_country = new Countries();
            $this->_city_country->exchangeArray($data);
            $this->_country_id=$this->_city_country;
        }
    }

    /**
     * Set City Rank
     *
     * @param int $_rank
     * @return Cities
     */
    public function set_rank($_rank) {
        $this->_rank = $_rank;
    }

    public function getCountry() {
        return $this->_city_country;
    }

    public function setCountry($city_country) {
        $this->_city_country = $city_country;
        return $this;
    }

    public function getState() {
        return $this->_city_state;
    }

    public function setState($_city_state) {
        $this->_city_state = $_city_state;
        return $this;
    }

}
