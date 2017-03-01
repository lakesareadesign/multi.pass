window.Wds = window.Wds || {};

/**
 * General scoped variable getter
 *
 * @param {String} scope Scope to check for variable
 * @param {String} string Particular varname
 *
 * @return {String} Found value or false
 */
window.Wds.get = window.Wds.get || function (scope, varname) {
	scope = scope || 'general';
	return (window['_wds_' + scope] || {})[varname] || false;
}

/**
 * Fetch localized string for a particular context
 *
 * @param {String} scope Scope to check for strings
 * @param {String} string Particular string to check for
 *
 * @return {String} Localized string
 */
window.Wds.l10n = window.Wds.l10n || function (scope, string) {
	return (Wds.get(scope, 'strings') || {})[string] || string;
}

/**
 * Fetch template for a particular context
 *
 * @param {String} scope Scope to check for templates
 * @param {String} string Particular template to check for
 *
 * @return {String} Template markup
 */
window.Wds.template = window.Wds.template || function (scope, template) {
	return (Wds.get(scope, 'templates') || {})[template] || '';
}