<?php
class Outer {
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function getArrayAccess() {
        /* create a proxy object implementing array access */
        return new class($this->data) extends Outer implements ArrayAccess {
            public function offsetGet($offset)          { return $this->data[$offset]; }
            public function offsetSet($offset, $data)   { return ($this->data[$offset] = $data); }
            public function offsetUnset($offset)        { unset($this->data[$offset]); }
            public function offsetExists($offset)       { return isset($this->data[$offset]); }
        };
    }
}

$outer = new Outer(array(
    rand(1, 100)
));

/* not null because inheritance */
var_dump($outer->getArrayAccess()[0]);
?>