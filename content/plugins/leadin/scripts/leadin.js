(function() {
  'use strict';
  // Elements
  var leadinMenu = document.getElementById('toplevel_page_leadin');
  var firstSubMenu = leadinMenu && leadinMenu.querySelector('.wp-first-item');

  // HubSpot Env
  var leadinConfig = window.leadin_config || {};
  var hsEnv = leadinConfig.env || 'prod';
  var hubspotBaseUrl =
    'https://app.hubspot' + (hsEnv === 'prod' ? '' : 'qa') + '.com';
  var portalId = leadinConfig.portalId;

  function addChatflowsToMenu() {
    var chatflowsUrl = hubspotBaseUrl + '/chatflows/' + portalId;
    var chatflowsHtml =
      '<li><a href="' + chatflowsUrl + '" target="_blank">Chatflows</a></li>';
    if (firstSubMenu) {
      firstSubMenu.insertAdjacentHTML('afterend', chatflowsHtml);
    }
  }

  function main() {
    addChatflowsToMenu();
  }

  main();
})();
