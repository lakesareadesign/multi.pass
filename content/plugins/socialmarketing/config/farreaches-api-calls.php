<?php
/**
 *  TODO: NOTES:
 *  1) This file will be automatically generated in the future as part of the deployment process
 *  2) The Api call names are purposely decoupled from the names used internally in the server (this is why the api call names show up as constants.)
 *     a) allows different set of standard parameters to the similar api calls ( public/TemporaryApiKey and api/TemporaryApiKey for example )
 *     b) allows server to vary api name without affecting any keys/caches on the plugin.
 *  3) In future, this api file may be sent to the plugin as part of its configuration process.
 */

return array(
        /**
         * 1. Used for all calls to api that the public api can initiate.
         * ( Initial call to trigger the plugin registration.
         */
        FarReaches_Api_Call::API_KEY_INITIALIZE => FarReaches_Api_Call_Read::instantiate('public/TemporaryApiKey')->no_key()->fail_on_key_fail(),
        /**
         * 1. Preregister .On activation, the plugin checks to see if the current wordpress instance is known.
         * If the server is down, or a http ... ? status that means uri not known, then continue with
         * brand new registration.
         * if known then plugin goes right to RegisterPlugin
         *
         */
        FarReaches_Api_Call::API_KEY_PREREGISTER => FarReaches_Api_Call_Write::instantiate('public/PreRegister')->no_permanent_key()->async(),
        /**
         * 2. Which allows the users to get their permanent api key (which is readonly)
         * (also does FarReaches_Api_Call::API_UPDATE_ACCOUNT, FarReaches_Api_Call::API_UPDATE_USERS )
         */
        FarReaches_Api_Call::API_REGISTER_PLUGIN => FarReaches_Api_Call_Write::instantiate('api/RegisterPlugin')->fail_on_key_fail()->no_permanent_key(),
        /**
         * On the general settings page the user has altered something.
         * (also does FarReaches_Api_Call::API_UPDATE_USERS )
         */
        FarReaches_Api_Call::API_UPDATE_ACCOUNT => FarReaches_Api_Call_Write::instantiate('api/UpdateAccount'),
        /**
         * Used when only user information needs to be changed.
         * OR to get a new api key for a user. Because of this we need to set no_permanent_key() so that in ( FarReaches_Communication::initiate_secured_api_call() the correct api to get a key is called )
         */
        FarReaches_Api_Call::API_UPDATE_USERS => FarReaches_Api_Call_Write::instantiate('api/AlterUsers')->no_permanent_key(),
        // used when the user(s)' keys are invalidated and they need to be refreshed ( but plugin is not being registered)
        FarReaches_Api_Call::API_KEY_PERMANENT => FarReaches_Api_Call_Read::instantiate('api/PermanentApiKey')->set_property_name("permanentApiKeys")->fail_on_key_fail(),
        /**
         * 3. the permanent api key can then be used to get a temporary api key for 1-time only write calls.
         * Note: we do NOT have fail_on_key_fail() set because if this fails it means the original permanent key is bad and needs to be re-retrieved
         */
        FarReaches_Api_Call::API_KEY_TEMPORARY => FarReaches_Api_Call_Read::instantiate('api/TemporaryApiKey')->async(),
        /**
         * This happens on a schedule.
         * refresh call to update.
         *   FarReaches_Api_Call::ACTIVE_FEATURES
         *   FarReaches_Api_Call::ACTIVE_FEATURE_SET_DEFINITIONS
         *   FarReaches_Api_Call::CONFIGURATION_CONSTANTS
         *   FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST
         *   FarReaches_Api_Call::KNOWN_MESSAGE_EXTERNAL_IDS
         */
        FarReaches_Api_Call::API_PERIODIC_REFRESH => FarReaches_Api_Call_Read::instantiate('api/PeriodicRefresh'),

        FarReaches_Api_Call::API_KEY_DIAGNOSTIC => FarReaches_Api_Call_Read::instantiate('api/DiagnosticApiKey')->async(),
        FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST => FarReaches_Api_Call_Read::instantiate('api/MessageEndPointList',
              array(
                'messageEndPointTypes' => array('ext'),
                'messageEndPointCompleteList' => 'true'))->set_property_name()->cachable(),

        FarReaches_Api_Call::MESSAGE_ENDPOINT_ACTIVATE => FarReaches_Api_Call_Write::instantiate('api/ActivateMessageEndPoint', array(FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST)),
        FarReaches_Api_Call::MESSAGE_ENDPOINT_INACTIVATE => FarReaches_Api_Call_Write::instantiate('api/InactivateMessageEndPoint', array(FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST)),
        FarReaches_Api_Call::MESSAGE_ENDPOINT_CATEGORIES_CONFIGURE => FarReaches_Api_Call_Write::instantiate('api/ConfigureMessagePointCategories', array(FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST)),
        FarReaches_Api_Call::KNOWN_MESSAGE_EXTERNAL_IDS  => FarReaches_Api_Call_Read::instantiate('api/KnownMessageExternalIds')->set_property_name()->cachable(),
        // not cachable at the api level this point because results returned determined by the posts being asked for status. special case caching is handled)
        FarReaches_Api_Call::POST_STATUSES => FarReaches_Api_Call_Read::instantiate('api/EnvelopeStatusList')->set_property_name(),
        FarReaches_Api_Call::POST_PUBLISH => FarReaches_Api_Call_Write::instantiate('api/CreateAlert', array(FarReaches_Api_Call::POST_STATUSES, FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST)),
        FarReaches_Api_Call::POST_REVOKE => FarReaches_Api_Call_Write::instantiate('api/CreateRevoke', array(FarReaches_Api_Call::POST_STATUSES, FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST)),
        FarReaches_Api_Call::CATEGORY_REGISTER => FarReaches_Api_Call_Write::instantiate('api/Category'),
        FarReaches_Api_Call::EXTERNAL_SERVICE_CONFIGURE => FarReaches_Api_Call_Write::instantiate('api/ConfigureExtServices'),
        FarReaches_Api_Call::CHARGE_CUSTOMER => FarReaches_Api_Call_Write::instantiate('api/ChargeCustomer', array(FarReaches_Api_Call::ACTIVE_FEATURES)),
        FarReaches_Api_Call::ACTIVE_FEATURES => FarReaches_Api_Call_Read::instantiate('api/ActiveFeatures')->set_property_name()->cachable(),
        FarReaches_Api_Call::ENABLE_FEATURE => FarReaches_Api_Call_Read::instantiate('api/EnableFeature', array(FarReaches_Api_Call::ACTIVE_FEATURES)),
        FarReaches_Api_Call::DISABLE_FEATURE => FarReaches_Api_Call_Read::instantiate('api/DisableFeature', array(FarReaches_Api_Call::ACTIVE_FEATURES)),
        FarReaches_Api_Call::ACTIVE_FEATURE_SET_DEFINITIONS => FarReaches_Api_Call_Read::instantiate('api/ActiveFeatureSetDefinitions')->set_property_name()->cachable(),
        FarReaches_Api_Call::CONFIGURATION_CONSTANTS => FarReaches_Api_Call_Read::instantiate('api/ConfigurationConstants')->set_property_name()->cachable(),

        // the autoupdate calls MUST not be required to use an api key -
        // the api key may be bad, not available, etc. sending a bad api key to the wireserver results
        // in the api call being rejected.
        FarReaches_Api_Call::PLUGIN_INFO => FarReaches_Api_Call_Read::instantiate('public/GetWordpressPluginInfo')->no_key(),
        FarReaches_Api_Call::PLUGIN_DOWNLOAD => FarReaches_Api_Call_Read::instantiate('public/GetWordpressPlugin')->no_key()
);