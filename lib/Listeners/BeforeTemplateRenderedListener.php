<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\JSLoader\Listeners;

use OC\Security\CSP\ContentSecurityPolicyNonceManager;
use OCA\JSLoader\AppInfo\Application;
use OCP\AppFramework\Http\Events\BeforeLoginTemplateRenderedEvent;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IAppConfig;
use OCP\IURLGenerator;
use OCP\Util;

/**
 * Listener to add the configured domain to the Content Security Policy to allow loading JS from there.
 *
 * @template-implements IEventListener<BeforeTemplateRenderedEvent|BeforeLoginTemplateRenderedEvent>
 */
class BeforeTemplateRenderedListener implements IEventListener {

	public function __construct(
		private readonly IAppConfig $appConfig,
		private readonly IURLGenerator $urlGenerator,
		private readonly ContentSecurityPolicyNonceManager $contentSecurityPolicyNonceManager,
	) {
	}

	public function handle(Event $event): void {
		if (!($event instanceof BeforeTemplateRenderedEvent) && !($event instanceof BeforeLoginTemplateRenderedEvent)) {
			return;
		}

		$snippet = $this->appConfig->getValueString(Application::APP_ID, 'snippet', '');
		if ($snippet === '') {
			return;
		}

		$linkToJs = $this->urlGenerator->linkToRoute('jsloader.JS.script', [
			'v' => $this->appConfig->getValueString(Application::APP_ID, 'cachebuster', '0'),
		]);

		Util::addHeader(
			'script',
			[
				'src' => $linkToJs,
				'nonce' => $this->contentSecurityPolicyNonceManager->getNonce()
			], ''
		);
	}
}
