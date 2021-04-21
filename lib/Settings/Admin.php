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

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IL10N;
use OCP\ILogger;
use OCP\Settings\ISettings;
use OCP\IConfig;

class Admin implements ISettings {

	/** @var IL10N */
	private $l;

	/** @var ILogger */
	private $logger;

	/** @var IConfig */
	private $config;

	public function __construct(
		IL10N $l,
		ILogger $logger,
		IConfig $config
	) {
		$this->l = $l;
		$this->logger = $logger;
		$this->config = $config;
	}

	/**
	 * @return TemplateResponse
	 */
	public function getForm() {
		$parameters = [
			'snippet' => $this->config->getAppValue('jsloader', 'snippet', ''),
			'url' => $this->config->getAppValue('jsloader', 'url', ''),
			'cachebuster' => $this->config->getAppValue('jsloader', 'cachebuster', '0'),
		];

		return new TemplateResponse('jsloader', 'settings-admin', $parameters, '');
	}

	/**
	 * @return string the section ID, e.g. 'sharing'
	 */
	public function getSection() {
		return 'jsloader';
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 * the admin section. The forms are arranged in ascending order of the
	 * priority values. It is required to return a value between 0 and 100.
	 *
	 * E.g.: 70
	 */
	public function getPriority() {
		return 70;
	}
}
