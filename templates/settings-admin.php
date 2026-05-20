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

<form id="jsloader-form" class="section" data-cachebuster="<?php print_unescaped($_['cachebuster']); ?>">
	<h2 class="inlineblock"><?php p($l->t('JavaScript loader')); ?></h2>
	<label for="jsloader-snippet">
		<?php p($l->t('Paste the JS code snippet here. It will be loaded on every page.')); ?>
	</label>
	<textarea id="jsloader-snippet"><?php print_unescaped($_['snippet']); ?></textarea>
	<label for="jsloader-url"><?php p($l->t('Domain where external JavaScript is loaded from.')); ?></label>
	<input id="jsloader-url" aria-describedby="jsloader-url-hint" name="jsloader-url" type="url" value="<?php print_unescaped($_['url']); ?>">
	<div id="jsloader-url-hint" class="hint">
		<?php p($l->t('This is needed to work with the CSP policy that is in place. It is tried to automatically detect this based on the snippet above if empty.')); ?>
	</div>
	<button id="jsloader-save" class="btn btn-primary" disabled="disabled" type="submit"><?php p($l->t('Save')); ?></button>
	<span id="jsloader-message" class="msg"></span>
</form>
