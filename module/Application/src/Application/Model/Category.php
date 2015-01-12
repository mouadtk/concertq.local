<?php

namespace Application\Model;

class Category {

    /**
     * Category ID
     *
     * @var int
     */
    private $_id;

    /**
     * Category parent ID
     *
     * @var int
     */
    private $_parent_id = Array();

    /**
     * Category parent Name
     *
     * @var string
     */
    private $_parent_name;

    /**
     * Category child ID
     *
     * @var int
     */
    private $_child_id = Array();

    /**
     * Category child Name
     *
     * @var string
     */
    private $_child_name;

    /**
     * Category grandchild ID
     *
     * @var id
     */
    private $_grandchild_id = Array();

    /**
     * Category grandchild Name
     *
     * @var string
     */
    private $_grandchild_name;

    public function exchangeArray($data) {
        $this->_id = (!empty($data['category_id'])) ? $data['category_id'] : null;
        $this->_parent_id = (!empty($data['category_parent_id'])) ? $data['category_parent_id'] : null;
        $this->_parent_name = (!empty($data['category_parent_name'])) ? $data['category_parent_name'] : null;
        $this->_child_id = (!empty($data['category_child_id'])) ? $data['category_child_id'] : null;
        $this->_child_name = (!empty($data['category_child_name'])) ? $data['category_child_name'] : null;
        $this->_grandchild_id = (!empty($data['category_grandchild_id'])) ? $data['category_grandchild_id'] : null;
        $this->_grandchild_name = (!empty($data['category_grandchild_name'])) ? $data['category_grandchild_name'] : null;
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function get_id() {
        return $this->_id;
    }

    /**
     * Get category parent ID
     *
     * @return int
     */
    public function get_parent_id() {
        return $this->_parent_id;
    }

    /**
     * Get category parent Name
     *
     * @return int
     */
    public function get_parent_name() {
        return $this->_parent_name;
    }

    /**
     * Get category child ID 
     *
     * @return int
     */
    public function get_child_id() {
        return $this->_child_id;
    }

    /**
     * Get category child Name
     *
     * @return string
     */
    public function get_child_name() {
        return $this->_child_name;
    }

    /**
     * Get category grandchild ID 
     *
     * @return int
     */
    public function get_grandchild_id() {
        return $this->_grandchild_id;
    }

    /**
     * Get category grandchild Name 
     *
     * @return string
     */
    public function get_grandchild_name() {
        return $this->_grandchild_name;
    }

    /**
     * Set category  ID 
     *
     * @param int $_id
     */
    public function set_id($_id) {
        $this->_id = $_id;
    }

    /**
     * Set category parent  ID 
     *
     * @param int $_parent_id
     */
    public function set_parent_id($_parent_id) {
        $this->_parent_id = $_parent_id;
    }

    /**
     * Set category parent  Name
     *
     * @param string $_parent_name
     */
    public function set_parent_name($_parent_name) {
        $this->_parent_name = $_parent_name;
    }

    /**
     * Set category child  ID 
     *
     * @param int $_child_id
     */
    public function set_child_id($_child_id) {
        $this->_child_id = $_child_id;
    }

    /**
     * Set category child  Name 
     *
     * @param string $_child_name
     */
    public function set_child_name($_child_name) {
        $this->_child_name = $_child_name;
    }

    /**
     * Set category grandchild  ID 
     *
     * @param int $_grandchild_id
     */
    public function set_grandchild_id($_grandchild_id) {
        $this->_grandchild_id = $_grandchild_id;
    }

    /**
     * Set category grandchild  Name
     *
     * @param string $_grandchild_name
     */
    public function set_grandchild_name($_grandchild_name) {
        $this->_grandchild_name = $_grandchild_name;
    }

}
