<?php
/**
 * @copyright Copyright (c) 2017 Morris Jobke <hey@morrisjobke.de>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/** @var array $_ */
/** @var \OCP\IL10N $l */
script('jsloader', 'admin');
style('jsloader', 'admin');
?>

<div id="jsloader-section" class="section" data-cachebuster="<?php print_unescaped($_['cachebuster']); ?>">
	<h2 class="inlineblock"><?php p($l->t('JavaScript loader')); ?></h2>
	<p>
		<?php p($l->t('Paste the JS code snippet here. It will be loaded on every page.')); ?>
	</p>
	<textarea id="jsloader-snippet"><?php print_unescaped($_['snippet']); ?></textarea>
	<label for="jsloader-url"><?php p($l->t('Domain where external JavaScript is loaded from. This is needed to work with the CSP policy that is in place. It is tried to automatically detect this based on the snippet above if empty.')); ?></label>
	<input id="jsloader-url" name="jsloader-url" type="text" value="<?php print_unescaped($_['url']); ?>">
	<button id="jsloader-save" class="btn btn-primary" disabled="disabled">Save</button>
	<span id="jsloader-message" class="msg"></span>
</div>
