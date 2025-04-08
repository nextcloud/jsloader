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
