<?php
class Sam_Reviews_Block_Latestsidebar extends Mage_Core_Block_Template
{
	protected function getTotalRecentReviews()
	{
		$totalreviewcount = (int) Mage::getStoreConfig('reviewssection/settings/total_recent_reviews');
		return $totalreviewcount;
	}
	public function getReviews() 
	{
		$collection = Mage::getModel('reviews/reviews')
						->getReviewsCollection()
						->setPageSize($this->getTotalRecentReviews());
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
	public function getViewMode()
	{
		return Mage::getStoreConfig('reviewssection/settings/view_type');
	}
}