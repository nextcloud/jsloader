/**
 * SPDX-FileCopyrightText: 2017 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { formElement, textareaElement, urlInputElement } from './elements.mjs'
import { onSave, onSnippetChange, onUrlChange } from './handlers.mjs'

// As this is a module script the content is executed after the DOM is ready
// setup event handlers on the input elements
formElement.addEventListener('submit', onSave)
textareaElement.addEventListener('input', onSnippetChange)
urlInputElement.addEventListener('input', onUrlChange)
