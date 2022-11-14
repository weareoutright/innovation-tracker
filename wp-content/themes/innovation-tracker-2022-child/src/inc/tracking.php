<!--START UTILITIES TRACKING-->

<link rel="preconnect" href="https://www.googletagmanager.com" />

<link rel="preconnect" href="https://www.google-analytics.com" />

<link rel="preconnect" href="https://utility.edf.org" />



<!--[if IE ]><script type="text/javascript" src="https://cdn.polyfill.io/v3/polyfill.min.js"></script><![endif]-->

<!--[if !IE]>--><script>

  if (!Array.prototype.forEach || !Array.prototype.includes || !Object.assign || !Object.entries || !Object.keys || !document.querySelector || typeof navigator.sendBeacon !== 'function' || !JSON) {

    document.write("<script src='https://polyfill.io/v3/polyfill.min.js?flags=gated%2Calways&features=Array.prototype.includes%2CArray.prototype.forEach%2CObject.assign%2CObject.entries%2CObject.keys%2CJSON%2Cnavigator.sendBeacon%2Cdocument.querySelector%2CURL%2CElement.prototype.placeholder%2CIntersectionObserver'>\x3C/script>");

  }

</script><!--<![endif]-->



<script type="text/javascript" src="https://browser.sentry-cdn.com/7.0.0/bundle.min.js"></script>

<script>if (window.performance && performance.mark) performance.mark('utilities_start');</script>



<?php $trackingRefresh = date('YmdH') ?>

<?php function get_the_post_id() { if (is_single()) { global $post; return $post->ID; } else { return false; } } ?>

<meta id="dataAdmin" content="<?php if (current_user_can('edit_posts')) {print('true');} else {print ('false');} ?>" data-nid="<?php if (get_the_post_id()) { print get_the_post_id();} ?>" <?php body_class(); ?>>



<?php print('<script type="text/javascript" src="https://www.edf.org/assets/global/dist/js/utilities.min.js?v='.$trackingRefresh.'"></script>'); ?>

<?php print('<script>window.$EDF || document.write("<script src=https://www.edf.org/assets/global/dist/js/utilities.min.js?v='.$trackingRefresh.'>\x3C/script>")</script>'); ?>



<script>

  if (window.performance && performance.mark){

    performance.mark('utilities_end');

    performance.measure('utilities_span', 'utilities_start', 'utilities_end');

  }

</script>

<!--END UTILITIES TRACKING-->