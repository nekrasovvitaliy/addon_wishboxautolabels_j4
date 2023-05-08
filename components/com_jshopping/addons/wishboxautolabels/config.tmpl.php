<?php
// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

\JLoader::register('Addon'.$this->row->alias, __DIR__ .'/'.$this->row->alias.'.php');
$addon = call_user_func('Addon'.$this->row->alias.'::getInstance');
$addon->showAdminFormParams();