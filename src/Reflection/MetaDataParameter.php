<?php

namespace gipfl\OpenRpc\Reflection;

use JsonSerializable;

class MetaDataParameter implements JsonSerializable
{
    use MetaDataSerializer;

    const REQUIRED_PROPERTIES = [
        'name',
        'type',
    ];

    const OPTIONAL_PROPERTIES = [
        'description',
    ];

    const RELATED_PROPERTIES = [];

    /** @var string */
    public $name;

    /** @var string */
    public $type;

    /** @var string */
    public $description;

    public function __construct($name, $type, $description = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
