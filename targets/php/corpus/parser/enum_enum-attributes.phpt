<?php

#[Attribute]
class EnumAttribute {
    public function __construct(
        public string $value,
    ) {}
}

#[EnumAttribute('Foo')]
enum Foo {}

var_dump((new \ReflectionClass(Foo::class))->getAttributes(EnumAttribute::class)[0]->newInstance());

?>