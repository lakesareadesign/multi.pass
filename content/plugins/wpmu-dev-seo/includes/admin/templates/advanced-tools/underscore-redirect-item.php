<?php

$this->_render('advanced-tools/advanced-tools-redirect-item', array(
	'source'                   => '{{- source }}',
	'destination'              => '{{- destination }}',
	'index'                    => '{{- index }}',
	'string_permanent'         => "{{- Wds.l10n('redirects', 'Permanent (301)') }}",
	'string_temporary'         => "{{- Wds.l10n('redirects', 'Temporary (302)') }}",
	'string_options'           => "{{- Wds.l10n('redirects', 'Options') }}",
	'string_remove'            => "{{- Wds.l10n('redirects', 'Remove') }}",
	'maybe_permanent_selected' => "{{- selected_type == 301 ? 'selected=\"selected\"' : '' }}",
	'maybe_temporary_selected' => "{{- selected_type == 302 ? 'selected=\"selected\"' : '' }}",
));