<?php
class FarReaches_Api_Call_Write extends FarReaches_Api_Call {

    /**
     * TODO array of api_calls that this api_call invalidates ( used for write operations )
     * for now just a boolean.
     * @var array
     *
     * TO_PAT (Eugene): I don't get the idea how these invalidation rules should work.
     * For example, for post statuses a post status write call should invalidate some cache.
     * Currenly we don't have cache invalidation key groups, and we don't know current cache keys either.
     */
    private $invalidates;
    public function __construct($api_call_name, array $invalidates = array(),
            array $request_defaults= array(), array $request_invariants = array()) {
        parent::__construct($api_call_name, $request_defaults, $request_invariants);
        $this->set_secured_api_call(true);
        $this->set_invalidates($invalidates);
        return $this;
    }

    public function set_invalidates(array $invalidates) {
        $this->invalidates = $invalidates;
        return $this;
    }

    public function get_invalidates() {
        return $this->invalidates;
    }
    /**
     * To allow method chaining
     * @return FarReaches_Api_Call_Write
     */
    public static function instantiate($api_call_name, array $invalidates = array(),
            array $request_defaults= array(), array $request_invariants = array()) {
        return new self($api_call_name, $invalidates, $request_defaults, $request_invariants);
    }
}