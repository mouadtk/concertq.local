<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class LocationTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->limit(20);
        }
        );
        //var_dump($resultSet);
        return $resultSet;
    }

    public function getZipCode($ip) {

        $rowset = $this->tableGateway->select(function (Select $select) use($ip) {
            $select
                    ->limit(1)
                    ->order(array('geolocation_ip_group' => 'DESC'))
            ->Where->lessThanOrEqualTo('geolocation_ip_group', $ip)

            //->limit(10)
            ;
        });



        //var_dump($rowset);
        $row = $rowset->current();
        return $row;
    }

}
