<?php

function _float_(?float $v): ?float {
    return $v;
}

var_dump(_float_(null));
var_dump(_float_(1.3));
?>