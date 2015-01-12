<?php

namespace Application\Model;

class Ticket {

    /**
     * Ticket ID
     *
     * @var int
     */
    private $_event_id;

    /**
     * Ticket Info
     *
     * @var string
     */
    private $_info = Array();

    /**
     * Ticket minimum price
     *
     * @var float
     */
    private $_min_price;

    /**
     * Ticket maximum price
     *
     * @var float
     */
    private $_max_price = Array();

    /**
     * Ticket count
     *
     * @var int
     */
    private $_count;

    /**
     * Ticket notes
     *
     * @var string
     */
    private $_event_notes = Array();

    /**
     * Ticket insert time 
     *
     * @var timestamp
     */
    private $_insert_time;

    public function exchangeArray($data) {
        $this->_event_id = (!empty($data['ticket_event_id'])) ? $data['ticket_event_id'] : null;
        $this->_info = (!empty($data['ticket_info'])) ? $data['ticket_info'] : null;
        $this->_min_price = (!empty($data['ticket_min_price'])) ? $data['ticket_min_price'] : null;
        $this->_max_price = (!empty($data['ticket_max_price'])) ? $data['ticket_max_price'] : null;
        $this->_count = (!empty($data['ticket_count'])) ? $data['ticket_count'] : null;
        $this->_event_notes = (!empty($data['ticket_event_notes'])) ? $data['ticket_event_notes'] : null;
        $this->_insert_time = (!empty($data['ticket_insert_time'])) ? $data['ticket_insert_time'] : null;

        if (!empty($data['ticket_event_id'])) {
            $this->_event_id = new Events();
            $this->_event_id->exchangeArray($data);
        }
    }

    /**
     * Get ticket ID
     *
     * @return int
     */
    public function get_event_id() {
        return $this->_event_id;
    }

    /**
     * Get ticket Info
     *
     * @return string
     */
    public function get_info() {
        return $this->_info;
    }

    /**
     * Get ticket minimum price
     *
     * @return float
     */
    public function get_min_price() {
        return $this->_min_price;
    }

    /**
     * Get ticket maximum price
     *
     * @return float
     */
    public function get_max_price() {
        return $this->_max_price;
    }

    /**
     * Get ticket count
     *
     * @return int
     */
    public function get_count() {
        return $this->_count;
    }

    /**
     * Get ticket event notes
     *
     * @return string
     */
    public function get_event_notes() {
        return $this->_event_notes;
    }

    /**
     * Get ticket insertion time
     *
     * @return timestamp
     */
    public function get_insert_time() {
        return $this->_insert_time;
    }

    /**
     * Set ticket ID
     *
     * @param int $_event_id
     */
    public function set_event_id($_event_id) {
        $this->_event_id = $_event_id;
    }

    /**
     * Set ticket Info
     *
     * @param string $_info
     */
    public function set_info($_info) {
        $this->_info = $_info;
    }

    /**
     * Set ticket minimum price
     *
     * @param float $_min_price
     */
    public function set_min_price($_min_price) {
        $this->_min_price = $_min_price;
    }

    /**
     * Set ticket maximum price
     *
     * @param float $_max_price
     */
    public function set_max_price($_max_price) {
        $this->_max_price = $_max_price;
    }

    /**
     * Set ticket count
     *
     * @param int $_count
     */
    public function set_count($_count) {
        $this->_count = $_count;
    }

    /**
     * Set ticket event notes
     *
     * @param string $_event_notes
     */
    public function set_event_notes($_event_notes) {
        $this->_event_notes = $_event_notes;
    }

    /**
     * Set ticket insert time
     *
     * @param timestamp $_insert_time
     */
    public function set_insert_time($_insert_time) {
        $this->_insert_time = $_insert_time;
    }

}
