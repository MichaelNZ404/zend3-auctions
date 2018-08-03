<?php
namespace Auction;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\AuctionTable::class => function($container) {
                    $tableGateway = $container->get(Model\AuctionTableGateway::class);
                    return new Model\AuctionTable($tableGateway);
                },
                Model\AuctionTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Auction());
                    return new TableGateway('auction', $dbAdapter, null, $resultSetPrototype);
                },
                Model\BidTable::class => function($container) {
                    $tableGateway = $container->get(Model\BidTableGateway::class);
                    return new Model\BidTable($tableGateway);
                },
                Model\BidTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Bid());
                    return new TableGateway('bid', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AuctionController::class => function($container) {
                    return new Controller\AuctionController(
                        $container->get(Model\AuctionTable::class),
                        $container->get(Model\BidTable::class)
                    );
                },
            ],
        ];
    }
}