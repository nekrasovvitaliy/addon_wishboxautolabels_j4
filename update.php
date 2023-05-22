<?php
use Joomla\CMS\Factory;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

$addonTable = \JSFactory::getTable('addon', 'jshop');
$addonTable->loadAlias('wishboxautolabels');
$addonTable->set('name', 'WishBox auto labels');
$addonTable->set('version', '1.0.0');
$addonTable->set('uninstall', '/components/com_jshopping/addons/wishboxautolabels/uninstall.php');
$addonTable->store();
$addonTable->installJoomlaExtension(
	[
		'name'		=> 'plg_jshoppingadmin_wishboxautolabels',
		'type'		=> 'plugin',
		'element'	=> 'wishboxautolabels',
		'folder'	=> 'jshoppingadmin',
		'client_id' => '0',
		'enabled'	=> 1
	],
	true
);
$addonTable->installJoomlaExtension(
	[
		'name'		=> 'plg_jshoppingorder_wishboxautolabels',
		'type'		=> 'plugin',
		'element'	=> 'wishboxautolabels',
		'folder'	=> 'jshoppingorder',
		'client_id' => '0',
		'enabled'	=> 1
	],
	true
);
$addonTable->installJoomlaExtension(
	[
		'name'		=> 'plg_task_wishboxjshoppingautolabels',
		'type'		=> 'plugin',
		'element'	=> 'wishboxjshoppingautolabels',
		'folder'	=> 'task',
		'client_id' => '0',
		'enabled'	=> 1
	],
	true
);