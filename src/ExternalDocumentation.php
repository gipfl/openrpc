<?php

namespace gipfl\OpenRpc;

/**
 * Allows referencing an external resource for extended documentation
 */
class ExternalDocumentation
{
    /**
     * REQUIRED. The URL for the target documentation. Value MUST be in the
     * format of a URL.
     *
     * @var string
     */
    public $url;

    /**
     * A verbose explanation of the target documentation. GitHub Flavored Markdown
     * syntax MAY be used for rich text representation.
     *
     * @var string|null
     */
    public $description;
}
