<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Jshoppingdmin.Wishboxautolabels
 */
use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Joomla\Plugin\Jshoppingadmin\Wishboxautolabels\Extension\Wishboxautolabels;
use Joomla\Utilities\ArrayHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

return new class implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function register(Container $container)
	{
		$container->set
		(
			PluginInterface::class,
			function (Container $container)
			{
				$plugin = new Wishboxautolabels(
					$container->get(DispatcherInterface::class),
					(array)PluginHelper::getPlugin('jshoppingadmin', 'wishboxautolabels')
				);
				$plugin->setApplication(Factory::getApplication());
				return $plugin;
			}
		);
	}
};