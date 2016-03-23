<?php
/**
 * Renders subscriptions UI and handles PAID_UNTIL Api calls.
 */
class FarReaches_Subscription extends FarReaches_Ui_Using {

    const STRIPE_PUBLISHABLE_KEY = 'amplafi.stripe.publishable-key';
    const FARREACHES_SUBSCRIPTIONS_JS = 'farreachesSubscriptionsJs';
    const STRIPE_CHECKOUT = 'stripe-checkout';
    const FEATURE_SET_KEY = 'feature_set';

    function __construct(
                         FarReaches_Util $farReaches_Util,
                         FarReaches_Communication $farReaches_Communication,
                         FarReaches_Ui_Handling $farReaches_Ui_Handling
    ) {
        parent::__construct($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling);
        FarReaches_EventBus_Facade::subscribeMe($this, array(
            'farreaches://subscribe/' => 'on_subscribe_charge'
        ), true);
        $this->register_api_response_handler(FarReaches_Api_Call::CHARGE_CUSTOMER, 'on_charge_request_done', 'on_charge_request_failed');
        $this->register_api_response_handler(FarReaches_Api_Call::ACTIVE_FEATURES, 'on_active_features_done');
        $this->register_api_response_handler(FarReaches_Api_Call::ACTIVE_FEATURE_SET_DEFINITIONS, 'on_active_feature_set_definitions_done');
        $this->register_script(self::STRIPE_CHECKOUT, 'https://checkout.stripe.com/v2/checkout.js', array('jquery'), "v2");
        $this->farReaches_Ui_Handling->register_fr_script(self::FARREACHES_SUBSCRIPTIONS_JS, 'farreaches_subscriptions.js', array(self::STRIPE_CHECKOUT));
    }

    //HACK made this one static to have the logic in class.
    //Make member function when a better DI is in use.
    public static function get_feature_set($farReaches_Util) {
        $feature_set = $farReaches_Util->get_option(self::FEATURE_SET_KEY);
        if (empty($feature_set)) {
            //Fall back to deafaults.
            $feature_set = array('active_features' => array(
                    'ext' => array('maximum-connection-count' => 3)
                )
            );
        }
        return new FarReaches_Feature_Set($feature_set);
    }

    public function on_subscribe_charge(FarReaches_Event $farReaches_Event) {
        $data = $farReaches_Event->data;
        FarReaches_Validate::array_has_key($data, 'charge', 'Charge token is not specified.');
        FarReaches_Validate::array_has_key($data, 'featureSetDefinition', 'Plan id is not specified.');
        $this->initiate_secured_api_call(FarReaches_Api_Call::CHARGE_CUSTOMER, $data);
    }

    public function on_charge_request_done(FarReaches_Event $farReaches_Event) {
        FarReaches_EventBus_Facade::publish('farreaches://subscribe/success', $farReaches_Event);
    }

    public function on_charge_request_failed(FarReaches_Event $farReaches_Event) {
        $error_message = 'Failed to initiate charge request.';
        $response = @$farReaches_Event->error_response->get_parsed_response();
        $errors = @$response['error_data'];
        if (!empty($errors)) {
            //HACK.. think how to render those error messages properly.
            $error_message = $errors['validation_errors'][0]['details'][0]['handlerMessage'];
        }
        $farReaches_Event->error = $error_message;
        FarReaches_EventBus_Facade::publish('farreaches://subscribe/fail', $farReaches_Event);
    }

    public function on_active_features_done(FarReaches_Event $farReaches_Event) {
        $feature_set_json =  $farReaches_Event->response;
        $this->update_option(self::FEATURE_SET_KEY, null, $feature_set_json);
        // TO_KOSTYA : expand this
    }

    public function on_active_feature_set_definitions_done(FarReaches_Event $farReaches_Event) {
        $response = $farReaches_Event->response;
        $this->update_option(FarReaches_Api_Call::ACTIVE_FEATURE_SET_DEFINITIONS, null, $response);
    }

    public function show_subscription_plans() {
        wp_enqueue_style(FarReaches_Ui_Handling::BOOTSTRAP_CSS);
        $response = $this->api_call(FarReaches_Api_Call::CONFIGURATION_CONSTANTS, array('constantNames' => array(self::STRIPE_PUBLISHABLE_KEY)));
        $stripe_key = @$response[self::STRIPE_PUBLISHABLE_KEY];
        //Making the call to have the freshest subscription info.
        // TO_KOSTYA : use the on_active_feature_set_definitions_done to store the information <<<<<<<<<
        // SHOULD BE ABLE TO REMOVE
        $feature_set_definitions = $this->api_call(FarReaches_Api_Call::ACTIVE_FEATURE_SET_DEFINITIONS);
        if (!$this->is_response_in_error($feature_set_definitions)) {
            //HACK Kostya: this is all here until we find more elegant way to format the data..
            //TODO format purchases history.
            $formatted = array();
            foreach ($feature_set_definitions as $definition) {
            	$definition['price'] = $definition['price']/100;
            	$formatted[] = $definition;
            }
            $feature_sets = $this->api_call(FarReaches_Api_Call::ACTIVE_FEATURES);

            // TO_KOSTYA : put in on_active_features_done
            // Kostya: this is not part of on_active_features_done
            // because we do not always want do rendering when the data arrives;
            // e.g. the data could come in as part of periodic refresh or enable feature call.
            $template_data = array(
            		'stripe_key_available' => FarReaches_String_Util::not_blank($stripe_key),
            		'feature_set_definitions' => $formatted,
            		'history' => $feature_sets['history']
            );

            $paid = count($feature_sets['active_sets']) > 1;
            if ($paid) {
            	$paid_until = $this->format_date($feature_sets['active_sets'][1]['chain_expiration_date']['timeInMillis']/1000);
            	$template_data['paid_until'] = $paid_until;
            }
            // TO_KOSTYA ^^^^^

            wp_enqueue_script(self::FARREACHES_SUBSCRIPTIONS_JS);

            $this->add_js_config('stripe_publishable_key', $stripe_key);
            $this->generate_jsrender_template(array('key' => 'subscriptions'), true, $template_data);
        } else {
            // TODO KOSTYA -- seems like we should cache so that the features can always be available
        }
    }
    function show_page_subscriptions() {
        $this->show_subscription_plans();
    }
}
