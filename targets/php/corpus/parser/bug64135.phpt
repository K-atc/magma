<?php

function exception_error_handler() {
        throw new Exception();
}

set_error_handler("exception_error_handler");
try {
   $undefined->undefined();
} catch(Throwable $e) {
    echo "Exception is thrown";
}
?>