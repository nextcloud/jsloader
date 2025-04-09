<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2017 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\JSLoader\Controller;

use OCA\JSLoader\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataDownloadResponse;
use OCP\AppFramework\Http\Response;
use OCP\AppFramework\Services\IAppConfig;
use OCP\IRequest;

class JSController extends Controller {
	public function __construct(
		IRequest $request,
		private IAppConfig $appConfig,
	) {
		parent::__construct(Application::APP_ID, $request);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @PublicPage
	 *
	 * @return Response
	 */
	public function script() {
		$jsCode = $this->appConfig->getAppValueString('snippet', '');
		if ($jsCode !== '') {
			$jsCode = "window.addEventListener('DOMContentLoaded', () => { $jsCode });";
		}
		return new DataDownloadResponse($jsCode, 'script', 'text/javascript');
	}
}
