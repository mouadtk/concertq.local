<?php

namespace Application\Model;

class States {

    /**
     * State ID
     *
     * @var int
     */
    private $_id;

    /**
     * State Name
     *
     * @var string
     */
    private $_name;

    /**
     * State Link Underscore
     *
     * @var string
     */
    private $_link_underscore;

    /**
     * State Link Dash
     *
     * @var string
     */
    private $_link_dash;

    /**
     * State Abbreviation
     *
     * @var string
     */
    private $_abbreviation;

    /**
     * State Country ID
     *
     * @var int
     */
    private $_country_id;

    /**
     * Get State ID
     *
     * @param int $_id
     * @return States
     */
    public function get_id() {
        return $this->_id;
    }

    /**
     * Get State ID
     *
     * @param string $_name
     * @return States
     */
    public function get_name() {
        return $this->_name;
    }

    /**
     * Get State Link Underscore
     *
     * @param string $_link_underscore
     * @return States
     */
    public function get_link_underscore() {
        return $this->_link_underscore;
    }

    /**
     * Get State Link Dash
     *
     * @param string $_link_dash
     * @return States
     */
    public function get_link_dash() {
        return $this->_link_dash;
    }

    /**
     * Get State Abbreviation
     *
     * @param string $_abbreviation
     * @return States
     */
    public function get_abbreviation() {
        return $this->_abbreviation;
    }

    /**
     * Get State Country ID
     *
     * @param int $_country_id
     * @return States
     */
    public function get_country_id() {
        return $this->_country_id;
    }

    /**
     * Set State ID
     *
     * @param int $_id
     * @return States
     */
    public function set_id($_id) {
        $this->_id = $_id;
    }

    /**
     * Set State Name
     *
     * @param string $_name
     * @return States
     */
    public function set_name($_name) {
        $this->_name = $_name;
    }

    /**
     * Set State Link Underscore
     *
     * @param string $_link_underscore
     * @return States
     */
    public function set_link_underscore($_link_underscore) {
        $this->_link_underscore = $_link_underscore;
    }

    /**
     * Set State Link Dash
     *
     * @param string $_link_dash
     * @return States
     */
    public function set_link_dash($_link_dash) {
        $this->_link_dash = $_link_dash;
    }

    /**
     * Set State Abbreviation
     *
     * @param string $_abbreviation
     * @return States
     */
    public function set_abbreviation($_abbreviation) {
        $this->_abbreviation = $_abbreviation;
    }

    /**
     * Set State Country ID
     *
     * @param string $_country_id
     * @return States
     */
    public function set_country_id($_country_id) {
        $this->_country_id = $_country_id;
    }

    public function exchangeArray($data) {
        $this->_id = (isset($data['state_id'])) ? $data['state_id'] : null;
        $this->_name = (isset($data['state_name'])) ? $data['state_name'] : null;
        $this->_link_underscore = (isset($data['state_link_underscore'])) ? $data['state_link_underscore'] : null;
        $this->_link_dash = (isset($data['state_link_dash'])) ? $data['state_link_dash'] : null;
        $this->_abbreviation = (isset($data['state_abbreviation'])) ? $data['state_abbreviation'] : null;
        $this->_country_id = (isset($data['state_country_id'])) ? $data['state_country_id'] : null;

        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $this->_country_id = new Countries();
            $this->_country_id->exchangeArray($data);
        }
    }

}
