$jq(document).ready(function(){$jq("#back-top").hide();$jq(function(){$jq(window).scroll(function(){if($jq(this).scrollTop()>100){$jq('#back-top').fadeIn();}else{$jq('#back-top').fadeOut();}});$jq('#back-top').click(function(){$jq('body,html').animate({scrollTop:0},800);return false;});});});