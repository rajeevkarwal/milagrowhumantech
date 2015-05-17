
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
	$("#td-popup-patterns-save").center();
	$("#td-popup-save").center();
	$("#td-popup-reset").center();
			
	$(window).scroll(function() { 
                $("#td-popup-patterns-save").center();
		$("#td-popup-save").center();
		$("#td-popup-reset").center();
	});
			
	$(".radio-box-picture").click(function(){
		$(this).parent().parent().find(".radio-box-picture").removeClass("add-radio-picture");
		$(this).addClass("add-radio-picture");
	});
	$(".for-radio-picture-label").hide();
	$(".radio-box-picture").show();
	$(".of-radio-img-radio").hide();

	$(".td-radio-tile-img").click(function(){
		$(this).parent().parent().find(".td-radio-tile-img").removeClass("td-radio-tile-selected");
		$(this).addClass("td-radio-tile-selected");
	});
        
	$(".of-radio-tile-label").hide();
	$(".td-radio-tile-img").show();
	$(".td-radio-tile-radio").hide();
        
        $(".tab-pane:first").fadeIn(); 
        $("#sidenav li:first").addClass("active");
      
			//AJAX Upload
			$(".upload_button").each(function(){
			
			var selected_object = $(this);
			var selected_id = $(this).attr("id");	
			new AjaxUpload(selected_id, {
				  action: "../modules/tdproductsslider/tdproductsslider_ajax.php",
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
                                }); 
       
                                     $(".save-button").click(function(){

                                          var serializeddata =$("#for_form").serialize();
					 
					  var url ='../modules/tdproductsslider/tdproductsslider_ajax.php';

					var data = {
						type: "tdoptiondata",
						action: "of_ajax_post_action",
						data: serializeddata
					};
					
					$.post(url, data, function(response) {
						var success = $("#td-popup-save");
						var loading = $(".td-loading-img");
						loading.fadeOut();  
						success.fadeIn();
						window.setTimeout(function(){
						   success.fadeOut(); 
						   
												
						}, 2000);
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






$(document).ready(function () {
		styleSelect.init()  
            $('.option select#themesdev_slider_type').change(function(){
               
                var select_id=$(this).val();
               
                
                
                switch(select_id){
                    case "selected_products":
                         $("#themesdev_number_pro").parent(".sectionupload").hide();
                         
                         
                        $('#themesdev_number_pro').hide();
                         
                          
                          
                          $('.well ul#sidenav li.themeoption').hide();
                          $('.well ul#sidenav li.products').show();
                    break;
                    case "show_one_selected_category":
                    $('.well ul#sidenav li.products').hide();
                    $('.well ul#sidenav li.themeoption').show();
                     $('#numberofcount').show();
                  break;
                     case "special_products":
                    $('.well ul#sidenav li.products').hide();
                    $('.well ul#sidenav li.themeoption').hide();
                     $('#numberofcount').show();
                  break;
                   case "best_sell_products":
                    $('.well ul#sidenav li.products').hide();
                    $('.well ul#sidenav li.themeoption').hide();
                     $('#numberofcount').show();
                  break;
                   case "new_products":
                    $('.well ul#sidenav li.products').hide();
                    $('.well ul#sidenav li.themeoption').hide();
                     $('#numberofcount').show();
                  break;
                   case "featured_products":
                    $('.well ul#sidenav li.products').hide();
                    $('.well ul#sidenav li.themeoption').hide();
                     $('#numberofcount').show();
                  break;
                   }   
            }); 
            
        
                
	})
    

});	

  