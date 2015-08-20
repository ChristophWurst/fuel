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

<script type="text/html" id="vehicle-import-template">
	<button class="import-local-btn icon-upload svg button-icon-label"
		title="<?php p($l->t('Import Fuelio CSV')); ?>"></button>
	<button class="import-oc-btn icon-upload svg button-icon-label"
		title="<?php p($l->t('Import Fuelio CSV from files')); ?>"></button>
	<input class="local-import hidden"
	       type="file">
</script>