{if !$logged}
      
<script>
$(document).ready(function() {
		$("#CoverPop-cover").show();
	//setTimeout( "jQuery('#CoverPop-cover').show();",10000 );
        $(".CoverPop-close").click(function(){
           $("#CoverPop-cover").hide(1);
		   $( "#signupBox" ).addClass("aa");
		   $.cookie('noShowWelcome', true);  
		   
		   $('.cross').on('click', function() {
           $( "#signupBox" ).addClass("pop_close");
             });
        });
		
		if($('font').hasClass('green')){ //alert('hi');
			setTimeout( "jQuery('#CoverPop-cover').hide();",4000 );
		// $( "#CoverPop-cover" ).fadeOut( 1600, "linear", complete );
			 //$("#CoverPop-cover").hide(1);
		
		 }
		
		
	
});
</script>

<!--<script language="javascript">
function validatereg()
{

if((document.reg.name.value.trim()=='') || (document.reg.name.value==null))
  {
	alert("Please insert name.");
	reg.name.focus();
	return false;
  }
  
  if((document.reg.email.value.trim()=='') || (document.reg.email.value==null))
  {
	alert("Please insert email.");
	reg.email.focus();
	return false;
  }
return true;
}

</script>-->

<script>
function Validate(oForm) {
    var myInput = oForm.elements["f_name"];
    if (myInput.value.length === 0) {
        AddErrorLabel(myInput, "Please insert First Name");
        return false;
    }
	
	 var myInput = oForm.elements["l_name"];
    if (myInput.value.length === 0) {
        AddErrorLabel(myInput, "Please insert Last Name");
        return false;
    }
	
	
	 var myInput = oForm.elements["email"];
    if (myInput.value.length === 0) {
        AddErrorLabel(myInput, "Please insert email-id");
        return false;
    }
	
	 var myInput = oForm.elements["pwd"];
    if (myInput.value.length === 0) {
        AddErrorLabel(myInput, "Please insert password");
        return false;
    }
	
	
	
	
	/*$( "#formID" ).validate({
  rules: {
    name: {
      required: true,
      email: true
    }
  }
});*/
    return true;
}

function AddErrorLabel(element, msg) {
    var oLabel = document.createElement("span");
    oLabel.className = "error_msg";
    oLabel.innerHTML = msg;
    var parent = element.parentNode;
    if (element.nextSibling) {
        if (element.nextSibling.className !== "error_msg") {
            parent.insertBefore(oLabel, element.nextSibling);
        }
    }
    else {
        parent.appendChild(oLabel);
    }
}
</script>
<!--<script type="text/javascript" src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>-->
<style>
.error_msg { color: red; }
.ffa930 
</style>

<style type="text/css">


.CoverPop-open, .CoverPop-open body {
    height: 100%;
    overflow: hidden;
}
#CoverPop-cover {
    bottom: 0;
    display: none;
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 1000;
}
.CoverPop-open #CoverPop-cover {
    display: block;
}

.splash {
    background-color: rgba(47, 99, 135, 0.9);
}
.splash-center {
    background: none repeat scroll 0 0 #fff;
    margin: 10% auto 0;
    padding: 20px;
    text-align: center;
    width: 40%;
	height:300px;
	/*overflow:scroll;*/
	color:#000;
}


form#account-creation_form fieldset{ height:200px; overflow:scroll; width:110%;}
#RegisterPopupError > div {
    background: none repeat scroll 0 0 #fce7e7;
    border: 1px solid #b00;
    color: #b00;
    margin-bottom: 6px;
    padding: 4px;
}

#registerpopup{ width:100%;}
.reg_left{ float:left; width:26%;}
.reg_right {
    float: left;
    margin-left: 5px;
    width: 73%;
}



.reg_text {
    float: right;
    width: 100%;
}
.reg_text > input {
    float: left;
}

.reg_text > select {
    float: left;
}

.name_text {
	font-size:13px;
    font-size: 12px;
    font-weight: bold;
    margin: 2px 0 0;
    padding: 5px 1px 10px 0;
}

.reg {
    background: none repeat scroll 0 0 #ffa930;
    border: medium none;
    color: #fff;
    padding: 6px 8px;
    text-align: center;
   
}
.reg:hover{ background:#424242;}
.CoverPop-close, .CoverPop-close>a:hover{ color:#ffa930 !important;}
#formID{ float:left;}
#formID p{ float:left; }



</style>

<div class="splash" id="CoverPop-cover">
<div class="CoverPop-content splash-center">
	
<div id="RegisterPopup">
<h3>{l s='Register Here'}</h3>

{$inserted} 
{$mail}
<fieldset>
	
	 <form  id="formID" method="post" action="#" onsubmit="return Validate(this);">
		
        
        <div class="reg_left">
            <div class="name_text">First Name:</div>
            <div class="name_text">Last Name:</div>
            <div class="name_text">E-mail:</div>
             <div class="name_text">Password :</div>
        </div>
        <div class="reg_right">
          <div class="reg_text"> <input id="f_name" name="f_name" type="text"/></div>
          <div class="reg_text"> <input id="l_name" name="l_name" type="text"/></div>
          <div class="reg_text"> <input id="email" name="email" type="text" /></div>
           <div class="reg_text"><input id="pwd" name="pwd" type="text" /></div>
          <div class="reg_text"> <select id="days" name="days"></div>
                            <option value="">-</option>
                            <option value="1">1  </option>
                            <option value="2">2  </option>
                            </select>
                            <select id="months" name="months">
                            <option value="">-</option>
                            <option value="1">January </option>
                            <option value="2">February </option>
                            <option value="3">March </option>
                            </select>
        
                <select id="years" name="years">
                <option value="">-</option>
                <option value="2014">2014   </option>
                <option value="2013">2013   </option>
                <option value="2012">2012   </option>
                </select></div>
               <div class="reg_text">   <input type="submit" name="submit_reg" value="Register"  class="reg" onclick="return validatereg();" /></div>
         </div>
	</form>
</fieldset>



</div>
<br /><br />
 <p class="close-splash"><a href="#" class="CoverPop-close">[Close]</a></p>
</div>

</div>

{/if}