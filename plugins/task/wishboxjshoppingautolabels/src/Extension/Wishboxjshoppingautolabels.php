<?php
/**
 * @package     Joomla.Plugins
 * @subpackage  Task.Wishboxtransferusertogoup
 */
namespace Joomla\Plugin\Task\Wishboxjshoppingautolabels\Extension;

use Exception;
use JLoader;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;
use Joomla\Component\Scheduler\Administrator\Event\ExecuteTaskEvent;
use Joomla\Component\Scheduler\Administrator\Task\Status;
use Joomla\Component\Scheduler\Administrator\Traits\TaskPluginTrait;
use Joomla\Event\DispatcherInterface;
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
 * Task plugin with routines to update quantity from retailCRM. These routines can be used to control planned
 * maintenance periods and related operations.
 *
 * @since  4.1.0
 */
final class Wishboxjshoppingautolabels extends CMSPlugin implements SubscriberInterface
{
	/**
	 *
	 */
	use TaskPluginTrait;
	
	/**
	 * @var string[]
	 * @since 4.1.0
	 */
	protected const TASKS_MAP = [
		'plg_task_wishboxjshoppingautolabels_update' =>
		[
			'langConstPrefix' => 'PLG_TASK_WISHBOXJSHOPPINGAUTOLABELS_UPDATE',
			'method'          => 'update'
		]
	];
	
	/**
	 * Autoload the language file.
	 *
	 * @var boolean
	 * @since 4.1.0
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
			'onTaskOptionsList'    => 'advertiseRoutines',
			'onExecuteTask'        => 'standardRoutineHandler',
			'onContentPrepareForm' => 'enhanceTaskItemForm',
		];
	}
	
	/**
	 * Constructor.
	 *
	 * @param   DispatcherInterface  $dispatcher  The dispatcher
	 * @param   array                $config      An optional associative array of configuration settings
	 *
	 * @since   4.2.0
	 */
	public function __construct(DispatcherInterface $dispatcher, array $config)
	{
		parent::__construct($dispatcher, $config);
	}
	
	/**
	 *
	 */
	private function update(ExecuteTaskEvent $event): int
	{
		try {
			$autolabelsModel = JSFactory::getModel('autolabels', 'Site\\Wishbox');
			if (!$autolabelsModel->update()) {
				throw new \Exception('return false', 500);
			}
		} catch (\Exception|\Error $e) {
			$this->logTask((string)$e, 'error');
			return Status::KNOCKOUT;
		}
		return Status::OK;
	}
}