<?php
$nonce = \OC::$server->getContentSecurityPolicyNonceManager()->getNonce();
$base = \OC::$server->getURLGenerator()->linkTo('fuel', '');

/**
 * JavaScript libraries
 */
script('fuel', 'vendor/riot/riot+compiler');

/**
 * Main JS file
 */
script('fuel', 'fuel');
?>

<fuel-app id="app"></fuel-app>

<script src="<?php print_unescaped($base) ?>js/tags/fuel-app.html" type="riot/tag" nonce="<?php p($nonce); ?>"></script>

<script type="text/javascript" nonce="<?php p($nonce); ?>">
		console.log('hello darkness');

		riot.mount('fuel-app');
</script>
