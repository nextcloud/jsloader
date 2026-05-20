/*!
 * SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { formElement, iconElement, saveButtonElement, textareaElement, urlInputElement } from "./elements.mjs"

const URL_REGEX = /https?:\/\/([^\/]+)/

/**
 * Handle the change event on the snippet textarea.
 * If the URL input is empty, try to detect an URL from the snippet and fill it in.
 * Otherwise just enable the save button.
 *
 * @return {void}
 */
export function onSnippetChange() {
	saveButtonElement.disabled = false

	if (urlInputElement.value === '' || !urlInputElement.validity.valid) {
		const match = URL_REGEX.exec(textareaElement.value)
		if (match !== null) {
			urlInputElement.value = match[1]
		}
	}
}

/**
 * Handle the change event on the URL input.
 *
 * If the URL is valid, enable the save button.
 * Otherwise show an error message and keep the save button disabled.
 */
export function onUrlChange() {
	urlInputElement.setCustomValidity('')

	if (urlInputElement.value !== '' && urlInputElement.checkValidity?.() !== false) {
		try {
			// some browsers do not properly validate the URL, so re-do it manually
			new URL(urlInputElement.value)
		} catch {
			urlInputElement.setCustomValidity('Invalid URL')
		}
	}
	saveButtonElement.disabled = false
	urlInputElement.reportValidity()
}

/**
 * Handle the click event on the save button
 *
 * @param {SubmitEvent} event - the submit event
 * @return {Promise<void>}
 */
export async function onSave(event) {
	event.preventDefault()
	const urlValue = urlInputElement.value
	const snippetValue = textareaElement.value

	if (urlValue !== '' && !urlInputElement.checkValidity()) {
		urlInputElement.reportValidity()
		return
	}

	try {
		textareaElement.disabled = true
		urlInputElement.disabled = true

		await new Promise((success, error) => OCP.AppConfig.setValue('jsloader', 'snippet', snippetValue, { success, error }))
		textareaElement.disabled = false

		await new Promise((success, error) => OCP.AppConfig.setValue('jsloader', 'url', urlValue, { success, error }))
		urlInputElement.disabled = false
		showSuccess()

		const cacheBuster = String(Number.parseInt(formElement.dataset.cachebuster) + 1)
		await new Promise((success, error) => OCP.AppConfig.setValue('jsloader', 'cachebuster', cacheBuster, { success, error }))
		formElement.dataset.cachebuster = cacheBuster
	} catch (error) {
		console.error('[jsloader] Failed to save the configuration', error)
		showError()
	} finally {
		textareaElement.disabled = false
		urlInputElement.disabled = false
	}
}

/**
 * Shows a loading icon in the message element
 */
function showLoading() {
	iconElement.classList.remove('icon-success')
	iconElement.classList.remove('icon-error')
	iconElement.classList.add('icon-loading')
}

/**
 * Shows a success icon in the message element
 */
function showSuccess() {
	iconElement.classList.remove('icon-loading')
	iconElement.classList.remove('icon-error')
	iconElement.classList.add('icon-success')
}

/**
 * Shows an error icon in the message element
 */
function showError() {
	iconElement.classList.remove('icon-loading')
	iconElement.classList.remove('icon-success')
	iconElement.classList.add('icon-error')
}