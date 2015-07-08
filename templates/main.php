<?php

/**
 * JavaScript libraries
 */
script('fuel', 'lib/node_modules/backbone/backbone-min');
script('fuel', 'lib/node_modules/handlebars/dist/handlebars.min');
script('fuel', 'lib/node_modules/backbone.marionette/lib/backbone.marionette.min');

/**
 * JavaScript files
 */
script('fuel', 'controllers/VehicleController');
script('fuel', 'models/record');
script('fuel', 'models/vehicle');
script('fuel', 'views/record');
script('fuel', 'views/records');
script('fuel', 'views/vehicle');
script('fuel', 'views/vehicles');
script('fuel', 'fuel');

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