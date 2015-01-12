<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use \Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;

class EventkeywordTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

// cette fonction doit etre modifier selon  la logique de la table 
    public function getEventKeyword($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('ek_event_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function searchBy($keywords, $count = false, $offset = 0, $limit = 20, $cat_id = 2) {
        $keywords = (string) $keywords;
        $offset = (int) $offset;
        $limit = (int) $limit;
        $rowset = $this->tableGateway->select(function(Select $select) use ($keywords, $count, $offset, $limit, $cat_id) {
            if ($count === true) {
                $select->columns(array('ek_event_id' => new Expression('COUNT(*)')));
            }
            $select
                    ->join(array('e' => 'm_events'), // join table with alias
                            'ek_event_id = e.event_id')
                    ->join(array('cat' => 'm_categories'), // join table with alias
                            'event_category_id = category_id')
                    ->join(array('performers' => 'm_performers'), // join table with alias
                            'event_host_id = performers.performer_id')
                    ->join(array('venues' => 'm_venues'), // join table with alias
                            'event_venue_id = venues.venue_id')
                    ->join(array('city' => 'm_cities'), // join table with alias
                            'city.city_id = venues.venue_city_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'city_country_id = country_id')
                    ->join(array('state' => 'm_states'), // join table with alias
                            'state.state_id = city.city_state_id')
                    ->where('MATCH (ek_keywords) AGAINST ("' . $keywords . '" IN BOOLEAN MODE)')
                    ->order('event_date ASC')
            ->where->greaterThanOrEqualTo(
                    'event_date', date('Y-m-d'))
            ->and->equalTo('category_parent_id', $cat_id)
            ;
            if ($count === false) {
                $select->limit($limit)
                        ->offset($offset);
            }
        });
        return $rowset;
    }

    public function getEventsbyKeyword($keyword) {

        $cat_id = 2;
        $rowset = $this->tableGateway->select(function (Select $select) use($cat_id, $keyword) {


            $select
                    //->from(array('events' => 'm_events'))  // base table
                    ->join(array('events' => 'm_events'), // join table with alias
                            'ek_event_id = events.event_id')
                    ->join(array('venues' => 'm_venues'), // join table with alias
                            'venues.venue_id = events.event_venue_id')
                    ->join(array('city' => 'm_cities'), // join table with alias
                            'venues.venue_city_id = city.city_id')
                    ->join(array('states' => 'm_states'), // join table with alias
                            'city.city_state_id = states.state_id')
                    ->where(array('events.event_category_id' => $cat_id))
                    ->where->like('ek_keywords', '%' . $keyword . '%')
                    ->limit(200)
            //->limit(10)
            ;
        });
        //var_dump($rowset);

        return $rowset;
    }

}
