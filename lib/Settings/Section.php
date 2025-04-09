<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2017 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\JSLoader\Settings;

use OCA\JSLoader\AppInfo\Application;
use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\Settings\IIconSection;

class Section implements IIconSection {
	public function __construct(
		private IURLGenerator $url,
		private IL10N $l,
	) {
	}

	/**
	 * returns the ID of the section. It is supposed to be a lower case string,
	 * e.g. 'ldap'
	 *
	 * @returns string
	 */
	public function getID() {
		return Application::APP_ID;
	}

	/**
	 * returns the translated name as it should be displayed, e.g. 'LDAP / AD
	 * integration'. Use the L10N service to translate it.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->l->t('JavaScript loader');
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 *             the settings navigation. The sections are arranged in ascending order of
	 *             the priority values. It is required to return a value between 0 and 99.
	 *
	 * E.g.: 70
	 */
	public function getPriority() {
		return 70;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIcon() {
		return $this->url->imagePath('core', 'actions/edit.svg');
	}
}
