<?php
include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('psmodimageslider.php');

$sccslider = new PsModImageSlider();
if (!Tools::isSubmit('secure_key') OR Tools::getValue('secure_key') != $sccslider->secure_key OR !Tools::isSubmit('action'))
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
			UPDATE `'._DB_PREFIX_.'sccimageslider` 
			SET `position` = '.(int)$pos.' 
			WHERE `id_sccimageslider` = '.(int)$ids[2]);
			$pos++;
		}
	}
}