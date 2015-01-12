<?php

namespace Application\Model;

class Performercategory {

    /**
     * Performer  ID
     *
     * @var int
     */
    private $_performer_id;

    /**
     *  Category ID
     *
     * @var int
     */
    private $_category_id;

    /**
     * Range
     *
     * @var int
     */
    private $_cr_range_id;

    /**
     * Performer category rank
     *
     * @var int
     */
    private $_rank = Array();
    private $_performer;

    public function exchangeArray($data) {
        $this->_performer_id = (!empty($data['pc_performer_id'])) ? $data['pc_performer_id'] : null;
        $this->_category_id = (!empty($data['pc_category_id'])) ? $data['pc_category_id'] : null;
        $this->_cr_range_id = (!empty($data['pc_cr_range_id'])) ? $data['pc_cr_range_id'] : null;
        $this->_rank = (!empty($data['pc_rank'])) ? $data['pc_rank'] : null;
    }

    /**
     * Get performer ID
     *
     * @return int
     */
    public function get_performer_id() {
        return $this->_performer_id;
    }

    /**
     * Get category ID
     *
     * @return int
     */
    public function get_category_id() {
        return $this->_category_id;
    }

    /**
     * Get range ID
     *
     * @return int
     */
    public function get_cr_range_id() {
        return $this->_cr_range_id;
    }

    /**
     * Get rank
     *
     * @return int
     */
    public function get_rank() {
        return $this->_rank;
    }

    /**
     * Set performer id 
     *
     * @param int $_performer_id
     * 
     */
    public function set_performer_id($_performer_id) {
        $this->_performer_id = $_performer_id;
    }

    /**
     * Set category id 
     *
     * @param int $_category_id
     * 
     */
    public function set_category_id($_category_id) {
        $this->_category_id = $_category_id;
    }

    /**
     * Set range id 
     *
     * @param int $_cr_range_id
     * 
     */
    public function set_cr_range_id($_cr_range_id) {
        $this->_cr_range_id = $_cr_range_id;
    }

    /**
     * Set rank 
     *
     * @param int $_rank
     * 
     */
    public function set_rank($_rank) {
        $this->_rank = $_rank;
    }

    public function getPerformer() {
        return $this->_performer;
    }

    public function setPerformer($performer) {
        $this->_performer = $performer;
        return $this;
    }

}
