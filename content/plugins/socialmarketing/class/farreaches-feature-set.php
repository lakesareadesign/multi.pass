<?php
/**
 * This class is to be extended with all kinds of restriction parameters that can be applied
 * based on current subscription plan.
 *
 * TODO: TO_KOSTYA : see FarReachesFoundation_Permissions::map_meta_cap() for how we should be using wordpress capabilities
 *
 * Note that we don't want the plugin to enforce the feature set in a "hard" way - i.e. throwing an exception.
 *
 * "Soft" enforcement mechanisms are o.k.:
 * 1) UI is unavailable
 * 2) Displaying help/buy me text to the user.
 *
 * The plugin is an untrusted client, the server has the definitive list of features available. So any information the plugin has
 * could be altered or out-of-date.
 *
 * @author aectann@gmail.com (Konstantin Burov)
 *
 */
class FarReaches_Feature_Set {

    private $maximum_end_point_count;

    private $active_features;

    public function __construct($raw_set) {
        $this->maximum_end_point_count = $raw_set['active_features']['ext']['maximum-connection-count'];
        $this->active_features = $raw_set['active_features'];
    }

    public function exceeds_maximum_end_point($end_point_count) {
        return $this->maximum_end_point_count < $end_point_count;
    }

    public function get_active_features() {
    	return array_keys($this->active_features);
    }
    
    public function is_active($feature_name) {
    	return array_key_exists($feature_name, $this->active_features);
    }

    public function get_boolean($feature_name, $key) {
    	if (array_key_exists($feature_name, $this->active_features)) {
    	    $feature_config = $this->active_features[$feature_name];
    	    return FarReaches_Params::boolean($feature_config, $key);
    	} else {
    		return false;
    	}
    }
}

?>