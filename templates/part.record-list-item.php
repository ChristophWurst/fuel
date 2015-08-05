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

<script id="record-list-item-template" type="text/html">
	<a href="#vehicle/<%= vehicleId %>/record/<%= id %>"
	   class="<%= active ? 'active' : ''%>">
		<div class="record-container">
			<div class="record-date">
				<%= date %>
			</div>
			<div class="record-odo">
				<%= odo %>km
			</div>
			<div class="record-fuel">
				<%= fuel %>l
			</div>
			<div class="record-distance">
				+<%= 140 %>km
			</div>
			<div class="record-consumption">
				<%= 5.8 %>l/100km
			</div>
		</div>
	</a>
</script>
