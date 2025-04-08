<?php
/**
 * SPDX-FileCopyrightText: 2017 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

use OCA\JSLoader\AppInfo\Application;
use OCP\Util;

/** @var array $_ */
/** @var \OCP\IL10N $l */
Util::addScript(Application::APP_ID, 'admin');
Util::addStyle(Application::APP_ID, 'admin');
?>

<div id="jsloader-section" class="section" data-cachebuster="<?php print_unescaped($_['cachebuster']); ?>">
	<h2 class="inlineblock"><?php p($l->t('JavaScript loader')); ?></h2>
	<p>
		<?php p($l->t('Paste the JS code snippet here. It will be loaded on every page.')); ?>
	</p>
	<textarea id="jsloader-snippet"><?php print_unescaped($_['snippet']); ?></textarea>
	<label for="jsloader-url"><?php p($l->t('Domain where external JavaScript is loaded from. This is needed to work with the CSP policy that is in place. It is tried to automatically detect this based on the snippet above if empty.')); ?></label>
	<input id="jsloader-url" name="jsloader-url" type="text" value="<?php print_unescaped($_['url']); ?>">
	<button id="jsloader-save" class="btn btn-primary" disabled="disabled"><?php p($l->t('Save')); ?></button>
	<span id="jsloader-message" class="msg"></span>
</div>
