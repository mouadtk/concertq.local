<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class VenueConfigurationsTypesTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getVCTID($_id)
    {
        $_id  = (string) $_id;
        $rowset = $this->tableGateway->select(array('vct_id' => $_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $_id");
        }
        
        return $row;
    }

    
}