<?php

namespace Pyntax\Managers;

use Illuminate\Support\Collection;
use Pyntax\ApiResources\Factory;
use Pyntax\Contracts\Managers\ResourceManagerOwnedByUser;
use Pyntax\Contracts\Services\OwnedByFieldCRUDServiceInterface;
use Pyntax\Contracts\Services\ResourceCRUDServiceInterface;
use Pyntax\Contracts\Validators\FactoryInterface;
use Pyntax\Enums\ResourceType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ResourceOwnedByUserManager
 *
 * @package Pyntax\Managers
 */
class ResourceOwnedByUserManager extends ResourceManager implements ResourceManagerOwnedByUser
{
    /**
     * @var int|array
     */
    protected $resourceOwnerId;

    /**
     * ResourceOwnedByUserManager constructor.
     *
     * @param  OwnedByFieldCRUDServiceInterface  $crudService
     * @param  FactoryInterface  $validatorFactory
     * @param  ResourceType  $resource
     * @param  Factory  $resourceFactory
     */
    public function __construct(
        OwnedByFieldCRUDServiceInterface $crudService,
        FactoryInterface $validatorFactory,
        ResourceType $resource,
        Factory $resourceFactory
    ) {
        parent::__construct($crudService, $validatorFactory, $resource, $resourceFactory);
    }

    /**
     * @param  $resourceOwnerId
     */
    public function setResourceOwnerId($resourceOwnerId)
    {
        $this->resourceOwnerId = $resourceOwnerId;
    }

    /**
     * @param $keyword
     * @param  array  $conditions
     * @param  int  $pageSize
     * @param  int  $page
     *
     * @return mixed|null
     */
    public function search($keyword, array $conditions = [], $pageSize = 20, $page = 1)
    {
        $conditions = array_merge(
            $conditions,
            [$this->crudService->getOwnedByFieldName() => $this->resourceOwnerId]
        );

        return parent::search($keyword, $conditions, $pageSize, $page);
    }

    /**
     * @param  array  $conditions
     * @param  int  $pageSize
     * @param  int  $page
     *
     * @return Collection
     */
    public function read(array $conditions = [], $pageSize = 20, $page = 1)
    {
        $conditions = array_merge(
            $conditions,
            [
                $this->crudService->getOwnedByFieldName() => $this->resourceOwnerId,
            ]
        );

        return parent::read($conditions, $page, $page);
    }

    /**
     * @param  int  $resourceId
     * @param  array  $additionalData
     *
     * @return mixed|null
     */
    public function findById(int $resourceId, array $additionalData = [])
    {
        $conditions = array_merge(
            ['id' => $resourceId],
            [$this->crudService->getOwnedByFieldName() => $this->resourceOwnerId]
        );

        $records = $this->crudService->read($conditions, 1);

        if (count($records) > 0) {
            return $this->renderResource($records[0]);
        }

        throw new NotFoundHttpException("Resource not found");
    }

    /**
     * @param  int  $resourceId
     *
     * @return bool
     */
    public function deleteById(int $resourceId)
    {
        return $this->crudService->deleteById($resourceId, $this->resourceOwnerId);
    }
}