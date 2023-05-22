<?php
/**
 * @package     Joomla.Plugins
 * @subpackage  Jshoppingdmin.Wishboxautolabels
 */
namespace Joomla\Plugin\Jshoppingadmin\Wishboxautolabels\Extension;

use Exception;
use JLoader;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;
use Joomla\Event\DispatcherInterface;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;
use Joomla\Registry\Registry;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

if (!file_exists(JPATH_SITE.'/components/com_jshopping/bootstrap.php')) {
	\JSError::raiseError(500, "Please install component \"joomshopping\"");
} 
require_once (JPATH_SITE.'/components/com_jshopping/bootstrap.php');

/**
 * @since  1.0.0
 */
final class Wishboxautolabels extends CMSPlugin implements SubscriberInterface
{	
	/**
	 * Autoload the language file.
	 *
	 * @var boolean
	 * @since 1.0.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * @inheritDoc
	 *
	 * @return string[]
	 *
	 * @since 4.1.0
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'onAfterSaveProductEnd'    => 'onAfterSaveProductEnd'
		];
	}
	
	/**
	 * Constructor.
	 *
	 * @param   DispatcherInterface  $dispatcher  The dispatcher
	 * @param   array                $config      An optional associative array of configuration settings
	 *
	 * @since   1.0.0
	 */
	public function __construct(DispatcherInterface $dispatcher, array $config)
	{
		parent::__construct($dispatcher, $config);
	}
	
	/**
	 *
	 */
	public function onAfterSaveProductEnd(Event $event)
	{
		$productId = $event->getArgument(0);
		$autolabelsModel = JSFactory::getModel('autolabels', 'Site\\Wishbox');
		if (!$autolabelsModel->update([$productId])) {
			throw new \Exception('return false', 500);
		}
	}
}