<?php

namespace gipfl\OpenRpc\Reflection;

class MetaDataTagSet
{
    /** @var MetaDataTag[] */
    protected $tags;

    public function __construct()
    {
        $this->tags = [];
    }

    public function add(MetaDataTag $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * @param string $type
     * @return static
     */
    public function byType($type)
    {
        $set = new static();
        foreach ($this->tags as $tag) {
            if ($tag->getType() === $type) {
                $set->add($tag);
            }
        }

        return $set;
    }

    public function getTags()
    {
        return $this->tags;
    }
}
