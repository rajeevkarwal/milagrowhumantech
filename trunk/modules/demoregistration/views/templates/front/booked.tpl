<link rel="stylesheet" media="all" type="text/css"
      href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
<link rel="stylesheet" media="all" type="text/css" href="/js/jquery/plugins/timepicker/jquery-ui-timepicker-addon.css"/>
<link rel="stylesheet" media="all" type="text/css" href="{$jsSource}demoregistration.css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$jsSource}jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="{$jsSource}demoregistration.js"></script>




{capture name=path}{l s='Book a demo'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

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
                <div class="page-title">
                    <h1>{l s='Request for Pre - Sales Home Demo for Robots'}</h1>
                </div>
		
        
				
        
               
                    <p class="cms-banner-img"><img src="/img/cms/cms-banners/demo-page.png" alt="milagrow-book-demo"></p>
                    
                   
                     <h1 style="color:green;">{l s=' Your Demo hase been Booked'}</h1>
                  
                   
                   
                    <br/>
                    
              

            </div>
        </div>
    </div>
</div>
