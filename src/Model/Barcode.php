<?php

declare(strict_types=1);

namespace App\Model;

final class Barcode implements \Stringable
{
    public function __construct(
        private string $type,
        private string $value,
    ) {}

    public static function fromString(string $typeAndValue)
    {
        [$type, $value] = explode(':', $typeAndValue);

        return new self($type, $value);
    }

    public function __toString() : string
    {
        return sprintf('%s:%s', $this->type, $this->value);
    }
}
