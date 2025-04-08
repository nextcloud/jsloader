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

namespace OCA\JSLoader\Settings;

use OCA\JSLoader\AppInfo\Application;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Services\IAppConfig;
use OCP\IL10N;
use OCP\Settings\ISettings;
use Psr\Log\LoggerInterface;

class Admin implements ISettings {

	public function __construct(
		private IL10N $l,
		private LoggerInterface $logger,
		private IAppConfig $appConfig,
	) {
	}

	/**
	 * @return TemplateResponse
	 */
	public function getForm() {
		$parameters = [
			'snippet' => $this->appConfig->getAppValueString('snippet', ''),
			'url' => $this->appConfig->getAppValueString('url', ''),
			'cachebuster' => $this->appConfig->getAppValueString('cachebuster', '0'),
		];

		return new TemplateResponse(Application::APP_ID, 'settings-admin', $parameters, '');
	}

	/**
	 * @return string the section ID, e.g. 'sharing'
	 */
	public function getSection() {
		return Application::APP_ID;
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 *             the admin section. The forms are arranged in ascending order of the
	 *             priority values. It is required to return a value between 0 and 100.
	 *
	 * E.g.: 70
	 */
	public function getPriority() {
		return 70;
	}
}
