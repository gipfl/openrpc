<?php

namespace gipfl\OpenRpc;

/**
 * License information for the exposed API.
 */
class License
{
    /**
     * REQUIRED. The license name used for the API.
     *
     * @var string
     */
    public $name;

    /**
     * A URL to the license used for the API. MUST be in the format of a URL.
     *
     * @var string|null
     */
    public $url;
}
