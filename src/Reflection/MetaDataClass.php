<?php

namespace gipfl\OpenRpc\Reflection;

use InvalidArgumentException;
use JsonSerializable;
use ReflectionClass;
use ReflectionException;

class MetaDataClass implements JsonSerializable
{
    use MetaDataSerializer;

    const REQUIRED_PROPERTIES = ['namespace'];

    const OPTIONAL_PROPERTIES = [];

    const RELATED_PROPERTIES = [
        'methods' => MetaDataMethod::class,
    ];

    /** @var MetaDataMethod[] */
    public $methods = [];

    /** @var string|null */
    public $error;

    /**
     * @param string $class
     * @return static
     */
    public static function analyze($class)
    {
        $info = new static();

        try {
            $ref = new ReflectionClass($class);
        } catch (ReflectionException $e) {
            $info->error = $e->getMessage();
            return $info;
        }

        foreach ($ref->getMethods() as $method) {
            $methodName= $method->getName();
            if (! \preg_match('/^(.+)(Request|Notification)$/', $methodName, $match)) {
                continue;
            }

            $methodName = $match[1];
            $methodType = \lcfirst($match[2]);
            $methodInfo = new MetaDataMethod($methodName, $methodType);
            $methodInfo->addParsed(MethodCommentParser::parseMethod($methodInfo, $method->getDocComment()));
            $info->addMethod($methodInfo);
        }

        return $info;
    }

    public function addMethod(MetaDataMethod $method)
    {
        $name = $method->name;
        if (isset($this->methods[$name])) {
            throw new \InvalidArgumentException("Cannot add method '$name' twice");
        }

        $this->methods[$name] = $method;
    }

    /**
     * @return MetaDataMethod[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param $name
     * @return MetaDataMethod
     */
    public function getMethod($name)
    {
        if (isset($this->methods[$name])) {
            return $this->methods[$name];
        }

        throw new InvalidArgumentException("There is no '$name' method");
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        return $this->error;
    }
}
