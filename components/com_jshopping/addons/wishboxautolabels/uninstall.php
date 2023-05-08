<?php
// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

$addonTable = \JSFactory::getTable('addon');
$addonTable->loadAlias('wishboxautolabels');
$addonTable->delete();
$addonTable->unInstallJoomlaExtension(
	'plugin',
	'wishboxjshoppingautolabels',
	'task',
);
$addonTable->deleteFolders(
	[
		'components/com_jshopping/addons/wishboxautolabels',
		'components/com_jshopping/lang/addon_wishboxautolabels',
		'plugins/task/wishboxjshoppingautolabels',
	]
);
$addonTable->deleteFiles(
	[
		'components/com_jshopping/Model/Wishbox/AutolabelsModel.php'
	]
);