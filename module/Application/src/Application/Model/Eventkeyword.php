<?php

namespace Application\Model;

class Eventkeyword {

    /**
     * Event ID
     *
     * @var int
     */
    private $_event_id;

    /**
     * Event keyword
     *
     * @var string
     */
    private $_keywords;
    private $event;

    public function exchangeArray($data) {
        $this->_event_id = (!empty($data['ek_event_id'])) ? $data['ek_event_id'] : null;
        $this->_keywords = (!empty($data['ek_keywords'])) ? $data['ek_keywords'] : null;

        if ((!empty($data['event_id']))) {
            $this->event = new Events();
            $this->event->exchangeArray($data);
        }
    }

    public function getEvent() {
        return $this->event;
    }

    public function setEvent($event) {
        $this->event = $event;
        return $this;
    }

    /**
     * Get event ID
     *
     * @return int
     */
    public function get_event_id() {
        return $this->_event_id;
    }

    /**
     * Get event keywords
     *
     * @return string
     */
    public function get_keywords() {
        return $this->_keywords;
    }

    /**
     * Set Event ID
     *
     * @param int $_event_id
     * 
     */
    public function set_event_id($_event_id) {
        $this->_event_id = $_event_id;
    }

    /**
     * Set Event Keyword
     *
     * @param string $_keywords
     * 
     */
    public function set_keywords($_keywords) {
        $this->_keywords = $_keywords;
    }

}
