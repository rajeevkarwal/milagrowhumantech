<?php echo include('../../config/config.inc.php');

echo "hello";
 ?>


<script language="javascript">
function validatereg()
{

if((document.formname.RegisterPopupFirstname.value.trim()=='') || (document.formname.RegisterPopupFirstname.value==null))
  {
	alert("Please insert name.");
	formname.RegisterPopupFirstname.focus();
	return false;
  }
  
  if((document.formname.RegisterPopupLasttname.value.trim()=='') || (document.formname.RegisterPopupLasttname.value==null))
  {
	alert("Please insert email.");
	formname.RegisterPopupLasttname.focus();
	return false;
  }
return true;
}

</script>

    <div class="CoverPop-content splash-center">

       
<div id="RegisterPopup">

<?php echo "hi";
//echo $sql="SELECT * FROM "._DB_PREFIX_."test2";
//echo $results = Db::getInstance()->executeS($sql);

echo  $sql="INSERT INTO `ps_test2` (`name`, `email`) VALUES ('name3', 'email3@email.com')";
echo 	$results=Db::getInstance()->execute($sql);


echo '<pre>';
print_r($results);
echo '</pre>';
echo $name = Tools::getValue('customer_name');

echo "testing for register";
 ?>


    
  <form name="formname" method="post" action=""  >  

   
    <fieldset class="account_creation">
        <h3>{l s='Registeration Form'}</h3>
 <div id="RegisterPopupError">
            </div>
        

        <p class="required text">
            <label for="customer_name"> name <sup>*</sup></label>
            <input type="text" value="" name="customer_name" id="RegisterPopupFirstname" class="text" >
        </p>

        <p class="required text">
            <label for="customer_email">Email <sup>*</sup></label>
             <input type="text" value="" name="customer_email" id="RegisterPopupLasttname" class="text" >
            
        </p>
  <p class="cart_navigation required submit">
      <input type="submit" name="reg_pop" value="Register" onclick="return validatereg();" />
     </p>
    </fieldset>
    </form>    


</div>


        <p class="close-splash"><a href="#" class="CoverPop-close">or skip signup</a></p>

    </div><!--end .splash-center -->


