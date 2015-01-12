<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class CitiesTable extends AbstractTableGateway {

    protected $tableGateway;
    protected $table = 'cities';

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCitiesbyID($_id) {
        $_id = (int) $_id;
        $rowset = $this->tableGateway->select(array('city_id' => $_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $_id");
        }

        return $row;
    }

    public function getCityByDash($name_dash = null) {
        $rowset = $this->tableGateway->select(function (Select $select) use ($name_dash) {
            $select
                    ->where(array('city_link_dash' => $name_dash))

            ;
        });
        $rowset->buffer();

        return $rowset;
    }
    
    public function getCityByDashForward($name_dash) {
        $rowset = $this->tableGateway->select(function (Select $select) use ($name_dash) {
            $select
                    ->where(array('city_link_dash' => $name_dash))
            ;
        });
        if($rowset->count()==0){
            return false;
        }
        $rowset->current();

        return $rowset;
    }

    public function getCitiesbyName($_name) {
        $_name = (string) $_name;
        $rowset = $this->tableGateway->select(array('city_name' => $_name));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $_name");
        }

        return $row;
    }

    public function getCitiesbyLink($_link) {
        $_link = (string) $_link;
        $rowset = $this->tableGateway->select(array('city_link_dash' => $_link));
        $row = $rowset->current();
       

        return $row;
    }

    public function getTopCities($NbCities) {


        $rowset = $this->tableGateway->select(function (Select $select) use ($NbCities) {
            $where = new Where();
            $where->notEqualTo('city_rank', 'NULL');

            $select
                    ->where($where)
                    ->limit($NbCities)
                    ->order(array('city_rank' => 'ASC'))
            ;
        });

        return $rowset;
    }

}
