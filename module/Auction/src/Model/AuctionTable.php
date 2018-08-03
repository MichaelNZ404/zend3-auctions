<?php

namespace Auction\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class AuctionTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $select = $this->tableGateway->getSql()->select()
            ->join('bid', 'auction.id = bid.auction_id', array('currency_amount'), 'left')
            ->where("bid.id = (SELECT MAX(id) FROM bid WHERE auction_id = auction.id) OR auction_id IS NULL")
            ->join(array('bidder' => 'person'), 'bid.person_id = bidder.id', array('leading_bidder_name' => 'person_name'), 'left')
            ->join('item', 'auction.auction_item_id = item.id')
            ->join(array('owner' => 'person'), 'auction.auction_owner_id = owner.id')
            ->join('currency', 'auction.currency_id = currency.id');
        return $this->tableGateway->selectWith($select);
    }

    public function getAuction($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }
}