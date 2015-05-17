jQuery(document).ready(function($) {
    // Fade out the save message
	$('.fade').delay(1000).fadeOut(1000);

var i = 0;
$("#navigation li a").attr("id", function() {
   i++;
   return "item"+i;
});

				
	$("#sidenav li a").click(function(evt){
		
		$("#sidenav li").removeClass("active");
		$(this).parent().addClass("active");
							
		var clicked_group = $(this).attr("href");

		$(".tab-pane").hide();
							
		$(clicked_group).fadeIn("fast");
		return false;
						
	});
	$.fn.center = function () {
		this.animate({"top":( $(window).height() - this.height() - 200 ) / 2+$(window).scrollTop() + "px"},100);
		this.css("left", 250 );
		return this;
	}
	$("#scc-popup-patterns-save").center();
	$("#scc-popup-save").center();
	$("#scc-popup-reset").center();
			
	$(window).scroll(function() { 
                $("#scc-popup-patterns-save").center();
		$("#scc-popup-save").center();
		$("#scc-popup-reset").center();
	});
			
	$(".radio-box-picture").click(function(){
		$(this).parent().parent().find(".radio-box-picture").removeClass("add-radio-picture");
		$(this).addClass("add-radio-picture");
	});
	$(".for-radio-picture-label").hide();
	$(".radio-box-picture").show();
	$(".of-radio-img-radio").hide();

	$(".scc-radio-tile-img").click(function(){
		$(this).parent().parent().find(".scc-radio-tile-img").removeClass("scc-radio-tile-selected");
		$(this).addClass("scc-radio-tile-selected");
	});
        
	$(".of-radio-tile-label").hide();
	$(".scc-radio-tile-img").show();
	$(".scc-radio-tile-radio").hide();
        
        $(".tab-pane:first").fadeIn(); 
        $("#sidenav li:first").addClass("active");
        $(".pattern_upload_button").each(function(){
                        var selected_object = $(this);
			var selected_id = $(this).attr("id");	
			new AjaxUpload(selected_id, {
				  action: "../modules/psmodthemeoptionpanel/psmodthemeoptionpanel_ajax.php",
				  name: selected_id, 
				  data: {
						action: "pattern_upload",
						type: "pattern",
						data: selected_id },
				  autoSubmit: true, 
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension){
						selected_object.text("Uploading"); 
						this.disable(); 
						interval = window.setInterval(function(){
							var text = selected_object.text();
							if (text.length <13){	selected_object.text(text + "."); }
							else { selected_object.text("Uploading"); } 
						}, 200);
				  },
				  onComplete: function(file, response) {
				   
					window.clearInterval(interval);
					selected_object.text("Upload Pattern");	
					this.enable(); 
					
					if(response.search("Upload Error") > -1){
						var return_data = "<span class='upload-error'>" + response + "</span>";
						$(".upload-error").remove();
						selected_object.parent().after(return_data);
					
					}
					else{
                                                var success = $("#scc-popup-patterns-save");
						var loading = $(".scc-loading-img");
						loading.fadeOut();  
						success.fadeIn();
						window.setTimeout(function(){
						   success.fadeOut(); 
						   
												
						}, 2000);
                                             window.setTimeout("location.reload()", 3000);
					}
				  }
				});
	});
			//AJAX Upload
			$(".upload_button").each(function(){
			
			var selected_object = $(this);
			var selected_id = $(this).attr("id");	
			new AjaxUpload(selected_id, {
				  action: "../modules/psmodthemeoptionpanel/psmodthemeoptionpanel_ajax.php",
				  name: selected_id, 
				  data: {
						action: "of_ajax_post_action",
						type: "image_upload",
						data: selected_id },
				  autoSubmit: true,
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension){
						selected_object.text("Uploading");
						this.disable(); 
						interval = window.setInterval(function(){
							var text = selected_object.text();
							if (text.length <13){	selected_object.text(text + "."); }
							else { selected_object.text("Uploading"); } 
						}, 200);
				  },
				  onComplete: function(file, response) {
				   
					window.clearInterval(interval);
					selected_object.text("Upload");	
					this.enable();
					
					if(response.search("Upload Error") > -1){
						var return_data = "<span class='upload-error'>" + response + "</span>";
						$(".upload-error").remove();
						selected_object.parent().after(return_data);
					
					}
					else{
					var return_data = '<img class="hide for-body-picture" id="image_'+selected_id+'" src="'+response+'" alt="" />';

						$(".upload-error").remove();
						$("#image_" + selected_id).remove();	
						selected_object.parent().after(return_data);
						$("img#image_"+selected_id).fadeIn();
						selected_object.next("span").fadeIn();
						selected_object.parent().prev("input").val(response);
					}
				  }
				});
			
			});
			
                                        $('.selectColor').each(function(){
                                        var Othis = this; //cache a copy of the this variable for use inside nested function
                                        var initialColor = $(Othis).next('input').attr('value');
                                        $(this).ColorPicker({
                                        color: initialColor,
                                        onShow: function (colpkr) {
                                        $(colpkr).fadeIn(500);
                                        return false;
                                        },
                                        onHide: function (colpkr) {
                                        $(colpkr).fadeOut(500);
                                        return false;
                                        },
                                        onChange: function (hsb, hex, rgb) {
                                        $(Othis).children('div').css('backgroundColor', '#' + hex);
                                        $(Othis).next('input').attr('value','#' + hex);
                                }
                                });
                                }); //end color picker
       
       /*  $(".reset-patter-button").click(function(){

                                          var serializeddata =$("#for_form").serialize();
					 
					  var url ='../modules/sccpsthemeoptionpanel/psmodthemeoptionpanel_ajax.php';

					var data = {
						type: "reset_pattern",
						action: "of_ajax_post_action",
						data: serializeddata
					};
					
					$.post(url, data, function(response) {
						var success = $("#scc-popup-save");
						var loading = $(".scc-loading-img");
						loading.fadeOut();  
						success.fadeIn();
						window.setTimeout(function(){
						   success.fadeOut(); 
						   
												
						}, 2000);
                                            
                                               window.setTimeout("location.reload()", 3000);
					});
					
					return false; 

					
				});    */
                                     $(".save-button").click(function(){

                                          var serializeddata =$("#for_form").serialize();
					 
					  var url ='../modules/psmodthemeoptionpanel/psmodthemeoptionpanel_ajax.php';

					var data = {
						type: "sccoptiondata",
						action: "of_ajax_post_action",
						data: serializeddata
					};
					
					$.post(url, data, function(response) {
						var success = $("#scc-popup-save");
						var loading = $(".scc-loading-img");
						loading.fadeOut();  
						success.fadeIn();
						window.setTimeout(function(){
						   success.fadeOut(); 
						   
												
						}, 2000);
					});
					
					return false; 

					
				});   
       
                                //AJAX Remove
                                    jQuery(".reset_button").click(function(){
			
					var selected_object = jQuery(this);
					var selected_id = jQuery(this).attr("id");
					var theID = jQuery(this).attr("title");	
	
					var url = "../modules/psmodthemeoptionpanel/psmodthemeoptionpanel_ajax.php";
				
					var data = {
						action: "of_ajax_post_action",
						type: "image_reset",
						data: theID
					};
					
					jQuery.post(url, data, function(response) {
						var image_to_remove = jQuery("#image_" + theID);
						var button_to_hide = jQuery("#reset_" + theID);
						image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
						button_to_hide.fadeOut();
						selected_object.parent().prev("input").val("");
						
						
						
					});
					
					return false; 
					
				});

	styleSelect = {
		init: function () {
		$(".for-body-selected").each(function () {
			$(this).prepend("<span>" + $(this).find(".select option:selected").text() + "</span>");
		});
		$(".select").live("change", function () {
			$(this).prev("span").replaceWith("<span>" + $(this).find("option:selected").text() + "</span>");
		});
		$(".select").bind($.browser.msie ? "click" : "change", function(event) {
			$(this).prev("span").replaceWith("<span>" + $(this).find("option:selected").text() + "</span>");
		}); 
		}
	};
        styleSelect.init()


	$('.cb-enable').click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
	});
	$('.cb-disable').click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);
	});




  
                $('#perfec_shop_body_font_face').change(function(){ 
                    var googlefonts = $("option:selected", this).val();
                    var googlefontid = googlefonts.split(':');
                    if ($('head').find('link#googlefontlink').length < 1){
                        $('head').append('<link id="googlefontlink" href="" type="text/css" rel="stylesheet"/>');
                    }
                    $('link#googlefontlink').attr({href:'http://fonts.googleapis.com/css?family=' + googlefontid}); 
                    $("style#googlefontstyle").remove();
                    $('head').append('<style id="googlefontstyle" type="text/css">#demo_google h5{ font-family:' + googlefonts + ' !important; }</style>'); 
                });  
                
            /*  $('#fshop_shop_body_font_face').change(function(){ 
                    var systemfont = $("option:selected", this).val();
                    $("style#ststemfontstyle").remove();
                    $('head').append('<style id="ststemfontstyle"  type="text/css">#demo_system h6{ font-family:' + systemfont + ' !important; }</style>'); 
                });  */
 


});	

     $(document).ready(function () {
		
                 var loadgooglefont=$('#perfec_shop_body_font_face').val();
                 var googlefont_id = loadgooglefont.split(':');
               
                 if ($('head').find('link#googlefontlink').length < 1){
                        $('head').append('<link id="googlefontlink" href="" type="text/css" rel="stylesheet"/>');
                    }
                    $('link#googlefontlink').attr({href:'http://fonts.googleapis.com/css?family=' + googlefont_id}); 
                    $("style#fontstyle").remove();
                    $('head').append('<style id="fontstyle" type="text/css">#demo_google h5{ font-family:' + loadgooglefont + '; }</style>'); 
                    
                 /* var stylefont_id=$('#fshop_shop_body_font_face').val();    
                $("style#systemlodostyle").remove();
                 $('head').append('<style id="systemlodostyle"  type="text/css">#demo_system h6{ font-family:' + stylefont_id + '; }</style>'); 
                 */
	});
        

        
                
                