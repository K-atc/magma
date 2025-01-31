<?php

enum Foo {
    case Bar;
}

enum IntFoo: int {
    case Bar = 0;
}

enum StringFoo: string {
    case Bar = 'Bar';
}

enum CustomFoo implements JsonSerializable {
    case Bar;

    public function jsonSerialize(): mixed {
        return 'Custom ' . $this->name;
    }
}

function test($value) {
    var_dump(json_encode($value));
    echo json_last_error_msg() . "\n";

    try {
        var_dump(json_encode($value, JSON_THROW_ON_ERROR));
        echo json_last_error_msg() . "\n";
    } catch (Exception $e) {
        echo get_class($e) . ': ' . $e->getMessage() . "\n";
    }
}

test(Foo::Bar);
test(IntFoo::Bar);
test(StringFoo::Bar);
test(CustomFoo::Bar);

?>