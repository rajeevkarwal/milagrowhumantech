<?php 
include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../init.php');
include_once(_PS_MODULE_DIR_ . 'prestaqna/prestaqna.php');

$object=new PrestaQna();
$question_id=Tools::getValue('question_id');
$result=$object->removeQuestion($question_id);
echo json_encode($result);
?>