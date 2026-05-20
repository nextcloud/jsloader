/*!
 * SPDX-License-Identifier: AGPL-3.0-or-later
 * SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
 */

/**
 * @type {HTMLFormElement}
 */
export const formElement = getElementById('jsloader-form')

/**
 * @type {HTMLInputElement}
 */
export const urlInputElement = getElementById('jsloader-url')

/**
 * @type {HTMLTextAreaElement}
 */
export const textareaElement = getElementById('jsloader-snippet')

/**
 * @type {HTMLButtonElement}
 */
export const saveButtonElement = getElementById('jsloader-save')

/**
 * @type {HTMLElement}
 */
export const iconElement = getElementById('jsloader-message')

/**
 * Get an element by its id and throw an error if it is not found
 *
 * @param {string} id - The id of the element to find
 * @return {HTMLElement} The found element
 */
function getElementById(id) {
	const el = document.getElementById(id)
	if (el === null) {
		throw new Error(`Element with id ${id} not found`)
	}
	return el
}