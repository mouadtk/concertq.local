<?php

namespace Application\Model;

use Application\Model\Performercategory;

class Performer {

    /**
     * Performer ID
     *
     * @var int
     */
    private $_id;

    /**
     * Performer name
     *
     * @var string
     */
    private $_name;

    /**
     * Performer link ( spaces replaced with underscores )
     *
     * @var string
     */
    private $_link_underscore;

    /**
     * Performer link ( spaces replaced with dashes )
     *
     * @var string
     */
    private $_link_dash;

    /**
     * Performer categories
     *
     * @var array
     */
    private $_performer_categories = array();

    /**
     * Event Performers
     * @var array 
     */
    private $_event_performers = array();

    /**
     * Events
     *
     * @var array
     */
    private $_events = array();

    //ok
    public function exchangeArray($data) {
        $this->_id = (!empty($data['performer_id'])) ? $data['performer_id'] : null;
        $this->_name = (!empty($data['performer_name'])) ? $data['performer_name'] : null;
        $this->_link_underscore = (!empty($data['performer_link_underscore'])) ? $data['performer_link_underscore'] : null;
        $this->_link_dash = (!empty($data['performer_link_dash'])) ? $data['performer_link_dash'] : null;

        if ((!empty($data['pc_performer_id']))) {
            $performer_categorie = new Performercategory();
            $performer_categorie->exchangeArray($data);
            $this->_performer_categories[] = $performer_categorie;
        }
    }

    public function inTopRank() {
        return array_key_exists(
                $this->_link_dash, \Application\Plugins\RealContent::$performerContent);
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function get_id() {
        return (int) $this->_id;
    }

    /**
     * Set ID
     *
     * @param int $_id
     * @return Application_Model_Performer
     */
    public function set_id($_id) {
        $this->_id = (int) $_id;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function get_name() {
        return (string) $this->_name;
    }

    /**
     * Set name
     *
     * @param string $_name
     *
     */
    public function set_name($_name) {
        $this->_name = (string) $_name;
        return $this;
    }

    /**
     * Get link underscore
     *
     * @return string
     */
    public function get_link_underscore() {
        return (string) $this->_link_underscore;
    }

    /**
     * Set link underscore
     *
     * @param string $_link_underscore
     * 
     */
    public function set_link_underscore($_link_underscore) {
        $this->_link_underscore = (string) $_link_underscore;
        return $this;
    }

    /**
     * Get link dash
     *
     * @return string
     */
    public function get_link_dash() {
        return (string) $this->_link_dash;
    }

    /**
     * Set link dash
     *
     * @param string $_link_dash
     * 
     */
    public function set_link_dash($_link_dash) {
        $this->_link_dash = (string) $_link_dash;
        return $this;
    }

    public function get_performer_categories() {

        return (array) $this->_performer_categories;
    }

    public function set_performer_categories(array $_performer_categories) {
        $this->_performer_categories = $_performer_categories;
        return $this;
    }

    /**
     * Add a performer category to the peroformer categories
     *
     * @param Application_Model_PerformerCategory $_performer_category
     * @return Application_Model_Performer 
     */
//    public function add_performer_category(Application_Model_PerformerCategory $_performer_category) {
//        $this->_performer_categories[] = $_performer_category;
//        return $this;
//    }

    /**
     * Return a category from the performer categories array
     *
     * @param mixed $key
     * @return Application_Model_PerformerCategory
     */
    public function get_performer_category($key) {
        return $this->_performer_categories[$key];
    }

    /**
     * get event performers
     * @return array
     */
    public function get_event_performers() {
        return (array) $this->_event_performers;
    }

    /**
     * set event performers
     * @param array $_event_performers
     * @return \Application_Model_Performer
     */
    public function set_event_performers(array $_event_performers) {
        $this->_event_performers = $_event_performers;
        return $this;
    }

    /**
     * Get events
     *
     * @return array
     */
    public function get_events() {
        return (array) $this->_events;
    }

    /**
     * Set events
     *
     * @param array $_events
     * @return Application_Model_Performer
     */
    public function set_events(array $_events) {
        $this->_events = $_events;
        return $this;
    }

    public function get_rank($categorie_id = 0) {
        return 1444;
    }

}
