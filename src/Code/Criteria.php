<?php

namespace HeimrichHannot\CodeGeneratorBundle\Code;

class Criteria
{
    public int $length = 8;
    public bool $preventAmbiguous = true;
    public bool $allowUppercase = true;
    public bool $allowLowercase = true;
    public bool $allowNumbers = true;
    public bool $allowSymbols = false;
    /**
     * Set to null to use the default symbols from hackzilla/password-generator library
     */
    public ?string $allowedSymbols = null;
    public bool $requireUpperCase = false;
    public bool $requireLowerCase = false;
    public bool $requireNumbers = false;
    public bool $requireSymbols = false;
    /**
     * @var string Prefix to add to the generated code. Not counted to code length
     */
    public string $prefix = '';
    /**
     * @var string Suffix to add to the generated code. Not counted to code length
     */
    public string $suffix = '';
}