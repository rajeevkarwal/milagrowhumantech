/**
 * Created with JetBrains PhpStorm.
 * User: Neha
 * Date: 12/2/13
 * Time: 12:49 PM
 * To change this template use File | Settings | File Templates.
 */

/** Fancy box settings */
$(document).ready(function() {

	/* This is basic - uses default settings */

	$("a#single_image").fancybox();

	/* Using custom settings */

	$("a#inline").fancybox({
		'hideOnContentClick': true
	});

	/* Apply fancybox to multiple items */

	$("a.thickbox").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600,
		'speedOut'		:	200,
		'overlayShow'	:	true
	});

	});