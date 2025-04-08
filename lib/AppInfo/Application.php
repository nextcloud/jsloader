<?php
declare(strict_types=1);

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

namespace OCA\JSLoader\AppInfo;

use OC\Security\CSP\ContentSecurityPolicy;
use OC\Security\CSP\ContentSecurityPolicyManager;
use OC\Security\CSP\ContentSecurityPolicyNonceManager;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\IAppConfig;
use OCP\IURLGenerator;
use OCP\Security\IContentSecurityPolicyManager;
use OCP\Server;
use OCP\Util;

class Application extends App implements IBootstrap {
	const APP_ID = 'jsloader';

	public function __construct(array $urlParams = []) {
		parent::__construct(self::APP_ID, $urlParams);
	}

	public function register(IRegistrationContext $context): void {
		// nothing to do here
	}

	public function boot(IBootContext $context): void {
		$appConfig = Server::get(IAppConfig::class);
		$urlGenerator = Server::get(IURLGenerator::class);
		$contentSecurityPolicyManager = Server::get(IContentSecurityPolicyManager::class);
		$contentSecurityPolicyNonceManager = Server::get(ContentSecurityPolicyNonceManager::class);

		$snippet = $appConfig->getValueString(self::APP_ID, 'snippet', '');
		if ($snippet !== '') {
			$linkToJs = $urlGenerator->linkToRoute('jsloader.JS.script', [
				'v' => $appConfig->getValueString(self::APP_ID, 'cachebuster', '0'),
			]);

			Util::addHeader(
				'script',
				[
					'src' => $linkToJs,
					'nonce' => $contentSecurityPolicyNonceManager->getNonce()
				], ''
			);

			// whitelist the URL to allow loading JS from this external domain
			$url = $appConfig->getValueString(self::APP_ID, 'url');
			if ($url !== '') {
				$policy = new ContentSecurityPolicy();
				$policy->addAllowedScriptDomain($url);
				$policy->addAllowedImageDomain($url);
				$policy->addAllowedConnectDomain($url);
				$contentSecurityPolicyManager->addDefaultPolicy($policy);
			}
		}
	}
}
