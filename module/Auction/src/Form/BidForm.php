<?php

namespace Auction\Form;

use Zend\Form\Form;


class BidForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('bid');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'auction_id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'currency_amount',
            'type' => 'number',
            'options' => [
                'label' => 'Quantity',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}