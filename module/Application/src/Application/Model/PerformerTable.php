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

/**
 * Description of PerformerTable
 *
 * @author ahmed
 */
class PerformerTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getPerformer($_perf_id) {
        $_perf_id = (int) $_perf_id;
        $rowset = $this->tableGateway->select(array('performer_id' => $_perf_id));

        $row = $rowset->current();

        if (!$row) {
            throw new Exception("Could not find row $_perf_id");
        }
        return $row;
    }

// cette fonction doit etre modifier selon  la logique de la table 
    public function getPerformerByLink($_performer_link) {
        $_performer_link = (string) $_performer_link;
        $rowset = $this->tableGateway->select(array('performer_link_dash' => $_performer_link));
        $row = $rowset->current();
        

        return $row;
    }

    public function getTopPerformers($NbPerformers) {


        $rowset = $this->tableGateway->select(function (Select $select) use ($NbPerformers) {
            $where = new Where();
            $where->notEqualTo('mpc.pc_rank', 'NULL')->equalTo('category.category_parent_id', 2);

            $select
                    ->join(array('mpc' => 'm_performers_categories'), // join table with alias
                            'performer_id = mpc.pc_performer_id')
                    ->join(array('category' => 'm_categories'), // join table with alias
                            'category.category_id = mpc.pc_category_id')
                    ->where($where)
                    ->limit($NbPerformers)
                    ->group('performer_id')
                    ->order(array('mpc.pc_rank' => 'ASC'))
            ;
        });

        return $rowset;
    }

    public function getPerformerNameDash($_perf_name) {

        $rowset = $this->tableGateway->select(array('performer_link_dash' => $_perf_name));

        $row = $rowset->current();

//        if (!$row) {
//            throw new Exception("Could not find row $_perf_name");
//        }
        return $row;
    }

    public function existInCat($cat_id = 2, $name_dash = null) {
        return $this->getPerformerByCatAndNameDash($cat_id, $name_dash);
    }

    public function getPerformerByCatAndNameDash($cat_id = 2, $name_dash = null) {

        $rowset = $this->tableGateway->select(function (Select $select) use ($cat_id, $name_dash) {
            $select
                    //->from(array('p' => 'm_performers'))  // base table
                    ->join(array('pc' => 'm_performers_categories'), // join table with alias
                            'performer_id = pc.pc_performer_id')
                    ->join(array('c' => 'm_categories'), // join table with alias
                            'c.category_id = pc.pc_category_id')
                    ->where(array('c.category_parent_id' => $cat_id, 'performer_link_dash' => $name_dash))
            //->limit(10)
            ;
        });

        //$rowset->buffer();
        $row = $rowset->current();
//        print_r($row);
//        if (!$row) {
//            throw new Exception("Could not find row $_perf_name");
//        }
        return $row;
    }

    public function getRelatedPerformer($name_performer) {
       // $rank = (int) $rank;

        $resultSet = $this->tableGateway->select(function (Select $select)use($name_performer) {
            $where = new Where;

            $where->greaterThan('performer_name', $name_performer)
                    ->equalTo('pc_category_id', 2);

            $select->join(array('pc' => 'm_performers_categories'), // join table with alias
                            'performer_id = pc.pc_performer_id')
                    ->join(array('c' => 'm_categories'), // join table with alias
                            'c.category_id = pc.pc_category_id')
                   
                    ->where($where)
                    ->order('performer_name ASC')
                    ->limit(3);
        });
        return $resultSet;
    }

}
