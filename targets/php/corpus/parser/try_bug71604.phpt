<?php
function gen() {
    try {
        try {
            yield;
        } finally {
            print "INNER\n";
        }
    } catch (Exception $e) {
        print "EX\n";
    } finally {
        print "OUTER\n";
    }
    print "NOTREACHED\n";
}

gen()->current();

?>