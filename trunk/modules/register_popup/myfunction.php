<?php


    if(isset($_POST['SubmitRegisterPopup']))
    {
      $name = Tools::getValue('customer_firstname');
      Db::getInstance()->insert('ps_customer', array(
      'id_shop_group' => (int) 1,
	  'id_gender' => (int) 1,
      'firstname' => pSQL($name),
    ));

//header('Location: http://www.banditbirds.co.uk');

echo "insert successfully";
}

else


{
	echo "not insert";
	
	}
?>