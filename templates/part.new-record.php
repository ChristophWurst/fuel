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

<script id="new-record-template" type="text/html">
	<form>
		<div class="new-record-input">
			<input name="odo"
			       type="number"
			       placeholder="<?php p($l->t('Odometer')); ?>">
		</div>
		<div class="new-record-input">
			<input name="date"
			       type="date"
			       placeholder="<?php p($l->t('Date')); ?>">
		</div>
		<div class="new-record-input">
			<input name="fuel"
			       type="number"
			       placeholder="<?php p($l->t('Fuel')); ?>">
		</div>
		<div class="new-record-input">
			<input name="price"
			       type="number"
			       placeholder="<?php p($l->t('Price')); ?>">
		</div>
		<div class="new-record-input">
			<!-- placeholder -->
		</div>
		<div class="new-record-input">
			<input name="price"
			       type="submit"
			       value="<?php p($l->t('Add')); ?>">
		</div>
	</form>
</script>