<?php
/**
 * Standard event class to ensure that we don't have argument mismatching.
 *
 * Some standard properties:
 *
 * response          ( response specific to this event )
 * full_response     ( the entire http response )
 * parsed_response   ( the body split into an array )
 * api_call_key      ( the api_call_key )
 * @author patmoore
 *
 */
class FarReaches_Event {

    public $user;

    public function __construct($user = null) {
        $this->user = $user;
    }

    /**
     * A patch solution to make it easier to handle stuff from javascript
     * (temporary?)
     * @param unknown $array
     */
    public function applyHash($array) {
        if ( is_array($array)) {
            foreach ($array as $key => $value) {
                $keyStr = (string) $key; // handles numeric indices
                if ( $keyStr != 'user') {
                    // SECURITY : do not allow input from browser to alter the user that this message is delivered to.
                    // ( this is why we are not using the php methods to assign from array to the FarReaches_Event object)
                    $this->$keyStr = $value;
                }
            }
        } 
        if (!array_key_exists('data', $this)) {
            //Only set data field if it's not supplied by the array.
            $this->data = $array;
        }
    }
    public function __toString() {
        return var_export($this, true);
    }
}