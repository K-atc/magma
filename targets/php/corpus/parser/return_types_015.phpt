<?php

namespace Collections;

interface Collection {
    function values(): Collection;
}

class Vector implements Collection {
    function values(): Collection {
        return $this;
    }
}

$v = new Vector;
var_dump($v->values());
?>