<style>
	.small-gap{
	padding:10px 0px 10px 0px;
	
	}

</style>

<div class="main">
    <div class="main-inner">
        <div class="row-fluid show-grid">
{if $themesdev.td_siderbar_without=="enable"}
                <div class="col-left sidebar span3">
                    {$HOOK_LEFT_COLUMN}
                    {$themesdev.td_left_sidebar_customhtml|html_entity_decode}

                </div>
{/if}
<div class="span9">
	<div class="small-gap"></div>
<h3>We have received your rental application for <h2>{$productName}</h2> </h3><br>

<label>Your Application Number is <b>{$applicationNumber}</b></label>
	<div class="small-gap"></div>
<span>Our Team shall get back to you within 24 Hours<br>
Alternatively you can also call+91-9953476184 or 0124-4309570/71/72 . You can also mail us at <a href="mailto:cs@milagrow.in">cs@milagrow.in</a>
 </span><br>
 
 <labe><a href="/rent-our-robots">Click Here</a> for another application</label>&nbsp;
 </div>
 </div>
 </div>
 </div>