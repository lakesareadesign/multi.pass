<?php

abstract class FarReaches_Store extends FarReaches_Base implements arrayaccess {

    private $store_name;
    private $entries;
    private $store_loaded = false;

    function  __construct($store_name) {
        $this->store_name = $store_name;
    }

    public function offsetGet($offset) {

    }

    public function offsetSet($key, $value) {
        $this->maybeLoad();
        $this->entries[$key] = $this->createEntry($key, $value);
    }

    public function offsetUnset($key) {
        $this->maybeLoad();
        if (array_key_exists($key, $this->entries)) {
            unset($this->entries[$key]);
            return true;
        }
        return false;
    }

    public function offsetExists($key) {
        return array_key_exists($key, $this->entries);
    }

    public function getData() {
        $this->maybeLoad();
        $data = array();
        if (!empty($this->entries)) {
            foreach ($this->entries as $entry) {
                $data[] = $entry['data'];
            }
        }
        return $data;
    }

    private function maybeLoad() {
        if (!$this->store_loaded) {
            $this->load();
        }
    }

    private function load() {
        $this->entries = $this->get_option($this->store_name);
        $this->store_loaded = true;
    }

    private function persist() {
        $this->update_option($this->store_name, null, $this->entries);
    }

    protected function createEntry($value) {
        return array('value' => $value, 'last_sync' => null);
    }


}