
<style>
#hangout-div{
    margin-top: 0px;
	top:300px;
    margin-right: 0px;
    margin-bottom: 0px;
    padding: 0px;
    border: 0px;
    overflow: hidden;
    position: fixed;
    z-index: 16000002;
    width: 190px;
    height: 35px;
    left:0px;
    bottom: 300px;
    background: transparent;
}
@media screen and (max-width: 800px){
   	#hangout-div{
        display:none;
    }
}
</style>
		  <script src="https://apis.google.com/js/platform.js" async defer></script>
        <div id="hangout-div">
            <g:hangout render="createhangout" hangout_type="hangout" widget_size=72
                       initial_apps="[{ app_id : '{$hangout_app_id}', start_data : 'dQw4w9WgXcQ', 'app_type': '{$hangout_app_type}' }]" invites="{$hangout_invite_block}">
            </g:hangout>
        </div>



