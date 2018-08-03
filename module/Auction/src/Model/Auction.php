<?php 

namespace Auction\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;


class Auction
{
    public $id;
    public $auction_item;
    public $auction_owner_name;
    public $time_remaining;
    public $item_name;
    public $item_image;
    public $currency_image;
    public $currency_name;
    public $currency_amount;
    public $leading_bidder_name;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->auction_item = !empty($data['auction_item']) ? $data['auction_item'] : null;
        $this->auction_owner_name  = !empty($data['person_name']) ? $data['person_name'] : null;
        $this->time_remaining  = !empty($data['expires_at']) ? $this->calculateRemaining($data['expires_at']) : null;
        
        $this->item_name  = !empty($data['item_name']) ? $data['item_name'] : null;
        $this->item_image  = !empty($data['item_image']) ? $data['item_image'] : null;

        $this->currency_image  = !empty($data['currency_image']) ? $data['currency_image'] : null;
        $this->currency_name  = !empty($data['currency_name']) ? $data['currency_name'] : null;
        $this->currency_amount  = !empty($data['currency_amount']) ? $data['currency_amount'] : 0;
        $this->leading_bidder_name = !empty($data['leading_bidder_name']) ? $data['leading_bidder_name'] : null;
    }

    private static function calculateRemaining($expiry){
        $curr_time = new \DateTime("now");
        $expire_time = new \DateTime($expiry);
        $diff=date_diff($expire_time, $curr_time);
        $remaining = [];
        if ($diff->d > 0){
            array_push($remaining, $diff->d . " days");
        }
        if ($diff->h > 0){
            array_push($remaining, $diff->h . " hours");
        }
        if ($diff->i > 0){
            array_push($remaining, $diff->i . " minutes");
        }
        if($curr_time < $expire_time){
            $remaining = implode(", ", $remaining) . " remaining";
        }
        else{
            $remaining = " expired";
        }
        return $remaining;
    }
}