<tr class="wds-keyword-pair" data-idx="{{- idx }}">
	<td class="wds-pair-keyword">{{- keywords }}</td>
	<td class="wds-pair-url">{{- url }}</td>
	<td class="wds-pair-actions">
		{{ if (idx) { }}
			<?php
				$this->_render('links-dropdown', array(
					'label' => "{{- Wds.l10n('keywords', 'Options') }}",
					'links' => array(
						"#edit"   => "{{- Wds.l10n('keywords', 'Edit') }}",
						"#remove" => "{{- Wds.l10n('keywords', 'Remove') }}"
					)
				));
			?>
		{{ } }}
	</td>
	<td class="wds-pair-hidden-fields">
		<input type="hidden" class="wds-pair-keyword-field" value="{{- keywords }}" />
		<input type="hidden" class="wds-pair-url-field" value="{{- url }}"  />
	</td>
</tr>