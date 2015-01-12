<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use \Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;

/**
 * Description of EventsTable
 *
 * @author ahmed
 */
class EventsTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    /*     * ************************ GeoLocation ********************** */

    public function getEventsGeolocation($id_perf, $id_city) {


        $rowset = $this->tableGateway->select(function (Select $select) use($id_perf, $id_city) {

//                $where= new Where();
//                $where->in('city.city_id', $CityID)
//                    ->and->equalTo('category.category_parent_id' , $cat_id)
//                    ->and->notEqualTo('mpc.pc_rank' , 'NULL');
            $select

                    //->from(array('events' => 'm_events'))  // base table
                    ->join(array('venues' => 'm_venues'), // join table with alias
                            'event_venue_id = venues.venue_id')
                    ->join(array('mep' => 'm_events_performers'), // join table with alias
                            'event_id = mep.ep_event_id')
                    ->join(array('performers' => 'm_performers'), // join table with alias
                            'mep.ep_performer_id = performers.performer_id')
//                      ->join(array('mpc' => 'm_performers_categories'), // join table with alias
//                            'performers.performer_id = mpc.pc_performer_id')
                    ->join(array('city' => 'm_cities'), // join table with alias
                            'city.city_id = venues.venue_city_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'city_country_id = country_id')
                    ->join(array('state' => 'm_states'), // join table with alias
                            'state.state_id = city.city_state_id')
//                    ->join(array('category' => 'm_categories'), // join table with alias
//                            'event_category_id = category.category_id')
//                    ->join(array('p' => 'm_performers'), // join table with alias
//                            'p.performer_id = ep.ep_performer_id')
                    ->where(array('performer_id' => $id_perf, 'city_link_dash' => $id_city))
                    ->order('event_date ASC')
                    ->limit(1)

            //->group(array('event_id','performers.performer_id')) 
            //->limit(10)
            ;
        });

        return $rowset;
    }

    public function getEvents2($CityID, $offset = 0, $limit = 20) {
        $cat_id = 2;
        $rowset = $this->tableGateway->select(function (Select $select) use($cat_id, $CityID, $offset, $limit) {

            $where = new Where();
            $where->in('city.city_id', $CityID)
            ->and->equalTo('category.category_parent_id', $cat_id)
            ->and->notEqualTo('mpc.pc_rank', 'NULL');
            $select

                    //->from(array('events' => 'm_events'))  // base table
                    ->join(array('venues' => 'm_venues'), // join table with alias
                            'event_venue_id = venues.venue_id')
                    ->join(array('city' => 'm_cities'), // join table with alias
                            'city.city_id = venues.venue_city_id')
                    ->join(array('state' => 'm_states'), // join table with alias
                            'state.state_id = city.city_state_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'state.state_country_id = country.country_id')
                    ->join(array('mep' => 'm_events_performers'), // join table with alias
                            'event_id = mep.ep_event_id')
                    ->join(array('performers' => 'm_performers'), // join table with alias
                            'mep.ep_performer_id = performers.performer_id')
                    ->join(array('mpc' => 'm_performers_categories'), // join table with alias
                            'performers.performer_id = mpc.pc_performer_id')
                    ->join(array('category' => 'm_categories'), // join table with alias
                            'event_category_id = category.category_id')
//                    ->join(array('p' => 'm_performers'), // join table with alias
//                            'p.performer_id = ep.ep_performer_id')
                    ->where($where)
                    ->limit($limit)
                    ->offset($offset)
                    ->order(array('mpc.pc_rank' => 'ASC'))
                    ->group(array('event_name'))

            //->limit(10)
            ;
        });

        return $rowset;
    }

    public function getEventsFilter($CityID, $VenueID, $PerformerID, $cityidtab) {
        $indexpage = 1;
        $cat_id = 2;

        $rowset = $this->tableGateway->select(function (Select $select) use($indexpage, $cat_id, $CityID, $VenueID, $PerformerID, $cityidtab) {


            $where = new Where();

            if (!empty($CityID) && !empty($VenueID) && !empty($PerformerID)) {
                $where->in('city.city_id', $CityID);
                $where->and->in('venues.venue_id', $VenueID);
                $where->and->in('performers.performer_id', $PerformerID);
            }
            if (empty($CityID) && !empty($VenueID) && !empty($PerformerID)) {
                $where->in('venues.venue_id', $VenueID);
                $where->and->in('performers.performer_id', $PerformerID);
            }
            if (!empty($CityID) && empty($VenueID) && !empty($PerformerID)) {
                $where->in('city.city_id', $CityID);

                $where->and->in('performers.performer_id', $PerformerID);
            }
            if (!empty($CityID) && !empty($VenueID) && empty($PerformerID)) {
                $where->in('city.city_id', $CityID);
                $where->and->in('venues.venue_id', $VenueID);
            }
            if (empty($CityID) && empty($VenueID) && !empty($PerformerID)) {
                $where->in('performers.performer_id', $PerformerID);
            }
            if (empty($CityID) && !empty($VenueID) && empty($PerformerID)) {
                $where->in('venues.venue_id', $VenueID);
            }
            if (!empty($CityID) && empty($VenueID) && empty($PerformerID)) {
                $where->in('city.city_id', $CityID);
            }
            if (empty($CityID) && empty($VenueID) && empty($PerformerID)) {
                $where->in('city.city_id', $cityidtab);
                $indexpage = 0;
            }

            $where->AND->greaterThan('event_date', date('Y-m-d'));
            $where->and->equalTo('category.category_parent_id', $cat_id)
            ->and->notEqualTo('mpc.pc_rank', 'NULL');

            $select

                    //->from(array('events' => 'm_events'))  // base table
                    ->join(array('venues' => 'm_venues'), // join table with alias
                            'event_venue_id = venues.venue_id')
                    ->join(array('mep' => 'm_events_performers'), // join table with alias
                            'event_id = mep.ep_event_id')
                    ->join(array('performers' => 'm_performers'), // join table with alias
                            'mep.ep_performer_id = performers.performer_id')
                    ->join(array('mpc' => 'm_performers_categories'), // join table with alias
                            'performers.performer_id = mpc.pc_performer_id')
                    ->join(array('city' => 'm_cities'), // join table with alias
                            'city.city_id = venues.venue_city_id')
                    ->join(array('state' => 'm_states'), // join table with alias
                            'state.state_id = city.city_state_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'state.state_country_id = country.country_id')
                    ->join(array('category' => 'm_categories'), // join table with alias
                            'event_category_id = category.category_id')
//                    ->join(array('p' => 'm_performers'), // join table with alias
//                            'p.performer_id = ep.ep_performer_id')
                    ->where($where)
                    ->order(array('mpc.pc_rank' => 'ASC'))
                    ->group(array('event_id'));
            if ($indexpage == 0)
                $select->limit(20);
        });

        return $rowset;
    }

    public function getEventsByPerformerAndCity($performerdash, $citydash) {


        $rowset = $this->tableGateway->select(function (Select $select) use($performerdash, $citydash) {

            $where = new Where();
            $where->equalTo('performers.performer_link_dash', $performerdash);
            $where->AND->equalTo('cities.city_link_dash', $citydash);
            $select
                    ->join(array('tickets' => 'm_tickets'), // join table with alias
                            'tickets.ticket_event_id = event_id', array(), 'left')
                    ->join(array('ep' => 'm_events_performers'), // join table with alias
                            'ep.ep_event_id = event_id')
                    ->join(array('performers' => 'm_performers'), // join table with alias
                            'ep.ep_performer_id = performers.performer_id')
                    ->join(array('venues' => 'm_venues'), // join table with alias
                            'event_venue_id = venues.venue_id')
                    ->join(array('cities' => 'm_cities'), // join table with alias
                            'cities.city_id = venues.venue_city_id')
                    ->join(array('states' => 'm_states'), // join table with alias
                            'states.state_id = cities.city_state_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'states.state_country_id = country.country_id')
                    ->where($where)
                    ->order('event_date ASC');
        });


        return $rowset;
    }

    public function getNextEvents($performerid, $dateevent) {
        $dateevent = date('Y-m-d', strtotime($dateevent)) . ' 00:00:00';
        $cat_id = 2;
        $rowset = $this->tableGateway->select(function (Select $select) use($performerid, $dateevent, $cat_id) {

            $where = new Where();
            $where->equalTo('ep.ep_performer_id', $performerid);
            $where->AND->greaterThan('event_date', $dateevent);


            $select->columns(array(new Expression('DISTINCT(event_id),event_name,event_date,performers.performer_link_dash,cities.city_link_dash,venues.venue_name,cities.city_name,states.state_abbreviation')))
                    ->join(array('ep' => 'm_events_performers'), // join table with alias
                            'ep.ep_event_id = event_id')
                    ->join(array('category' => 'm_categories'), // join table with alias
                            'event_category_id = category.category_id')
                    ->join(array('performers' => 'm_performers'), // join table with alias
                            'event_host_id = performers.performer_id')
                    ->join(array('venues' => 'm_venues'), // join table with alias
                            'event_venue_id = venues.venue_id')
                    ->join(array('cities' => 'm_cities'), // join table with alias
                            'cities.city_id = venues.venue_city_id')
                    ->join(array('states' => 'm_states'), // join table with alias
                            'states.state_id = cities.city_state_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'states.state_country_id = country.country_id')
                    ->where($where)
                    ->order('event_date ASC')
                    ->group('event_id')
                    ->limit(3);
        });
        $rowset->buffer();
        return $rowset;
    }

    /**
     * get events by (category or performer or city or venue)
     * @param \Concertq\Model\Category $category
     * @param \Concertq\Model\Performer $performer
     * @param \Concertq\Model\City $city
     * @param \Concertq\Model\Venue $venue
     * @return rowset
     */
    public function getEvents($eventid = NULL, $category = NULL, \Application\Model\Performer $performer = NULL, $city = NULL, $venue = NULL, $plus_sql = NULL) {
        $cat_id = 2;
        $rowset = $this->tableGateway->select(function (Select $select) use($cat_id, $eventid, $category, $performer, $city, $venue, $plus_sql) {
            $where = new Where();

            //by event_id
            if (!empty($eventid)) {
                $where->equalTo('event_id', $eventid);
            } else {
                //category
                if ($category && !empty($category)) {
                    $where->equalTo('category.category_id', $category->get_id());
                } else {
                    $where->equalTo('category.category_parent_id', $cat_id);
                }
                //performer
                if ($performer && !empty($performer)) {
                    $where->and->equalTo('performers.performer_id', $performer->get_id());
                }
                //city
                if ($city && !empty($city)) {
                    $where->and->equalTo('city.city_id', $city->get_id());
                }
                //venue
                if ($venue && !empty($venue)) {
                    $where->and->equalTo('venues.venue_id', $venue->get_id());
                }
                //$where->and->notEqualTo('mpc.pc_rank', 'NULL');
                $where->and->greaterThanOrEqualTo(
                        'event_date', date('Y-m-d'));
            }
            if (!empty($plus_sql)) {
                $where->literal($plus_sql);
            }
            $select

                    //->from(array('events' => 'm_events'))  // base table
                    ->join(array('venues' => 'm_venues'), // join table with alias
                            'event_venue_id = venues.venue_id')
                    ->join(array('zipcodes' => 'm_zipcodes'), // join table with alias
                            'zipcodes.zipcode = venues.venue_zipcode')
                    ->join(array('city' => 'm_cities'), // join table with alias
                            'city.city_id = venues.venue_city_id')
                    ->join(array('state' => 'm_states'), // join table with alias
                            'state.state_id = city.city_state_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'state.state_country_id = country.country_id')
                    ->join(array('mep' => 'm_events_performers'), // join table with alias
                            'mep.ep_event_id = event_id')
                    ->join(array('performers' => 'm_performers'), // join table with alias
                            'mep.ep_performer_id = performers.performer_id')
                    ->join(array('mpc' => 'm_performers_categories'), // join table with alias
                            'performers.performer_id = mpc.pc_performer_id')
                    ->join(array('category' => 'm_categories'), // join table with alias
                            'mpc.pc_category_id = category.category_id')
                    ->join(array('maps' => 'm_maps'), // join table with alias
                            'event_map_id = maps.map_id', array('*'), 'left')
//                    ->join(array('p' => 'm_performers'), // join table with alias
//                            'p.performer_id = ep.ep_performer_id')
                    ->where($where)
                    ->limit(20)
                    ->order(array('mpc.pc_rank' => 'ASC'))
                    ->group(array('event_id'))

            //->limit(10)
            ;
        });
        $rowset->buffer();
        return $rowset;
    }

    public function getEventsByPerformerId($perf_id, $count = false) {

        $perf_id = (int) $perf_id;

        $rowset = $this->tableGateway->select(function (Select $select) use ($perf_id, $count) {
            if ($count === true) {
                $select->columns(array('event_id' => new Expression('COUNT(*)')));
            }
            $select
                    ->join(array('ep' => 'm_events_performers'), // join table with alias
                            'event_id = ep.ep_event_id')
//                    ->join(array('p' => 'm_performers'), // join table with alias
//                            'p.performer_id = ep.ep_performer_id')
                    ->where(array('ep.ep_performer_id' => $perf_id))
            ->where->greaterThanOrEqualTo(
                    'event_date', date('Y-m-d'))
            ;
            $select->order('event_date ASC');
        });

        return $rowset;
    }

    public function getLocation($event_id) {


        $rowset = $this->tableGateway->select(function (Select $select) use ($event_id) {

            $select
                    //->from(array('p' => 'm_performers'))  // base table
                    ->join(array('v' => 'm_venues'), // join table with alias
                            'event_venue_id = v.venue_id')
                    ->join(array('c' => 'm_cities'), // join table with alias
                            'c.city_id = v.venue_city_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'city_country_id = country_id')
                    ->join(array('s' => 'm_states'), // join table with alias
                            's.state_id = c.city_state_id')
                    ->where(array('event_id' => $event_id))
            //->limit(5)
            //->limit(10)
            ;
        });
        return $rowset;
    }

    public function getEventsByPerformerIdBigBoss($perf_id, $offset = -1, $limit = 7) {

        $perf_id = (int) $perf_id;
        $offset = (int) $offset;
        $limit = (int) $limit;
        $rowset = $this->tableGateway->select(function (Select $select) use ($perf_id, $offset, $limit) {

            if ($limit != 7) {
                $select->columns(array(
                    'venue_id' => 'event_venue_id',
                    'venue_name' => new Expression('v.venue_name'),
                    'city_id' => new Expression('c.city_id'),
                    'city_name' => new Expression('c.city_name'),
                    'state_id' => new Expression('s.state_id'),
                    'state_abbreviation' => new Expression('s.state_abbreviation')
                ));
            }
            $select
                    //->from(array('p' => 'm_performers'))  // base table
                    ->join(array('ep' => 'm_events_performers'), // join table with alias
                            'event_id = ep.ep_event_id')
                    ->join(array('v' => 'm_venues'), // join table with alias
                            'event_venue_id = v.venue_id')
                    ->join(array('c' => 'm_cities'), // join table with alias
                            'c.city_id = v.venue_city_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'city_country_id = country_id')
                    ->join(array('s' => 'm_states'), // join table with alias
                            's.state_id = c.city_state_id')
                    ->where(array(
                        'ep.ep_performer_id' => $perf_id))
            ->where->greaterThanOrEqualTo(
                    'event_date', date('Y-m-d'));
            if ($limit != 7) {
                $select
                        ->group('city_id')
                        ->order('city_name ASC');
            }
            $select->order('event_date ASC');
            if ($offset != -1) {
                $select->limit($limit)
                        ->offset($offset);
            }
        });
        return $rowset;
    }

    public function getEventsByCity($city_id, $count = false, $cat_id = 2, $offset = -1, $limit = 7) {
        $city_id = (int) $city_id;
        $offset = (int) $offset;
        $limit = (int) $limit;
        $cat_id = (int) $cat_id;
        $rowset = $this->tableGateway->select(function (Select $select) use ($city_id, $count, $offset, $limit, $cat_id) {

            if ($count === true) {
                $select->columns(array('event_id' => new Expression('COUNT(*)')));
            }
            $select
                    ->join(array('v' => 'm_venues'), // join table with alias
                            'event_venue_id = v.venue_id')
                    ->join(array('c' => 'm_cities'), // join table with alias
                            'c.city_id = v.venue_city_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'city_country_id = country_id')
                    ->join(array('s' => 'm_states'), // join table with alias
                            's.state_id = c.city_state_id')
                    ->join(array('ep' => 'm_performers'), // join table with alias
                            'event_host_id = performer_id')
                    ->join(array('cat' => 'm_categories'), // join table with alias
                            'event_category_id = category_id')
            ->where->equalTo('venue_city_id', $city_id)
            ->and->equalTo('category_parent_id', $cat_id)
            ->and->greaterThanOrEqualTo(
                    'event_date', date('Y-m-d'))
            ;
            $select->order('event_date ASC');
            $select->limit($limit);
            if ($offset != -1) {
                $select->offset($offset);
            }
        });
        return $rowset;
    }

    public function getEventsByCityGroupedVenues($city_id, $limit = 7, $cat_id = 2) {
        $city_id = (int) $city_id;
        $limit = (int) $limit;
        $cat_id = (int) $cat_id;
        $rowset = $this->tableGateway->select(function (Select $select) use ($city_id, $limit, $cat_id) {

            $select
                    ->join(array('v' => 'm_venues'), // join table with alias
                            'event_venue_id = v.venue_id')
                    ->join(array('c' => 'm_categories'), // join table with alias
                            'event_category_id = c.category_id')
//                    ->join(array('pc' => 'm_performers_categories'), // join table with alias
//                            'category_id = pc.pc_category_id')
            ->where->equalTo('venue_city_id', $city_id)
            ->and->equalTo('category_parent_id', $cat_id)
            ->and->greaterThanOrEqualTo(
                    'event_date', date('Y-m-d'))

            ;
            $select
                    ->group('venue_id')
                    ->order('venue_rank ASC')
                    ->limit($limit);
        });

        return $rowset;
    }

    public function getEventsByCityGroupedPerformers($city_id, $limit = 3) {
        $city_id = (int) $city_id;
        $limit = (int) $limit;
        $rowset = $this->tableGateway->select(function (Select $select) use ($city_id, $limit) {

//            $select->columns(array(
//                new Expression('DISTINCT p.*'),
//            ));
            $select
                    ->join(array('p' => 'm_performers'), // join table with alias
                            'event_host_id = performer_id')
                    ->join(array('v' => 'm_venues'), // join table with alias
                            'event_venue_id = v.venue_id')
            ->where->equalTo('venue_city_id', $city_id)
            ->and->greaterThanOrEqualTo(
                    'event_date', date('Y-m-d'))

            ;
            $select
                    ->group('performer_id')
                    ->limit($limit);
        });
        return $rowset;
    }

    public function getEventsByPerformerAndCities($perf_id, $cities_id) {

        $perf_id = (int) $perf_id;
        $rowset = $this->tableGateway->select(function (Select $select) use ($perf_id, $cities_id) {

            $select
                    //->from(array('p' => 'm_performers'))  // base table
                    ->join(array('ep' => 'm_events_performers'), // join table with alias
                            'event_id = ep.ep_event_id')
                    ->join(array('v' => 'm_venues'), // join table with alias
                            'event_venue_id = v.venue_id')
                    ->join(array('c' => 'm_cities'), // join table with alias
                            'c.city_id = v.venue_city_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'city_country_id = country_id')
                    ->join(array('s' => 'm_states'), // join table with alias
                            's.state_id = c.city_state_id')
                    ->where(array(
                        'ep.ep_performer_id' => $perf_id
                    ))
            ->where->greaterThanOrEqualTo(
                    'event_date', date('Y-m-d'))
            ->and->in('c.city_id', $cities_id);
            $select->order('event_date ASC');
        });
        return $rowset;
    }

    public function getEventsByPerformerAndVenue($perf_id, $venues_id) {

        $perf_id = (int) $perf_id;
        $rowset = $this->tableGateway->select(function (Select $select) use ($perf_id, $venues_id) {

            $select
                    //->from(array('p' => 'm_performers'))  // base table
                    ->join(array('ep' => 'm_events_performers'), // join table with alias
                            'event_id = ep.ep_event_id')
                    ->join(array('v' => 'm_venues'), // join table with alias
                            'event_venue_id = v.venue_id')
                    ->join(array('c' => 'm_cities'), // join table with alias
                            'c.city_id = v.venue_city_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'city_country_id = country_id')
                    ->join(array('s' => 'm_states'), // join table with alias
                            's.state_id = c.city_state_id')
                    ->where(array(
                        'ep.ep_performer_id' => $perf_id
                    ))
            ->where->greaterThanOrEqualTo(
                    'event_date', date('Y-m-d'))
            ->and->in('v.venue_id', $venues_id);
            $select->order('event_date ASC');
        });
        return $rowset;
    }

    public function getEventsByVenue($performerid, $venueid, $eventid) {


        $rowset = $this->tableGateway->select(function (Select $select) use($performerid, $venueid, $eventid) {

            $where = new Where();
            $where->equalTo('event_host_id', $performerid);
            $where->AND->equalTo('event_venue_id', $venueid);
            $where->AND->notEqualTo('event_id', $eventid);
            $select->where($where);
        });


        return $rowset;
    }

    public function getEventsByVenues($venues_id,$cat_id = 2) {

        $cat_id = (int) $cat_id;
        
        $rowset = $this->tableGateway->select(function (Select $select) use ($venues_id,$cat_id) {


            $select
                    ->join(array('v' => 'm_venues'), // join table with alias
                            'event_venue_id = v.venue_id')
                    ->join(array('c' => 'm_cities'), // join table with alias
                            'c.city_id = v.venue_city_id')
                    ->join(array('country' => 'm_countries'), // join table with alias
                            'city_country_id = country_id')
                    ->join(array('s' => 'm_states'), // join table with alias
                            's.state_id = c.city_state_id')
                    ->join(array('ep' => 'm_performers'), // join table with alias
                            'event_host_id = performer_id')
                    ->join(array('cat' => 'm_categories'), // join table with alias
                            'event_category_id = category_id')
            ->where->greaterThanOrEqualTo(
                    'event_date', date('Y-m-d'))
            ->and->in('v.venue_id', $venues_id)
            ->and->equalTo('category_parent_id', $cat_id)        
                    ;
            $select->order('event_date ASC');
        });
        return $rowset;
    }

    public function countEventsByPerformer($perf_id) {

        $events = $this->getEventsByPerformerIdBigBoss($perf_id);

        return $events->count();
    }

}
