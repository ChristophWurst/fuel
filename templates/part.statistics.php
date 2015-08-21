<?php
/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */
?>

<script id="statistics-template" type="text/html">
	<div class="charts">
		<div class="tile">
			<div>
				<?php p($l->t('Average fuel consumption')); ?>: <%= averageConsumption %>
			</div>
			<div>
				<?php p($l->t('Average price')); ?>: <%= averagePrice %>
			</div>

		</div>
		<div class="tile">
			<div class="chart-title">
				<h3><?php p($l->t('Fuel consumption')); ?></h3>
			</div>
			<div class="chart-container">
				<canvas class="consumption-chart"></canvas>
			</div>
		</div>
		<div class="tile">
			<div class="chart-title">
				<h3><?php p($l->t('Odometer')); ?></h3>
			</div>
			<div class="chart-container">
				<canvas class="odo-chart"></canvas>
			</div>
		</div>
		<div class="tile">
			<div class="chart-title">
				<h3><?php p($l->t('Price')); ?></h3>
			</div>
			<div class="chart-container">
				<canvas class="price-chart"></canvas>
			</div>
		</div>
	</div>
</script>