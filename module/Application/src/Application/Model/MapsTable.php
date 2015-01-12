<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

/**
 * Description of MapsTable
 *
 * @author ahmed
 */
class MapsTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getMaps($_map_id) {
        $_map_id = (int) $_map_id;
        $rowset = $this->tableGateway->select(array('map_id', $_map_id));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find row $_map_id");
        }
    }

}
