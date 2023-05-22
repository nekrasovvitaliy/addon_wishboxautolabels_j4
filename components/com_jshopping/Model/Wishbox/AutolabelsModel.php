<?php
namespace Joomla\Component\Jshopping\Site\Model\Wishbox;

use Exception;
use Joomla\CMS\Factory;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 *
 */
class AutolabelsModel extends \WishBox\JShopping\Model\Base
{
	/**
	 *
	 */
	protected string $addon_alias = 'wishboxautolabels';
	
	/**
	 *
	 */
	public function update(array $productIds = []): bool
	{
		if (!$this->updateNewLabels($productIds)) {
			throw new Exception('updateNewLabels return false', 500);
		}
		if (!$this->updateAvailableLabels($productIds)) {
			throw new Exception('updateAvailableLabels return false', 500);
		}
		if (!$this->updateNotAvailableLabels($productIds)) {
			throw new Exception('updateNotAvailableLabels return false', 500);
		}
		return true;
	}
	
	/**
	 *
	 */
	public function updateNewLabels(array $productIds = []): bool
	{
		$newLabelId = $this->addon->params->get('new_label_id', 0);
		$newLabelDayCount = $this->addon->params->get('new_label_day_count', 0);
		$query = $this->db->getQuery(true)
			->update('#__jshopping_products')
			->set('label_id='.$newLabelId)
			->where('product_quantity > 0')
			->where('product_date_added > NOW() - INTERVAL '.$newLabelDayCount.' DAY');
		if (count($productIds)) {
			$query->where('product_id IN('.implode(', ', $productIds).')');
		}
		$this->db->setQuery($query);
		$this->db->execute();
		return true;
	}
	
	/**
	 *
	 */
	public function updateAvailableLabels(array $productIds = []): bool
	{
		$availableLabelId = $this->addon->params->get('available_label_id', 0);
		$newLabelDayCount = $this->addon->params->get('new_label_day_count', 0);
		$query = $this->db->getQuery(true)
			->update('#__jshopping_products')
			->set('label_id='.$availableLabelId)
			->where('product_quantity > 0')
			->where('product_date_added < NOW() - INTERVAL '.$newLabelDayCount.' DAY');
		if (count($productIds)) {
			$query->where('product_id IN('.implode(', ', $productIds).')');
		}
		$this->db->setQuery($query);
		$this->db->execute();
		return true;
	}
	
	/**
	 *
	 */
	public function updateNotAvailableLabels(array $productIds = []): bool
	{
		$notAvailableLabelId = $this->addon->params->get('not_available_label_id', 0);
		$query = $this->db->getQuery(true)
			->update('#__jshopping_products')
			->set('label_id='.$notAvailableLabelId)
			->where('product_quantity <= 0');
		if (count($productIds)) {
			$query->where('product_id IN('.implode(', ', $productIds).')');
		}
		$this->db->setQuery($query);
		$this->db->execute();
		return true;
	}
}