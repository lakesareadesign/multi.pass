<?php
class FarReaches_Api_Call_Read extends FarReaches_Api_Call {
    
    private $property_name;

    public function __construct($api_call_name,
            array $request_defaults= array(), array $request_invariants = array(), $secured_api_call = false) {
        parent::__construct($api_call_name, $request_defaults, $request_invariants);
        $this->set_secured_api_call($secured_api_call);
    }

    /**
     * indicates that this property might be available in other calls to the server
     * as out-of-band data.
     *
     * @param string $property_name
     * @return FarReaches_Api_Call_Read
     */
    public function set_property_name($property_name = null) {
        if (!isset($property_name)) {
            $property_name = $this->get_api_call_name();
            $property_name_index = strrpos($property_name, '/');
            if ( is_numeric($property_name_index)) {
                // lcfirst() not available until 5.3
                $property_name = strtolower(substr($property_name, $property_name_index+1, 1)) . substr($property_name, $property_name_index+2);
            } else {
                $property_name[0] = strtolower($property_name[0]);
            }
        }
        $this->property_name = $property_name;
        return $this;
    }

    /**
     *
     * @param bool $is_cachable
     * @return FarReaches_Api_Call_Read
     */
    public function cachable($is_cachable = true) {
        $this->cachable = $is_cachable;
        return $this;
    }

    public function get_property_name() {
        return $this->property_name;
    }
    /**
     * To allow method chaining
     */
    public static function instantiate($api_call_name,
            array $request_defaults= array(), array $request_invariants = array(), $secured_api_call = false) {
        return new self($api_call_name, $request_defaults, $request_invariants, $secured_api_call);
    }
}