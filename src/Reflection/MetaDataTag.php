<?php

namespace gipfl\OpenRpc\Reflection;

class MetaDataTagParser
{
    const SPECIAL_TAGS = [
        'param'  => ParamTag::class,
        'throws' => ThrowsTag::class,
        'return' => ReturnTag::class,
    ];

    protected $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function part()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function appendValueString($string)
    {
        $this->value .= $string;
    }
}
