<?php

namespace gipfl\OpenRpc\Reflection;

class Tag
{
    /** @var string */
    public $tagType;

    /** @var string */
    public $tagValue;

    public function __construct($tagType, $tagValue)
    {
        $this->tagType = $tagType;
        $this->setTagValue($tagValue);
    }

    public function setTagValue($value)
    {
        $this->tagValue = $value;

        return $this;
    }
}
