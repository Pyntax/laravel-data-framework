<?php

namespace Pyntax\ApiResources;

use Pyntax\Contracts\ApiResources\FactoryInterface;
use Pyntax\Enums\ResourceType;

/**
 * Class Factory
 *
 * @package Pyntax\ApiResources
 */
class Factory implements FactoryInterface
{
    /**
     * @var array
     */
    protected $resourceRegister = [];

    /**
     * @param  ResourceType  $resourceType
     * @param $singleResource
     *
     * @return mixed|void
     */
    public function addResource(ResourceType $resourceType, $singleResource)
    {
        $this->resourceRegister[$resourceType->value()] = $singleResource;
    }

    /**
     * @param  ResourceType  $resource
     * @param $resourceData
     * @param  bool  $isCollection
     *
     * @return mixed|null
     */
    public function create(
        ResourceType $resource,
        $resourceData,
        $isCollection = false
    ) {
        $resourceClass = $this->resourceRegister[$resource->value()] ?? null;

        if (empty($resourceClass)) {
            return $resourceData;
        }

        return !$isCollection ? new $resourceClass($resourceData)
            : $resourceClass::collection($resourceData);
    }
}