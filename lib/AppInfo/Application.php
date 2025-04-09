<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2017 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\JSLoader\AppInfo;

use OC\Security\CSP\ContentSecurityPolicy;
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
	public const APP_ID = 'jsloader';

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
