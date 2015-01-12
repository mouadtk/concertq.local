<?php

namespace Application\Model;

class Location {

    /**
     * ip group
     *
     * @var int
     */
    private $_ipgroup;

    /**
     * zip code ip
     *
     * @var string
     */
    private $_zipcodeip;

    public function exchangeArray($data) {
        $this->_ipgroup = (isset($data['geolocation_ip_group'])) ? $data['geolocation_ip_group'] : null;
        $this->_zipcodeip = (isset($data['geolocation_zipcode'])) ? $data['geolocation_zipcode'] : null;
    }

    public function get_ipgroup() {
        return $this->_ipgroup;
    }

    public function get_zipcodeip() {
        return $this->_zipcodeip;
    }

    public function set_ipgroup($_ipgroup) {
        $this->_ipgroup = $_ipgroup;
    }

    public function set_zipcodeip($_zipcodeip) {
        $this->_zipcodeip = $_zipcodeip;
    }

}
