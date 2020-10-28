<?php

namespace gipfl\OpenRpc\Reflection;

use InvalidArgumentException;

trait MetaDataSerializer
{
    public function jsonSerialize()
    {
        $result = (object) [];
        foreach (static::REQUIRED_PROPERTIES as $name) {
            $result->$name = $this->$name;
        }
        foreach (static::OPTIONAL_PROPERTIES as $name) {
            if ($this->$name !== null && \strlen($this->$name) > 0) {
                $result->$name = $this->$name;
            }
        }
        foreach (static::RELATED_PROPERTIES as $name => $class) {
            foreach ($this->$name as $instanceName => $instance) {
                $result->$name[$instanceName] = $instance->jsonSerialize();
            }
        }

        return $result;
    }

    public static function fromPlainObject($object)
    {
        $params = [];
        foreach (static::REQUIRED_PROPERTIES as $name) {
            if (isset($object->$name)) {
                $params[$name] = $object->$name;
            } else {
                throw new InvalidArgumentException("'$name' is required");
            }
        }

        $self = new static(...array_values($params));
        foreach (static::OPTIONAL_PROPERTIES as $name) {
            if (isset($object->$name)) {
                $self->$name = $name;
            }
        }
        foreach (static::RELATED_PROPERTIES as $name => $class) {
            if (isset($object->$name)) {
                foreach ($object->$name as $instanceName => $properties) {
                    $self->$name[$instanceName] = $class::fromPlainObject($properties);
                }
            }
        }

        return $self;
    }
}
