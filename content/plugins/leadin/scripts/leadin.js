(function($) {
  'use strict';
  // HubSpot Env
  var leadinConfig = window.leadin_config || {};
  var i18n = window.leadin_i18n || {};
  var hubspotBaseUrl = leadinConfig.hubspotBaseUrl;
  var portalId = leadinConfig.portalId;

  /**
   * Raven
   */
  function configureRaven() {
    if (leadinConfig.env !== 'prod') {
      return;
    }

    Raven.config(
      'https://e9b8f382cdd130c0d415cd977d2be56f@exceptions.hubspot.com/1'
    ).install();

    Raven.setUserContext({
      hub: leadinConfig.portalId,
      wp: leadinConfig.wpVersion,
      php: leadinConfig.phpVersion,
      v: leadinConfig.leadinPluginVersion,
      plugins: Object.keys(leadinConfig.plugins)
        .map(function(name, index) {
          return name + '#' + leadinConfig.plugins[name].Version;
        })
        .join(','),
    });
  }

  /**
   * Event Bus
   */
  function EventBus() {
    var bus = $({});

    return {
      trigger: function() {
        bus.trigger.apply(bus, arguments);
      },
      on: function(event, callback) {
        bus.on(event, Raven.wrap(callback));
      },
    };
  }

  /**
   * DOM
   */
  var domElements = {
    iframe: document.getElementById('leadin-iframe'),
    allMenuButtons: $(
      '.toplevel_page_leadin > a, .toplevel_page_leadin > ul > li > a'
    ),
    subMenuButtons: $('.toplevel_page_leadin > ul > li'),
  };

  /**
   * Sidebar navigation
   *
   * Prevent page reloads when navigating from inside the plugin
   */
  function initNavigation() {
    function setSelectedMenuItem() {
      domElements.subMenuButtons.removeClass('current');
      const pageParam = window.location.search.match(/\?page=leadin_?\w*/)[0]; // filter page query param
      const selectedElement = $('a[href="admin.php' + pageParam + '"]');
      selectedElement.parent().addClass('current');
    }

    function handleNavigation() {
      const appRoute = window.location.search.match(/page=leadin_?(\w*)/)[1];
      HubspotPluginAPI.changeRoute(appRoute);
      setSelectedMenuItem();
    }

    // Browser back and forward events navigation
    window.addEventListener('popstate', handleNavigation);

    // Menu Navigation
    domElements.allMenuButtons.click(function(event) {
      event.preventDefault();
      window.history.pushState(null, null, $(this).attr('href'));
      handleNavigation();
    });
  }

  /**
   * Chatflows Menu Button
   */
  function initChatflows() {
    var leadinMenu = document.getElementById('toplevel_page_leadin');
    var firstSubMenu = leadinMenu && leadinMenu.querySelector('.wp-first-item');
    var chatflowsUrl = hubspotBaseUrl + '/chatflows/' + portalId;
    var chatflowsHtml =
      '<li><a href="' +
      chatflowsUrl +
      '" target="_blank">' +
      i18n.chatflows +
      '</a></li>';
    if (firstSubMenu) {
      firstSubMenu.insertAdjacentHTML('afterend', chatflowsHtml);
    }
  }

  /**
   * Interframe
   */
  var Interframe = (function() {
    var eventBus = new EventBus();

    function handleMessage(message) {
      eventBus.trigger('message', message);
    }

    function handleMessageEvent(event) {
      if (event.origin === hubspotBaseUrl) {
        try {
          const data = JSON.parse(event.data);
          handleMessage(data);
        } catch (e) {
          // Error in parsing message
        }
      }
    }

    function postMessage(message) {
      domElements.iframe.contentWindow.postMessage(
        JSON.stringify(message),
        hubspotBaseUrl
      );
    }

    return {
      init: function() {
        window.addEventListener('message', handleMessageEvent);
      },
      onMessage: function(callback) {
        eventBus.on('message', callback);
      },
      postMessage: postMessage,
      reply: function(message, payload) {
        var newMessage = Object.assign({}, message);
        newMessage.response = payload;
        postMessage(newMessage);
      },
    };
  })();

  /**
   * HubspotPluginUI API
   *
   * All outgoing messages are defined here
   */
  var HubspotPluginAPI = (function() {
    function setConfig() {
      Interframe.postMessage({ leadin_config: leadinConfig });
    }

    function changeRoute(route) {
      Interframe.postMessage({ leadin_change_route: route });
    }

    var api = {
      setConfig: setConfig,
      changeRoute: changeRoute,
    };

    return api;
  })();

  /**
   * Bridge API
   *
   * All incoming messages are handled here
   */
  var MessagesHandlers = (function() {
    var eventBus = new EventBus();

    eventBus.on('leadin_parent_ajax', function(event, payload, reply) {
      var ajaxPayload = Object.assign(
        {
          complete: Raven.wrap(function(jqXHR, textStatus) {
            var response = Object.assign({ textStatus: textStatus }, jqXHR);
            reply(response);
          }),
          error: Raven.wrap(function(jqXHR) {
            var message;

            try {
              message = JSON.parse(jqXHR.responseText).error;
            } catch (e) {
              message = jqXHR.responseText;
            }

            Raven.captureMessage(
              'AJAX request failed with code ' + jqXHR.status + ': ' + message
            );
            // TODO: sentry
          }),
        },
        payload
      );
      $.ajax(ajaxPayload);
    });

    eventBus.on('leadin_page_reload', function() {
      window.location.reload();
    });

    eventBus.on('leadin_get_config', function() {
      HubspotPluginAPI.setConfig();
    });

    eventBus.on('leadin_clear_query_param', function() {
      var currentWindowLocation = window.location.toString();
      if (currentWindowLocation.indexOf('?') > 0) {
        currentWindowLocation = currentWindowLocation.substring(
          0,
          currentWindowLocation.indexOf('?')
        );
      }
      var newWindowLocation = currentWindowLocation + '?page=leadin';
      window.history.pushState({}, '', newWindowLocation);
    });

    return {
      start() {
        Interframe.onMessage(function(event, message) {
          function reply(payload) {
            Interframe.reply(message, payload);
          }

          for (var command in message) {
            eventBus.trigger(command, [message[command], reply]);
          }
        });
      },
    };
  })();

  /**
   * Main
   */
  function main() {
    MessagesHandlers.start();
    Interframe.init();

    // Enable App Navigation only when viewing the plugin
    if (window.location.search.indexOf('page=leadin') !== -1) {
      initNavigation();
    }

    initChatflows();
  }

  configureRaven();
  Raven.context(main);
})(jQuery);
