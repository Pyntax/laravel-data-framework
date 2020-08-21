<?php

namespace Pyntax\Contracts\ApiResources;

use Pyntax\Enums\ResourceType;

/**
 * Interface FactoryInterface
 *
 * @package Pyntax\Contracts\ApiResources
 */
interface FactoryInterface
{
    /**
     * @var string
     */
    const SINGLE_RESOURCE = "single";

    /**
     * @var string
     */
    const COLLECTION_RESOURCE = "collection";

    /**
     * @param  ResourceType  $resourceType
     * @param $singleResource
     *
     * @return mixed
     */
    function addResource(ResourceType $resourceType, $singleResource);

    /**
     * @param  ResourceType  $resource
     * @param $resourceData
     * @param  false  $isCollection
     *
     * @return mixed
     */
    function create(ResourceType $resource, $resourceData, $isCollection = false);
}