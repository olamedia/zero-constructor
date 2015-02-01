<?php

namespace zero;

class constructor{
    protected $_properties = [];
    public function __construct($properties = [], $init = null){
        $this->constructParents();
        $this->extend($properties, $init);
    }
    private function constructParents(){
        $p = \get_class($this);
        $pa = [];
        while ($p !== __CLASS__){
            $pa[] = $p;
            $p = \get_parent_class($p);
        }
        $pa = \array_reverse($pa);
        foreach ($pa as $p){
            if (\method_exists($p, 'construct')){
                $m = new \ReflectionMethod($p, 'construct');
                $m->invoke($this);
            }
        }
    }

    protected function extend($properties = [], $init = null){
        foreach ($properties as $k => $v){
            $this->$k = $v;
        }
        if (null !== $init){
            return $init($this);
        }
    }    
    public function &__get($name){
        //echo ' get('.$name.') ';
        if (\array_key_exists($name, $this->_properties)){
            return $this->_properties[$name];
        }
        // FIXME throw exception?
        //$null = null;
        //return $null;
    }
    public function __set($name, $value){
        if (\is_callable($value)){
            $value = \Closure::bind($value, $this, $this);
        }
        $this->_properties[$name] = $value;
    }
    public function __call($name, $arguments){
        return \call_user_func_array($this->$name, $arguments);
    }
}



