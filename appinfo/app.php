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

namespace OCA\JSLoader\Appinfo;

use OC\Security\CSP\ContentSecurityPolicy;

$config = \OC::$server->getConfig();

$snippet = $config->getAppValue('jsloader', 'snippet', '');

if ($snippet !== '') {
	$linkToJs = \OC::$server->getURLGenerator()->linkToRoute(
		'jsloader.JS.script',
		[
			'v' => $config->getAppValue('jsloader', 'cachebuster', '0'),
		]
	);
	\OCP\Util::addHeader(
		'script',
		[
			'src' => $linkToJs,
			'nonce' => \OC::$server->getContentSecurityPolicyNonceManager()->getNonce()
		], ''
	);

	// whitelist the URL to allow loading JS from this external domain
	$url = $config->getAppValue('jsloader', 'url');
	if ($url !== '') {
		$CSPManager = \OC::$server->getContentSecurityPolicyManager();
		$policy = new ContentSecurityPolicy();
		$policy->addAllowedScriptDomain($url);
		$policy->addAllowedImageDomain($url);
		$policy->addAllowedConnectDomain($url);
		$policy->addAllowedFrameDomain($url);
		$CSPManager->addDefaultPolicy($policy);
	}
}
