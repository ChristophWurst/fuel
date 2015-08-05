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
		<%= id %>
	</a>
</script>
