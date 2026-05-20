<?php

/**
 * SPDX-FileCopyrightText: 2017 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OC\Security\CSP;

/**
 * @package OC\Security\CSP
 */
class ContentSecurityPolicyNonceManager {

	/**
	 * Returns the current CSP nonce
	 */
	public function getNonce(): string {
	}
	/**
	 * Check if the browser supports CSP v3
	 */
	public function browserSupportsCspV3(): bool {
	}
}
