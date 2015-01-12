<?php

namespace Application\Model;

class Eventperformer {

    /**
     * Event ID
     *
     * @var int
     */
    private $_event_id;

    /**
     * Performer Info
     *
     * @var int
     */
    private $_performer_id = Array();

    public function exchangeArray($data) {
        $this->_event_id = (!empty($data['ep_event_id'])) ? $data['ep_event_id'] : null;
        $this->_performer_id = (!empty($data['ep_performer_id'])) ? $data['ep_performer_id'] : null;
    }

    /**
     * Get Event ID
     *
     * @return int
     */
    public function get_event_id() {
        return $this->_event_id;
    }

    /**
     * Get Performer ID
     *
     * @return int
     */
    public function get_performer_id() {
        return $this->_performer_id;
    }

    /**
     * Set Event id
     *
     * @param int $_event_id
     * 
     */
    public function set_event_id($_event_id) {
        $this->_event_id = $_event_id;
    }

    /**
     * Set Performer id
     *
     * @param int $_performer_id
     * 
     */
    public function set_performer_id($_performer_id) {
        $this->_performer_id = $_performer_id;
    }

}
