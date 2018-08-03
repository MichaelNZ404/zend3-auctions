<?php 
namespace Auction\Controller;

use Auction\Model\AuctionTable;
use Auction\Model\BidTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auction\Form\BidForm;
use Auction\Model\Bid;

class AuctionController extends AbstractActionController
{
    private $table;

    public function __construct(AuctionTable $table, BidTable $bidtable)
    {
        $this->table = $table;
        $this->bidtable = $bidtable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'auctions' => $this->table->fetchAll(),
        ]);
    }

    public function bidAction()
    {
        $auction_id = (int) $this->params()->fromRoute('id', 0);
        $form = new BidForm();
        $form->get('submit')->setValue('Add');
        $form->get('auction_id')->setValue($auction_id);

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $bid = new Bid();
        $form->setInputFilter($bid->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $bid->exchangeArray($form->getData());
        $this->bidtable->saveBid($bid);
        return $this->redirect()->toRoute('auction');
    }
}