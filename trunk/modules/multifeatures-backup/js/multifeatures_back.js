function renderMultifeatures() {
    var container = false,
	features_wrapper = false,
	prepared_features = {},
	parent = false,
	parent_id_split = false,
	parent_id = false,
	collections = $('select[id^=feature_]');
	
    if (collections.length > 0) {
	collections.each(function(){
	    parent = $(this);
	    parent_id_split = parent.attr('id').match(/(\w+)\_(\d+)\_(\w+)/);
	    
	    if (typeof(parent_id_split) == 'object' && parent_id_split.length > 0) {
		parent_id = parseInt(parent_id_split[2]);
		
		if ( ! isNaN(parent_id) && parent_id > 0) {
		    var options = (parent.children('option'));
		    
		    options.each(function(){
			if ($(this).html().substring(0, 3) != '---') {
			    if (typeof(prepared_features[parent_id]) == 'undefined') {
				prepared_features[parent_id] = {};
			    }
			    
			    prepared_features[parent_id][parseInt($(this).attr('value'))] = $(this).html().replace(/\s{2,}/g, '').replace('&nbsp;', '');
			}
		    });
		    
		    parent.hide();
		    
		    container = parent.parent('td');
		    
		    features_wrapper = $(document.createElement('ul')).addClass('multifeatures_wrapper').css('display', 'none');
		    
		    for (var id_feature_value in prepared_features[parent_id]) {
			features_wrapper
			    .append($(document.createElement('li'))
				.append($(document.createElement('input')).attr({'type': 'checkbox', 'name': 'multifeature[' + parent_id + '][]', 'rel': parent_id, 'value': id_feature_value}).addClass('multifeature_checkbox'))
				.append($(document.createElement('span')).css('padding-left', '12px').html(prepared_features[parent_id][id_feature_value]))
			    );
		    }
		    
		    container.append($(document.createElement('a')).addClass('button control multifeaturesExpand').attr('href', '#').html(' ' + stringExpand).click(function(evt){
			evt.preventDefault();
			
			if ($(this).is('.multifeaturesExpand')) {
			    $(this).next('.multifeatures_wrapper').slideDown('fast');
			    $(this).fadeOut('fast', function(){
				$(this).removeClass('multifeaturesExpand').addClass('multifeaturesCollapse').html(' ' + stringCollapse).prepend($(document.createElement('img')).attr('src', '../img/admin/disabled.gif'));
				$(this).fadeIn('fast');
			    });
			}
			else {
			    $(this).next('.multifeatures_wrapper').slideUp('fast');
			    $(this).fadeOut('fast', function(){
				$(this).removeClass('multifeaturesCollapse').addClass('multifeaturesExpand').html(' ' + stringExpand).prepend($(document.createElement('img')).attr('src', '../img/admin/add.gif'));
				$(this).fadeIn('fast');
			    });
			}
		    }).prepend($(document.createElement('img')).attr('src', '../img/admin/add.gif')));
		    container.append(features_wrapper);
		}
	    }
	});
    }
    
    $('.multifeature_checkbox').live('click', function(){$('.custom_' + $(this).attr('rel') + '_').val('')});
    
    if (typeof(pfeatures) == 'object' && pfeatures != null) {
	for (var id_selected_feature in pfeatures) {
	    var feature_container = $('input[name^=multifeature\\[' + id_selected_feature + '\\]]');
	    
	    if (feature_container.length > 0) {
		feature_container.each(function(){
		    if (typeof(pfeatures[id_selected_feature][$(this).attr('value')]) != 'undefined') {
			$(this).attr('checked', true);
		    }
		});
	    }
	}
    }
}

$(function(){
    var tab = $('#product-tab-content-Features'),
	currentTab = false;
	
    var regex = new RegExp('[\\?&]key_tab=([^&#]*)');
    var currentTab = regex.exec(window.location.search);
    
    if (currentTab != null && decodeURIComponent(currentTab[1].replace(/\+/g, " ")) == 'Features') {
	$(document).ajaxStop(function(){
	    if (tab.is(':visible') && $('.multifeatures_wrapper').length == 0) {
		renderMultifeatures();
	    }
	});
    }	
    
    tab.watch('display', function(){
	if (tab.is(':visible') && $('.multifeatures_wrapper').length == 0) {
	    renderMultifeatures();
	}
    });
});