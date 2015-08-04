<?php
/**
 * JavaScript libraries
 */
script('fuel', 'lib/node_modules/requirejs/require');

/**
 * Main JS file
 */
script('fuel', 'require_config');

/**
 * CSS style sheets
 */
style('fuel', 'style');
?>

<div id="app">
	<div id="app-navigation">
		<?php print_unescaped($this->inc('part.navigation')); ?>
		<?php print_unescaped($this->inc('part.settings')); ?>
	</div>

	<div id="app-content">
		<div id="app-content-wrapper">
			<div id="record-list">
			</div>
			<div id="statistics">
			</div>
		</div>
	</div>
</div>

<?php
/**
 * Templates
 */
print_unescaped($this->inc('part.vehicle-list-item'));
