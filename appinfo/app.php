<?php

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015, 2016
 */

namespace OCA\AbceDf\AppInfo;

use OCP\AppFramework\App;

$app = new App('Fuel');
$container = $app->getContainer();

$container->query('OCP\INavigationManager')->add(function () use ($container) {
	$urlGenerator = $container->query('OCP\IURLGenerator');
	$l10n = $container->query('OCP\IL10N');
	return [
		'id' => 'fuel',
		'order' => 10,
		// the route that will be shown on startup
		'href' => $urlGenerator->linkToRoute('fuel.page.index'),
		// the icon that will be shown in the navigation
		'icon' => $urlGenerator->imagePath('fuel', 'app.svg'),
		'name' => $l10n->t('Fuel'),
	];
});
