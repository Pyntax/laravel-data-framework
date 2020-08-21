<?php

namespace Pyntax\Services;

use Pyntax\Contracts\Services\ResourceCRUDServiceInterface;
use Pyntax\Contracts\Models\ResourceModelInterface;
use Pyntax\Contracts\Repositories\RepositoryInterface;
use Pyntax\Models\AbstractResourceModel;
use Pyntax\Repositories\AbstractRepository;

/**
 * Class AbstractCRUDService
 *
 * @package Pyntax\Services
 */
abstract class AbstractCRUDService implements ResourceCRUDServiceInterface
{
    /**
     * @var AbstractRepository
     */
    protected $modelRepository;

    /**
     * EloquentRepositoryManager constructor.
     *
     * @param  RepositoryInterface  $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param  array  $conditions
     * @return bool
     */
    public function delete(array $conditions)
    {
        return $this->modelRepository->delete($conditions);
    }

    public function read(array $conditions, $pageSize = 20, $page = 1)
    {
        return $this->modelRepository->read($conditions, $pageSize, $page);
    }

    /**
     * @param  array  $fieldsData
     *
     * @return AbstractResourceModel
     */
    public function create(array $fieldsData): ResourceModelInterface
    {
        return $this->modelRepository->create($fieldsData);
    }

    /**
     * @param  int  $id
     * @param  array  $fieldsData
     *
     * @return ResourceModelInterface
     */
    public function update(int $id, array $fieldsData): ResourceModelInterface
    {
        return $this->modelRepository->update($id, $fieldsData);
    }
}