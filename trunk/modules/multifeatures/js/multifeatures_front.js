function locateFeaturesHtml() {
    var features_block = $('#idTab2');
    
    return features_block.length > 0 ? features_block : false;
}

function sortFeatures() {
    if (typeof(feature_positions) == 'object' && feature_positions != null && $.map(feature_positions, function(n, i) { return i; }).length > 0) {
	var featureRow,
	    multifeatureWrapper;
	    
	for (var i in feature_positions) {
	    featureRow = $('#feature_' + i);
	    
	    if (featureRow.length > 0) {
		featureRow.prependTo('#global_features_wrapper');

		if (feature_positions[i].length) {
		    multifeatureWrapper = featureRow.find('.features_wrap');
		    
		    for (var y in feature_positions[i]) {
			multifeatureWrapper = featureRow.find('#value_' + feature_positions[i][y]);
			
			if (multifeatureWrapper.length) {
			    multifeatureWrapper.prependTo(featureRow.find('ul'));
			}
		    }	
		}
	    }
	}
    }
}

function replaceNativeFeatures() {
    if (typeof(pfeatures) == 'object' && pfeatures != null) {
	var features_block = locateFeaturesHtml();
	
	features_block.empty().append($(document.createElement('li')).attr('id', 'global_features_wrapper'));
	
	var index = 0,
	    feature = false,
	    currentBlock = false,
	    currentList = false;
	
	for (var id_feature in pfeatures) {
	    index = 0;
	    currentBlock = false;
	    currentList = false;
	    
	    for (var id_feature_value in pfeatures[id_feature]) {
		feature = pfeatures[id_feature][id_feature_value];
		
		if (index == 0) {
		    currentBlock = $(document.createElement('div')).addClass('features_wrap').attr('id', 'feature_' + id_feature);
		    currentList = $(document.createElement('ul'));
		}
		
		currentList.append($(document.createElement('li')).attr('id', 'value_' + id_feature_value).html(feature.value));
		
		index++;
	    }
	    
	    $('#global_features_wrapper').append(currentBlock.append($(document.createElement('h4')).html(feature.name)).append(currentList));
	}
    }
}

$(function(){
    replaceNativeFeatures();
    sortFeatures();
});