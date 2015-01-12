<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

/**
 * Description of VenuesTable
 *
 * @author ahmed
 */
class VenuesTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getVenues($_venue_id) {
        $_venue_id = (int) $_venue_id;
        $rowset = $this->tableGateway->select(array('venue_id', $_venue_id));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find row $_venue_id");
        }
        return $row;
    }

    /*     * *****************  Geo  ******************** */

    public function getZipCity($ziplat, $ziplon, $lat, $lat1, $lon, $lon1) {
        $exp = '3956 * 2 * ASIN(SQRT( POWER(SIN((' . $ziplat . '- zipcode.zipcode_latitude) * pi()/180 / 2), 2) +COS(' . $ziplat . ' * pi()/180) * COS(zipcode.zipcode_latitude * pi()/180) *POWER(SIN((' . $ziplon . '- zipcode.zipcode_longitude) * pi()/180 / 2), 2) ))';

        $having = new \Zend\Db\Sql\Having();
        $having->expression('dist < ?', 150);
        $resultSet = $this->tableGateway->select(function (Select $select) use($exp, $having, $lat, $lat1, $lon, $lon1) {
            $select->columns(array('venue_city_id' => new Expression('DISTINCT(venue_city_id)'), 'dist' => new Expression($exp)));
            $select->join(array('zipcode' => 'm_zipcodes'), // join table with alias
                    'venue_zipcode = zipcode.zipcode');
            $select->where->between("zipcode.zipcode_latitude", $lat, $lat1);
            $select->where->and->between("zipcode.zipcode_longitude", $lon, $lon1);

            $select->having($having);
            $select->group('venue_city_id')
            ;
        });

        return $resultSet;
    }

    public function getVenuesbyCityId($_city_id) {
        $_city_id = (int) $_city_id;
        //$rowset = $this->tableGateway->select(array('venue_city_id' => $_city_id))->limit(200);
        //array('venue_city_id' => $_city_id)
        $rowset = $this->tableGateway->select(function (Select $select) use($_city_id) {
            $select->where(array('venue_city_id' => $_city_id))->limit(200);
        });

        if (!$rowset) {
            throw new \Exception("Could not find row $_city_id");
        }
        $t = array();
        foreach ($rowset as $value) {
            //array_push($t,$value->getVenueCity());
            $t[] = $value->getVenueId();
        }


        return $t;
    }
    
    public function getVenuesbyLink($_link) {
        $_link = (string) $_link;
        $rowset = $this->tableGateway->select(array('venue_link_dash' => $_link));
        $row = $rowset->current();
       

        return $row;
    }

}
