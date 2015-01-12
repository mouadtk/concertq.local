<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoryTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

// cette fonction doit etre modifier selon  la logique de la table 
    public function getCategory($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('category_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

}
