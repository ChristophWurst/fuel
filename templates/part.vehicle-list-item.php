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
<script id="vehicle-list-item-template" type="text/html">
	<a href="#vehicles/<%= id %>">
		<%= name %>
	</a>
	<div class="app-navigation-entry-utils">
		<ul>
			<li class="app-navigation-entry-utils-menu-button">
				<button title="<?php p($l->t('Menu')); ?>"></button>
			</li>
		</ul>
	</div>
	<div class="app-navigation-entry-menu <%= menuOpened() %>">
		<ul>	
			<li>
				<button class="icon-delete delete-vehicle" title="<?php p($l->t('Delete vehicle')); ?>">
				</button>
			</li>
		</ul>
	</div>
</script>

