<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class TicketTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getTicket($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('ticket_event_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getTicketsByEvent($eventID) {


        $rowset = $this->tableGateway->select(function (Select $select) use($eventID) {

            $where = new Where();
            $where->equalTo('events.event_id', $eventID);

            $select

                    //->from(array('events' => 'm_events'))  // base table
                    ->join(array('events' => 'm_events'), // join table with alias
                            'ticket_event_id = events.event_id')
                    ->join(array('venues' => 'm_venues'), // join table with alias
                            'events.event_venue_id = venues.venue_id')
                    ->join(array('cities' => 'm_cities'), // join table with alias
                            'cities.city_id = venues.venue_city_id')
                    ->join(array('states' => 'm_states'), // join table with alias
                            'states.state_id = cities.city_state_id')
                    ->where($where);
        });


        return $rowset->current();
    }

}
