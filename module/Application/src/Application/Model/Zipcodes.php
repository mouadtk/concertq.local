<?php

namespace Application\Model;

class Zipcodes {

    /**
     * Zipcode
     *
     * @var string
     */
    private $zipcode;

    /**
     * zipcode_latitude
     *
     * @var int
     */
    private $_latitude;

    /**
     * zipcode_longitude
     *
     * @var int
     */
    private $_longitude;

    /**
     * Get Zipcode
     *
     * @param string $zipcode
     * @return Zipcodes
     */
    public function getZipcode() {
        return $this->zipcode;
    }

    /**
     * Get Latitude
     *
     * @param int $_latitude
     * @return Zipcodes
     */
    public function get_latitude() {
        return $this->_latitude;
    }

    /**
     * Get Longitude
     *
     * @param int $_longitude
     * @return Zipcodes
     */
    public function get_longitude() {
        return $this->_longitude;
    }

    /**
     * Set Zipcode
     *
     * @param string $zipcode
     * @return Zipcodes
     */
    public function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    /**
     * Set Latitude
     *
     * @param int $_latitude
     * @return Zipcodes
     */
    public function set_latitude($_latitude) {
        $this->_latitude = $_latitude;
    }

    /**
     * Set longitude
     *
     * @param int $_longitude
     * @return Zipcodes
     */
    public function set_longitude($_longitude) {
        $this->_longitude = $_longitude;
    }

    public function exchangeArray($data) {
        $this->zipcode = (isset($data['zipcode'])) ? $data['zipcode'] : null;
        $this->_latitude = (isset($data['zipcode_latitude'])) ? $data['zipcode_latitude'] : null;
        $this->_longitude = (isset($data['zipcode_longitude'])) ? $data['zipcode_longitude'] : null;
    }

}
