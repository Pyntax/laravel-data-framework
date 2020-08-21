<?php

namespace Pyntax\Validators;

use Illuminate\Support\Facades\Validator;
use Pyntax\Contracts\Validators\FactoryInterface;
use Pyntax\Enums\ResourceType;

/**
 * Class Factory
 *
 * @package Pyntax\Validators
 */
class Factory implements FactoryInterface
{
    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @param  ResourceType  $resource
     * @param  array  $rules
     */
    public function addRules(ResourceType $resource, array $rules)
    {
        $this->rules[$resource->value()] = $rules;
    }

    /**
     * @param  ResourceType  $resource
     *
     * @return bool
     */
    public function hasValidator(ResourceType $resource)
    {
        return array_key_exists($resource->value(), $this->rules);
    }

    /**
     * @param  ResourceType  $resource
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function make(ResourceType $resource, array $data)
    {
        if ($this->hasValidator($resource)) {
            return Validator::make($data, $this->rules[$resource->value()]);
        }

        return null;
    }
}