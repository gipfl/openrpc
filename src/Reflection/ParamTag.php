<?php

namespace gipfl\OpenRpc\Reflection;

class ParamTag extends Tag
{
    public $name;

    public $dataType;

    public $description;

    public $isVariadic = false;

    public function setTagValue($value)
    {
        parent::setTagValue($value);
        $parts = preg_split('/(\s+)/us', trim($value), 3, PREG_SPLIT_DELIM_CAPTURE);
        if (substr($parts[0], 0, 1) !== '$' && substr($parts[0], 0, 4) !== '...$') {
            $this->dataType = array_shift($parts);
            array_shift($parts);
        }
        if (empty($parts)) {
            return;
        }

        if (substr($parts, 0, 1) === '$') {
            $this->name = substr($parts[0], 1);
        } elseif ()
        // if the next item starts with a $ or ...$ it must be the variable name
        if (isset($parts[0])
            && (strlen($parts[0]) > 0)
            && ($parts[0][0] == '$' || substr($parts[0], 0, 4) === '...$')
        ) {
            $this->variableName = array_shift($parts);
            array_shift($parts);

            if (substr($this->variableName, 0, 3) === '...') {
                $this->isVariadic = true;
                $this->variableName = substr($this->variableName, 3);
            }
        }

        $this->setDescription(implode('', $parts));

        $this->content = $content;
        $parts = preg_split('')
        if ($)
        $dataType = substr($value)
        if ()
        list($dataType, $name, $description) = preg_split('/')
    }
}
