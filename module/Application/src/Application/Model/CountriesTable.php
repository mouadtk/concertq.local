<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class CountriesTable extends AbstractTableGateway {

    protected $tableGateway;
    protected $table = 'm_countries';

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCountriesID($_id) {
        $_id = (string) $_id;
        $rowset = $this->tableGateway->select(array('country_id' => $_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $_id");
        }

        return $row;
    }

    public function getCountrybycityid($id) {

        $select = $this->tableGateway->select(array('country_id' => $_id))->join('cities', 'm_countries.country_id= m_cities.city_id');

        $where = new Where();
        $where->equalTo('city_id', $id);
        $select->where($where);
        if (!$select) {
            throw new \Exception("Could not find row $id");
        }


        return $select;
    }

}
