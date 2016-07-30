(function($jq){$jq(document).ready(function(){$jq('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();$jq(".ma-more-img li a").click(function(){$jq("a.ma-a-lighbox").attr("href",$jq(this).attr("title"));});});function format(str){for(var i=1;i<arguments.length;i++){str=str.replace('%'+(i-1),arguments[i]);}return str;}function CloudZoom(jWin,opts){var sImg=$jq('img',jWin);var img1;var img2;var zoomDiv=null;var $jqmouseTrap=null;var lens=null;var $jqtint=null;var softFocus=null;var $jqie6Fix=null;var zoomImage;var controlTimer=0;var cw,ch;var destU=0;var destV=0;var currV=0;var currU=0;var filesLoaded=0;var mx,my;var ctx=this,zw;setTimeout(function(){if($jqmouseTrap===null){var w=jWin.width();jWin.parent().append(format('<div style="width:%0px;position:absolute;top:75%;left:%1px;text-align:center" class="cloud-zoom-loading" >Loading...</div>',w/3,(w/2)-(w/6))).find(':last').css('opacity',0.5);}},200);var ie6FixRemove=function(){if($jqie6Fix!==null){$jqie6Fix.remove();$jqie6Fix=null;}};this.removeBits=function(){if(lens){lens.remove();lens=null;}if($jqtint){$jqtint.remove();$jqtint=null;}if(softFocus){softFocus.remove();softFocus=null;}ie6FixRemove();$jq('.cloud-zoom-loading',jWin.parent()).remove();};this.destroy=function(){jWin.data('zoom',null);if($jqmouseTrap){$jqmouseTrap.unbind();$jqmouseTrap.remove();$jqmouseTrap=null;}if(zoomDiv){zoomDiv.remove();zoomDiv=null;}this.removeBits();};this.fadedOut=function(){if(zoomDiv){zoomDiv.remove();zoomDiv=null;}this.removeBits();};this.controlLoop=function(){if(lens){var x=(mx-sImg.offset().left-(cw*0.5))>>0;var y=(my-sImg.offset().top-(ch*0.5))>>0;if(x<0){x=0;}else if(x>(sImg.outerWidth()-cw)){x=(sImg.outerWidth()-cw);}if(y<0){y=0;}else if(y>(sImg.outerHeight()-ch)){y=(sImg.outerHeight()-ch);}lens.css({left:x,top:y});lens.css('background-position',(-x)+'px '+(-y)+'px');destU=(((x)/sImg.outerWidth())*zoomImage.width)>>0;destV=(((y)/sImg.outerHeight())*zoomImage.height)>>0;currU+=(destU-currU)/opts.smoothMove;currV+=(destV-currV)/opts.smoothMove;zoomDiv.css('background-position',(-(currU>>0)+'px ')+(-(currV>>0)+'px'));}controlTimer=setTimeout(function(){ctx.controlLoop();},30);};this.init2=function(img,id){filesLoaded++;if(id===1){zoomImage=img;}if(filesLoaded===2){this.init();}};this.init=function(){$jq('.cloud-zoom-loading',jWin.parent()).remove();$jqmouseTrap=jWin.parent().append(format("<div class='mousetrap' style='background:#fff;opacity:0;filter:alpha(opacity=0);z-index:99;position:absolute;width:%0px;height:%1px;left:%2px;top:%3px;\'></div>",sImg.outerWidth(),sImg.outerHeight(),0,0)).find(':last');$jqmouseTrap.bind('mousemove',this,function(event){mx=event.pageX;my=event.pageY;});$jqmouseTrap.bind('mouseleave',this,function(event){clearTimeout(controlTimer);if(lens){lens.fadeOut(299);}if($jqtint){$jqtint.fadeOut(299);}if(softFocus){softFocus.fadeOut(299);}zoomDiv.fadeOut(300,function(){ctx.fadedOut();});return false;});$jqmouseTrap.bind('mouseenter',this,function(event){mx=event.pageX;my=event.pageY;zw=event.data;if(zoomDiv){zoomDiv.stop(true,false);zoomDiv.remove();}var xPos=opts.adjustX,yPos=opts.adjustY;var siw=sImg.outerWidth();var sih=sImg.outerHeight();var w=opts.zoomWidth;var h=opts.zoomHeight;if(opts.zoomWidth=='auto'){w=siw;}if(opts.zoomHeight=='auto'){h=sih;}var appendTo=jWin.parent();switch(opts.position){case'top':yPos-=h;break;case'right':xPos+=siw;break;case'bottom':yPos+=sih;break;case'left':xPos-=w;break;case'inside':w=siw;h=sih;break;default:appendTo=$jq('#'+opts.position);if(!appendTo.length){appendTo=jWin;xPos+=siw;yPos+=sih;}else{w=appendTo.innerWidth();h=appendTo.innerHeight();}}zoomDiv=appendTo.append(format('<div id="cloud-zoom-big" class="cloud-zoom-big" style="display:none;position:absolute;left:%0px;top:%1px;width:%2px;height:%3px;background-image:url(\'%4\');z-index:99;"></div>',xPos,yPos,w,h,zoomImage.src)).find(':last');if(sImg.attr('title')&&opts.showTitle){zoomDiv.append(format('<div class="cloud-zoom-title">%0</div>',sImg.attr('title'))).find(':last').css('opacity',opts.titleOpacity);}if($jq.browser.msie&&$jq.browser.version<7){$jqie6Fix=$jq('<iframe frameborder="0" src="#"></iframe>').css({position:"absolute",left:xPos,top:yPos,zIndex:99,width:w,height:h}).insertBefore(zoomDiv);}zoomDiv.fadeIn(500);if(lens){lens.remove();lens=null;}if(typeof event.data.zoomDivWidth=='undefined'){event.data.zoomDivWidth=zoomDiv.get(0).offsetWidth-(zoomDiv.css('border-left-width').replace(/\D/g,'')*1)-(zoomDiv.css('border-right-width').replace(/\D/g,'')*1);}if(typeof event.data.zoomDivHeight=='undefined'){event.data.zoomDivHeight=zoomDiv.get(0).offsetHeight-(zoomDiv.css('border-top-width').replace(/\D/g,'')*1)-(zoomDiv.css('border-bottom-width').replace(/\D/g,'')*1);}cw=(sImg.outerWidth()/zoomImage.width)*event.data.zoomDivWidth;ch=(sImg.outerHeight()/zoomImage.height)*event.data.zoomDivHeight;lens=jWin.append(format("<div class = 'cloud-zoom-lens' style='display:none;z-index:98;position:absolute;width:%0px;height:%1px;'></div>",cw,ch)).find(':last');$jqmouseTrap.css('cursor',lens.css('cursor'));var noTrans=false;if(opts.tint){lens.css('background','url("'+sImg.attr('src')+'")');$jqtint=jWin.append(format('<div style="display:none;position:absolute; left:0px; top:0px; width:%0px; height:%1px; background-color:%2;" />',sImg.outerWidth(),sImg.outerHeight(),opts.tint)).find(':last');$jqtint.css('opacity',opts.tintOpacity);noTrans=true;$jqtint.fadeIn(500);}if(opts.softFocus){lens.css('background','url("'+sImg.attr('src')+'")');softFocus=jWin.append(format('<div style="position:absolute;display:none;top:2px; left:2px; width:%0px; height:%1px;" />',sImg.outerWidth()-2,sImg.outerHeight()-2,opts.tint)).find(':last');softFocus.css('background','url("'+sImg.attr('src')+'")');softFocus.css('opacity',0.5);noTrans=true;softFocus.fadeIn(500);}if(!noTrans){lens.css('opacity',opts.lensOpacity);}if(opts.position!=='inside'){lens.fadeIn(500);}zw.controlLoop();return;});};img1=new Image();$jq(img1).load(function(){ctx.init2(this,0);});img1.src=sImg.attr('src');img2=new Image();$jq(img2).load(function(){ctx.init2(this,1);});img2.src=jWin.attr('href');}$jq.fn.CloudZoom=function(options){try{document.execCommand("BackgroundImageCache",false,true);}catch(e){}this.each(function(){var relOpts,opts;eval('var	a = {'+$jq(this).attr('rel')+'}');relOpts=a;if($jq(this).is('.cloud-zoom')){$jq(this).css({'position':'relative','display':'block'});$jq('img',$jq(this)).css({'display':'block'});if($jq(this).parent().attr('id')!='wrap'){$jq(this).wrap('<div id="wrap" style="top:0px;z-index:99;position:relative;"></div>');}opts=$jq.extend({},$jq.fn.CloudZoom.defaults,options);opts=$jq.extend({},opts,relOpts);$jq(this).data('zoom',new CloudZoom($jq(this),opts));}else if($jq(this).is('.cloud-zoom-gallery')){opts=$jq.extend({},relOpts,options);$jq(this).data('relOpts',opts);$jq(this).bind('click',$jq(this),function(event){var data=event.data.data('relOpts');$jq('#'+data.useZoom).data('zoom').destroy();$jq('#'+data.useZoom).attr('href',event.data.attr('href'));$jq('#'+data.useZoom+' img').attr('src',event.data.data('relOpts').smallImage);$jq('#'+event.data.data('relOpts').useZoom).CloudZoom();return false;});}});return this;};$jq.fn.CloudZoom.defaults={zoomWidth:'auto',zoomHeight:'auto',position:'right',tint:false,tintOpacity:0.5,lensOpacity:0.5,softFocus:false,smoothMove:3,showTitle:false,titleOpacity:0.5,adjustX:0,adjustY:0};})(jQuery);