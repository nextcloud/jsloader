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

$(document).ready(function() {

	var urlRegex = /https?:\/\/([^\/]+)/,
		$urlInput = $('#jsloader-url'),
		$textarea = $('#jsloader-snippet'),
		$section = $('#jsloader-section'),
		$saveButton = $section.find('button'),
		cachebuster = parseInt($section.data('cachebuster'));

	$('#jsloader-save').on('click', function(event) {
		event.preventDefault();

		var selector = '#jsloader-message',
			snippetValue = $textarea.val(),
			urlValue = $urlInput.val();

		$textarea.prop('disabled', true);
		$urlInput.prop('disabled', true);
		OC.msg.startSaving(selector);

		OCP.AppConfig.setValue('jsloader', 'snippet', snippetValue, {
			success: function(){
				$textarea.prop('disabled', false);

				OCP.AppConfig.setValue('jsloader', 'url', urlValue, {
					success: function(){
						$urlInput.prop('disabled', false);
						OC.msg.finishedSuccess(selector, t('settings', 'Saved'));
					},
					error: function(){
						$urlInput.prop('disabled', false);
						OC.msg.finishedError(selector, t('jsloader', 'Error while saving'));
					}
				});
			},
			error: function(){
				$textarea.prop('disabled', false);
				$urlInput.prop('disabled', false);
				OC.msg.finishedError(selector, t('jsloader', 'Error while saving'));
			}
		});

		cachebuster += 1;
		OCP.AppConfig.setValue('jsloader', 'cachebuster', cachebuster);
	});

	/**
	 * try to detect an URL from the snippet input
	 */
	$textarea.on('change', function() {
		var value = $textarea.val(),
			result = urlRegex.exec(value);

		if ($urlInput.val() === '' && result !== null) {
			$urlInput.val(result[1]);
		}

		$saveButton.prop('disabled', false);
	});

	$urlInput.on('change', function() {
		$saveButton.prop('disabled', false);
	})
});
