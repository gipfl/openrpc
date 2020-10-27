<?php

namespace gipfl\OpenRpc;

/**
 * Contact information for the exposed API
 */
class Contact
{
    /**
     * The identifying name of the contact person/organization
     *
     * @var string|null
     */
    public $name;

    /**
     * The URL pointing to the contact information. MUST be in the format of a
     * URL.
     *
     * @var string|null
     */
    public $url;

    /**
     * The email address of the contact person/organization. MUST be in the
     * format of an email address.
     *
     * @var string|null
     */
    public $email;
}
