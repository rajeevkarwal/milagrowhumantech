function locateFeaturesHtml() {
    var features_block = $('#idTabFeatures');
    
    return features_block.length > 0 ? features_block : false;
}

function replaceNativeFeatures() {
    if (typeof(pfeatures) == 'object' && pfeatures != null) {
	var features_block = locateFeaturesHtml();
	
	features_block.empty();
	
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
		    currentBlock = $(document.createElement('div')).addClass('feautres_wrap');
		    currentList = $(document.createElement('ul'));
		}
		
		currentList.append($(document.createElement('li')).html(feature.value));
		
		index++;
	    }
	    
	    features_block.append(currentBlock.append($(document.createElement('h4')).html(feature.name)).append(currentList));
	}
    }
}

$(function(){
    //replaceNativeFeatures();
});