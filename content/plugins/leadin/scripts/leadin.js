(function($) {
  'use strict';
  // HubSpot Env
  var leadinConfig = window.leadinConfig || {};
  var i18n = window.leadinI18n || {};
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
      'https://e9b8f382cdd130c0d415cd977d2be56f@exceptions.hubspot.com/1',
      {
        instrument: {
          tryCatch: false,
        },
      }
    ).install();

    Raven.setTagsContext({
      leadin: leadinConfig.leadinPluginVersion,
      php: leadinConfig.phpVersion,
      wordpress: leadinConfig.wpVersion,
    });

    Raven.setUserContext({
      hub: leadinConfig.portalId,
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
    iframe: $('#leadin-iframe'),
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

    function postMessage(message) {
      domElements.iframe[0].contentWindow.postMessage(
        JSON.stringify(message),
        hubspotBaseUrl
      );
    }

    function handleMessage(message) {
      function reply(payload) {
        const newMessage = Object.assign({}, message);
        newMessage.response = payload;
        postMessage(newMessage);
      }

      let key;
      for (key in message) {
        eventBus.trigger(key, [message[key], reply]);
      }
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

    return {
      init: function() {
        window.addEventListener('message', handleMessageEvent);
      },
      onMessage: function(key, callback) {
        eventBus.on(key, function() {
          callback.apply(null, Array.prototype.slice.call(arguments, 1));
        });
      },
      postMessage: postMessage,
    };
  })();

  /**
   * WordPress plugin API
   */
  var WordPressPluginApi = (function() {
    function makeRequest(action, method, payload, success, error) {
      const url = leadinConfig.ajaxUrl + '?action=' + action;
      const ajaxPayload = {
        url: url,
        method: method,
        contentType: 'application/json',
        success:
          typeof success === 'function'
            ? Raven.wrap(function(data) {
                success(JSON.parse(data));
              })
            : undefined,
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

          if (typeof error === 'function') {
            error();
          }
        }),
      };

      if (payload) {
        ajaxPayload.data = JSON.stringify(payload);
      }

      $.ajax(ajaxPayload);
    }

    function post(action, payload, success, error) {
      return makeRequest(action, 'POST', payload, success, error);
    }

    function get(action, success, error) {
      return makeRequest(action, 'GET', null, success, error);
    }

    function enterFullScreen() {
      domElements.iframe.addClass('leadin-iframe-fullscreen');
    }

    function exitFullScreen() {
      domElements.iframe.removeClass('leadin-iframe-fullscreen');
    }
    return {
      connect: function(portalId, success, error) {
        post(
          'leadin_registration_ajax',
          { portalId: portalId },
          success,
          error
        );
      },
      disconnect: post.bind(null, 'leadin_disconnect_ajax', {}),
      getPortal: get.bind(null, 'leadin_get_portal'),
      getDomain: get.bind(null, 'leadin_get_domain'),
      markAsOutdated: get.bind(null, 'leadin_mark_outdated'),
      enterFullScreen: enterFullScreen,
      exitFullScreen: exitFullScreen,
    };
  })();

  /**
   * HubspotPluginUI API
   *
   * All incoming and outgoing messages are defined here
   */
  var HubspotPluginAPI = (function() {
    function changeRoute(route) {
      Interframe.postMessage({ leadin_change_route: route });
    }

    function createHandler(key) {
      return Interframe.onMessage.bind(Interframe, key);
    }

    var api = {
      changeRoute: changeRoute,
      onInterframeReady: createHandler('leadin_interframe_ready'),
      onConnect: createHandler('leadin_connect_portal'),
      onDisconnect: createHandler('leadin_disconnect_portal'),
      onPageReload: createHandler('leadin_page_reload'),
      onInitNavigation: createHandler('leadin_init_navigation'),
      onClearQueryParam: createHandler('leadin_clear_query_param'),
      onGetDomain: createHandler('leadin_get_wp_domain'),
      onMarkAsOutdated: createHandler('leadin_mark_outdated'),
      onUpgrade: createHandler('leadin_upgrade'),
      onEnterFullScreen: createHandler('leadin_enter_fullscreen'),
      onExitFullScreen: createHandler('leadin_exit_fullscreen'),
    };

    return api;
  })();

  /**
   * Messages handlers
   *
   * All incoming messages are handled here
   */
  var initMessageHandlers = function() {
    HubspotPluginAPI.onInterframeReady(function(message, reply) {
      reply('Interframe Ready');
    });

    HubspotPluginAPI.onConnect(function(portalId, reply) {
      WordPressPluginApi.connect(
        portalId,
        function() {
          PortalPoll.clear();
          reply({ success: true });
        },
        reply.bind(null, { success: false })
      );
    });

    HubspotPluginAPI.onDisconnect(function(message, reply) {
      WordPressPluginApi.disconnect(
        reply.bind(null, { success: true }),
        reply.bind(null, { success: false })
      );
    });

    HubspotPluginAPI.onMarkAsOutdated(function(message, reply) {
      WordPressPluginApi.markAsOutdated(function() {
        reply();
      });
    });

    HubspotPluginAPI.onUpgrade(function(message, reply) {
      reply();
      location.href = leadinConfig.adminUrl + 'plugins.php';
    });

    HubspotPluginAPI.onPageReload(function() {
      window.location.reload(true);
    });

    HubspotPluginAPI.onInitNavigation(function(message, reply) {
      initNavigation();
      reply('SPA Navigation Started');
    });

    HubspotPluginAPI.onClearQueryParam(function() {
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

    HubspotPluginAPI.onGetDomain(function(message, reply) {
      WordPressPluginApi.getDomain(function(data) {
        if (data.domain) {
          reply(data.domain);
        }
      });
    });

    HubspotPluginAPI.onEnterFullScreen(function(message, reply) {
      WordPressPluginApi.enterFullScreen();
      reply();
    });

    HubspotPluginAPI.onExitFullScreen(function(message, reply) {
      WordPressPluginApi.exitFullScreen();
      reply();
    });
  };

  /**
   * Reload as soon as a portal was assigned. This prevents multiple registration happening
   */
  const PortalPoll = (function() {
    let timeout;
    let stop = false;

    return {
      init: function() {
        timeout = setTimeout(function() {
          WordPressPluginApi.getPortal(function(data) {
            if (data.portalId) {
              location.reload(true);
            } else if (!stop) {
              PortalPoll.init();
            }
          }, PortalPoll.init);
        }, 5000);
      },
      clear: function() {
        clearTimeout(timeout);
        stop = true;
      },
    };
  })();

  /**
   * Main
   */
  function main() {
    initMessageHandlers();
    Interframe.init();

    // Enable App Navigation only when viewing the plugin
    if (window.location.search.indexOf('page=leadin') !== -1) {
      if (!leadinConfig.portalId) {
        PortalPoll.init();
      }
    }

    initChatflows();
  }

  configureRaven();
  Raven.context(main);
})(jQuery);
