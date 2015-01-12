<?php

namespace Application\Model;

class Countries {

    /**
     * Country ID
     *
     * @var int
     */
    private $_id;

    /**
     * Country Name
     *
     * @var string
     */
    private $_name;

    /**
     * Country Abbreviation
     *
     * @var string
     */
    private $_abbreviation;

    /**
     * Get Country ID
     *
     * @param int $_id
     * @return Countries
     */
    public function get_id() {
        return $this->_id;
    }

    /**
     * Get Country name
     *
     * @param string $_name
     * @return Countries
     */
    public function get_name() {
        return $this->_name;
    }

    /**
     * Get Country Abbreviation
     *
     * @param string $_abbreviation
     * @return Countries
     */
    public function get_abbreviation() {
        return $this->_abbreviation;
    }

    /**
     * Set Country ID
     *
     * @param int $_id
     * @return Countries
     */
    public function set_id($_id) {
        $this->_id = $_id;
    }

    /**
     * Set Country name
     *
     * @param int $_name
     * @return Countries
     */
    public function set_name($_name) {
        $this->_name = $_name;
    }

    /**
     * Set Country Abbreviation
     *
     * @param int $_abbreviation
     * @return Countries
     */
    public function set_abbreviation($_abbreviation) {
        $this->_abbreviation = $_abbreviation;
    }

    public function exchangeArray($data) {
        $this->_id = (isset($data['country_id'])) ? $data['country_id'] : null;
        $this->_name = (isset($data['country_name'])) ? $data['country_name'] : null;
        $this->_abbreviation = (isset($data['country_abbreviation'])) ? $data['country_abbreviation'] : null;
    }

}
