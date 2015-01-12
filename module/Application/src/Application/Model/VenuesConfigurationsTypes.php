<?php

namespace Application\Model;

class VenuesConfigurationsTypes {

    /**
     * VCT ID
     *
     * @var int
     */
    private $_id;

    /**
     * VCT Name
     *
     * @var string
     */
    private $_name;

    /**
     * Get VCT ID
     *
     * @param int $_id
     * @return VenuesConfigurationsTypes
     */
    public function get_id() {
        return $this->_id;
    }

    /**
     * Get VCT Name
     *
     * @param string $_name
     * @return VenuesConfigurationsTypes
     */
    public function get_name() {
        return $this->_name;
    }

    /**
     * Set VCT ID
     *
     * @param int $_id
     * @return VenuesConfigurationsTypes
     */
    public function set_id($_id) {
        $this->_id = $_id;
    }

    /**
     * Get VCT Name
     *
     * @param string $_name
     * @return VenuesConfigurationsTypes
     */
    public function set_name($_name) {
        $this->_name = $_name;
    }

    public function exchangeArray($data) {
        $this->_id = (isset($data['vct_id'])) ? $data['vct_id'] : null;
        $this->_name = (isset($data['vct_name'])) ? $data['vct_name'] : null;
    }

}
