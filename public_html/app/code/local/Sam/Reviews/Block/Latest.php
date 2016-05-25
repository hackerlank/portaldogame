<?php
class Sam_Reviews_Block_Latest extends Mage_Core_Block_Template
{
	public function __construct()
    {
        parent::__construct();
        $collection = Mage::getModel('reviews/reviews')->getReviewsCollection();
        $this->setCollection($collection);
    }
	protected function _prepareLayout()
    {
		
        parent::_prepareLayout();
		
        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit($this->getReviewPerPageAllowed());
		//$pager->setLimit($this->getReviewPerPageDefault());
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }
	public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
	public function getReviewPerPageDefault()
	{
		return Mage::getStoreConfig('reviewssection/settings/review_per_page_default');
	}
	public function getReviewPerPageAllowed()
	{
		$reviewperpage = Mage::getStoreConfig('reviewssection/settings/review_per_page_allowed');
		$allowed = explode(',',$reviewperpage);
		$allowedcopy = $allowed;
		$combine = array_combine($allowed,$allowedcopy);
		return $combine;
	}
	public function getReviews() 
	{
		$collection = $this->getCollection()
        	        ->addRateVotes();    
		return $collection;
	}
	public function getCount()
	{
		$count = count($this->getReviews()->getData());
		return $count;
	}
	public function getRatingvote($productid)
	{
		$reviews = Mage::getModel('reviews/reviews')->getProductReview($productid); 
		$avg = 0;
		$ratings = array();
		if ($this->getCount() > 0) {
			foreach ($reviews->getItems() as $review) {
				foreach( $review->getRatingVotes() as $vote ) {
					$ratings[] = $vote->getPercent();
				}
			}
			$avg = array_sum($ratings)/count($ratings);
		}
		return ceil($avg);
	}
}