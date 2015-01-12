<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Performer;
use Application\Model\PerformerTable;
use Application\Model\Category;
use Application\Model\CategoryTable;
use Application\Model\Eventkeyword;
use Application\Model\EventkeywordTable;
use Application\Model\Eventperformer;
use Application\Model\EventperformerTable;
use Application\Model\Performercategory;
use Application\Model\PerformercategoryTable;
use Application\Model\Ticket;
use Application\Model\TicketTable;
use Application\Model\Venuesconfiguration;
use Application\Model\VenuesconfigurationTable;
use Application\Model\Zipcodes;
use Application\Model\ZipcodesTable;
use Application\Model\Cities;
use Application\Model\CitiesTable;
use Application\Model\Countries;
use Application\Model\CountriesTable;
use Application\Model\States;
use Application\Model\StatesTable;
use Application\Model\VenuesConfigurationsTypes;
use Application\Model\VenuesConfigurationsTypesTable;
use Application\Model\Maps,
    Application\Model\MapsTable,
    Application\Model\Events,
    Application\Model\EventsTable,
    Application\Model\Venues,
    Application\Model\VenuesTable,
    Application\Model\Location,
    Application\Model\LocationTable;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
//        $em = $e->getApplication()->getServiceManager()->get('Doctrine\ORM\EntityManager'); 
//        $platform = $em->getConnection()->getDatabasePlatform();
//        $platform->registerDoctrineTypeMapping('enum', 'string');
    }


    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                //
                 'Application\Model\LocationTable' =>  function($sm) {
                    $tableGateway = $sm->get('LocationTableGateway');
                    $table = new LocationTable($tableGateway);
                    return $table;
                },
                'LocationTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Location());
                    return new TableGateway('m_geolocation', $dbAdapter, null, $resultSetPrototype);
                },
                //
                
                'Application\Model\PerformerTable' => function($sm) {
            $tableGateway = $sm->get('PerformerTableGateway');
            $table = new PerformerTable($tableGateway);
            return $table;
        },
                'PerformerTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Performer());
            return new TableGateway('m_performers', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * *************************************************************************************** */
                'Application\Model\MapsTable' => function($sm) {
            $tableGateway = $sm->get('MapsTableGateway');
            $table = new MapsTable($tableGateway);
            return $table;
        },
                'MapsTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Maps());
            return new TableGateway('m_maps', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * *************************************************************************************** */
                'Application\Model\EventsTable' => function($sm) {
            $tableGateway = $sm->get('EventsTableGateway');
            $table = new EventsTable($tableGateway);
            return $table;
        },
                'EventsTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Events());
            return new TableGateway('m_events', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * *************************************************************************************** */
                'Application\Model\VenuesTable' => function($sm) {
            $tableGateway = $sm->get('VenuesTableGateway');
            $table = new VenuesTable($tableGateway);
            return $table;
        },
                'VenuesTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Venues());
            return new TableGateway('m_venues', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * *************************************************************************************** */
                'Application\Model\CategoryTable' => function($sm) {
            $tableGateway = $sm->get('CategoryTableGateway');
            $table = new CategoryTable($tableGateway);
            return $table;
        },
                'CategoryTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Category());
            return new TableGateway('m_categories', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * *************************************************************************************** */
                'Application\Model\EventkeywordTable' => function($sm) {
            $tableGateway = $sm->get('EventkeywordTableGateway');
            $table = new EventkeywordTable($tableGateway);
            return $table;
        },
                'EventkeywordTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Eventkeyword());
            return new TableGateway('m_events_keywords', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * *************************************************************************************** */
                'Application\Model\EventperformerTable' => function($sm) {
            $tableGateway = $sm->get('EventperformerTableGateway');
            $table = new EventperformerTable($tableGateway);
            return $table;
        },
                'EventperformerTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Eventperformer());
            return new TableGateway('m_events_performers', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * *************************************************************************************** */
                'Application\Model\PerformercategoryTable' => function($sm) {
            $tableGateway = $sm->get('PerformercategoryTableGateway');
            $table = new PerformercategoryTable($tableGateway);
            return $table;
        },
                'PerformercategoryTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Performercategory());
            return new TableGateway('m_performers_categories', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * *************************************************************************************** */
                'Application\Model\TicketTable' => function($sm) {
            $tableGateway = $sm->get('TicketTableGateway');
            $table = new TicketTable($tableGateway);
            return $table;
        },
                'TicketTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Ticket());
            return new TableGateway('m_tickets', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * *************************************************************************************** */
                'Application\Model\VenuesconfigurationTable' => function($sm) {
            $tableGateway = $sm->get('VenuesconfigurationTableGateway');
            $table = new VenuesconfigurationTable($tableGateway);
            return $table;
        },
                'VenuesconfigurationTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Venuesconfiguration());
            return new TableGateway('m_venues_configurations', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * ********************************* Ismail ****************************************************** */
                'Application\Model\ZipcodesTable' => function($sm) {
            $tableGateway = $sm->get('ZipcodesTableGateway');
            $zipcodetable = new ZipcodesTable($tableGateway);
            return $zipcodetable;
        },
                'ZipcodesTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Zipcodes());
            return new TableGateway('m_zipcodes', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * ********************************** Ismail ***************************************************** */
                'Application\Model\CitiesTable' => function($sm) {
            $tableGateway = $sm->get('CitiesTableGateway');
            $citiestable = new CitiesTable($tableGateway);
            return $citiestable;
        },
                'CitiesTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Cities());
            return new TableGateway('m_cities', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * *********************************** Ismail **************************************************** */
                'Application\Model\CountriesTable' => function($sm) {
            $tableGateway = $sm->get('CountriesTableGateway');
            $countriestable = new CountriesTable($tableGateway);
            return $countriestable;
        },
                'CountriesTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Countries());
            return new TableGateway('m_countries', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * ************************************ Ismail *************************************************** */
                'Application\Model\StatesTable' => function($sm) {
            $tableGateway = $sm->get('StatesTableGateway');
            $statestable = new StatesTable($tableGateway);
            return $statestable;
        },
                'StatesTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new States());
            return new TableGateway('m_states', $dbAdapter, null, $resultSetPrototype);
        },
                /*                 * ************************************* Ismail ************************************************** */
                'Application\Model\VenuesConfigurationsTypesTable' => function($sm) {
            $tableGateway = $sm->get('VenuesConfigurationsTypesTableGateway');
            $table = new VenuesConfigurationsTypesTable($tableGateway);
            return $table;
        },
                'VenuesConfigurationsTypesTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new VenuesConfigurationsTypes());
            return new TableGateway('m_venues_configurations_types', $dbAdapter, null, $resultSetPrototype);
        },
            /*             * *************************************************************************************** */
            ),
        );
    }

}
