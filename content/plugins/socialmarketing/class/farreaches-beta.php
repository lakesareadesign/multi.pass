<?php
/**
 * All the beta features go here.
 */
class FarReaches_Beta extends FarReaches_Ui_Using {

    const ON_SAVE_TOPIC = 'farreaches://FarReaches_Beta/save';

    function __construct(
                         FarReaches_Util $farReaches_Util,
                         FarReaches_Communication $farReaches_Communication,
                         FarReaches_Ui_Handling $farReaches_Ui_Handling
    ) {
        parent::__construct($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling);
        FarReaches_EventBus_Facade::subscribeMe($this, array(
            self::ON_SAVE_TOPIC => 'on_save'
        ), true);
    }

    public function on_save(FarReaches_Event $farReaches_Event) {
        $data = $farReaches_Event->data;
        $feature_set = FarReaches_Subscription::get_feature_set($this->farReaches_Util);
        if ($feature_set->is_active('anl')) {
            $user_enabled = $feature_set->get_boolean('anl', 'userEnabled');
            if (FarReaches_Params::boolean($data, 'enable_google_analytics')){
                if (!$user_enabled) {
                    $this->farReaches_Communication->api_call(FarReaches_Api_Call::ENABLE_FEATURE, array('feature' => 'anl'));
                }
            } else if ($user_enabled) {
                $this->farReaches_Communication->api_call(FarReaches_Api_Call::DISABLE_FEATURE, array('feature' => 'anl'));
            }
        }
    }

    function show_page_beta() {
        $data = array(
           'google_analytics_enabled' => FarReaches_Subscription::get_feature_set($this->farReaches_Util)->get_boolean('anl', 'userEnabled')
        );
        if ( current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_SOCIAL_MEDIA_CATEGORIES_CAP)) {
            $data['publish_topic'] = self::ON_SAVE_TOPIC;
        }
        $this->generate_jsrender_template(array('key' => 'beta'), true, $data);
    }
}
