<?php

namespace Pyntax\Contracts\Validators;

use Pyntax\Enums\ResourceType;

/**
 * Interface FactoryInterface
 *
 * @package Pyntax\Contracts\Validators
 */
interface FactoryInterface
{
    /**
     * @param  ResourceType  $resource
     * @param  array  $rules
     */
    function addRules(ResourceType $resource, array $rules);

    /**
     * @param  ResourceType  $resource
     *
     * @return bool
     */
    function hasValidator(ResourceType $resource);

    /**
     * @param  ResourceType  $resource
     * @param  array  $data
     *
     * @return mixed
     */
    function make(ResourceType $resource, array $data);
}