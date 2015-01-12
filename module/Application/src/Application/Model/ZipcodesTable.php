<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;

class ZipcodesTable extends AbstractTableGateway {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getZipcodes($zipcode) {
        $zipcode = (string) $zipcode;
        $rowset = $this->tableGateway->select(array('zipcode' => $zipcode));
        $row = $rowset->current();

        return $row;
    }

}
