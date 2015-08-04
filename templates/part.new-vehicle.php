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

<script id="new-vehicle-template" type="text/html">
	<li class="<%= showButton() %>">
		<a id="new-vehicle-btn">
			<?php p($l->t('New vehicle')); ?>
		</a>
	</li>
	<li>
		<div>
			<div class="new-vehicle-add-dialog <%= showDialog() %>">
				<span>
					<input class="new-vehicle-name" type="text">
					<input class="new-vehicle-add primary icon-checkmark-white" type="button">
				</span>
			</div>
		</div>
	</li>
</script>