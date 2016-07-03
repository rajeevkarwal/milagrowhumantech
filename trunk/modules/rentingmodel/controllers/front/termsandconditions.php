<?php
class RentingmodelTermsAndConditionsModuleFrontController extends ModuleFrontController
{
   public function initContent()
   {
   	parent::initContent();
   	$this->setTemplate('terms-condtions.tpl');
   }
}
