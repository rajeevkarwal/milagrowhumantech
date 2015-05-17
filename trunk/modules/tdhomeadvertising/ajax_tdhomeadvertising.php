<?php
include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('tdhomeadvertising.php');

$tdslider = new TDhomeAdvertising();
if (!Tools::isSubmit('secure_key') OR Tools::getValue('secure_key') != $tdslider->secure_key OR !Tools::isSubmit('action'))
	die(1);


if (Tools::getValue('action') == 'dnd')
{
	if ($table = Tools::getValue('sliderdata') );
	{
		$pos = 0;
		foreach ($table as $key =>$row)
		{
			$ids = explode('_', $row);
			Db::getInstance()->Execute('
			UPDATE `'._DB_PREFIX_.'tdhomeadvertising` 
			SET `position` = '.(int)$pos.' 
			WHERE `id_tdhomeadvertising` = '.(int)$ids[2]);
			$pos++;
		}
	}
}


