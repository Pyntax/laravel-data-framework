<?php

namespace Pyntax\Managers;

use Pyntax\ApiResources\Factory;
use Pyntax\Contracts\Managers\ResourceManagerInterface;
use Pyntax\Contracts\Services\OwnedByFieldCRUDServiceInterface;
use Pyntax\Contracts\Services\ResourceCRUDServiceInterface;
use Pyntax\Contracts\Validators\FactoryInterface;
use Pyntax\Enums\ResourceType;

/**
 * Class AbstractResourceManager
 *
 * @package Pyntax\Managers
 */
abstract class AbstractResourceManager implements ResourceManagerInterface
{
    /**
     * @var ResourceCRUDServiceInterface|OwnedByFieldCRUDServiceInterface
     */
    protected $crudService;

    /**
     * @var FactoryInterface
     */
    protected $validatorFactory;

    /**
     * @var ResourceType
     */
    protected $resource;

    /**
     * @var Factory
     */
    protected $resourceFactory;

    /**
     * AbstractResourceManager constructor.
     *
     * @param  ResourceCRUDServiceInterface  $crudService
     * @param  FactoryInterface  $validatorFactory
     * @param  ResourceType  $resource
     * @param  Factory  $resourceFactory
     */
    public function __construct(
        ResourceCRUDServiceInterface $crudService,
        FactoryInterface $validatorFactory,
        ResourceType $resource,
        Factory $resourceFactory
    ) {
        $this->crudService      = $crudService;
        $this->validatorFactory = $validatorFactory;
        $this->resource         = $resource;
        $this->resourceFactory  = $resourceFactory;
    }
}