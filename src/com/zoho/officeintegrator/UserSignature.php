<?php
namespace com\zoho\officeintegrator;

/**
 * This class represents the user email.
 */
class UserSignature
{
    private $name = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}