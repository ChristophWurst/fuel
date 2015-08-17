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
	<div>
		<?php p($l->t('Average fuel consumption')); ?>: <%= averageConsumption %>
	</div>
	<div>
		<?php p($l->t('Average price')); ?>: <%= averagePrice %>
	</div>
</script>