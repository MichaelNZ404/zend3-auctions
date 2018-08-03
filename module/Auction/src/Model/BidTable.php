<?php

namespace Auction\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class BidTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $select = $this->tableGateway->getSql()->select();
        return $this->tableGateway->selectWith($select);
    }

    public function getBid($id)
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

    public function saveBid(Bid $bid)
    {
        $data = [
            'auction_id' => $bid->auction_id,
            'person_id'  => $bid->person_id,
            'currency_amount'  => $bid->currency_amount,
        ];

        $this->tableGateway->insert($data);
        return;
    }
}