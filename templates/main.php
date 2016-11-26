<?php
$nonce = \OC::$server->getContentSecurityPolicyNonceManager()->getNonce();
$base = \OC::$server->getURLGenerator()->linkTo('fuel', '');

function riot_tag($base, $nonce, $name) {
?>
<script src="<?php print_unescaped($base) ?>js/tags/<?php print_unescaped($name); ?>.html" type="riot/tag" nonce="<?php p($nonce); ?>"></script>
<?php
}

style('fuel', 'fuel');

script('fuel', 'vendor/riot/riot+compiler');
script('fuel', 'vendor/chart.js/dist/Chart');
script('fuel', 'riotcontrol');
script('fuel', 'vehiclestore');
script('fuel', 'recordstore');

/**
 * Main JS file
 */
script('fuel', 'fuel');

riot_tag($base, $nonce, 'fuel-app');
riot_tag($base, $nonce, 'navigation');
riot_tag($base, $nonce, 'record-list');
riot_tag($base, $nonce, 'vehicle-statistics');
riot_tag($base, $nonce, 'line-chart');
?>

<fuel-app id="app"></fuel-app>

<script type="text/javascript" nonce="<?php p($nonce); ?>">
	console.log('Mounting tags …');

	RiotControl.addStore(new VehicleStore());
	RiotControl.addStore(new RecordStore());

	riot.mount('*');
</script>
