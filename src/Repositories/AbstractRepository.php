<?php

namespace Pyntax\Repositories;

use Pyntax\Contracts\Repositories\RepositoryInterface;
use Pyntax\Contracts\Models\ResourceModelInterface;
use Pyntax\Models\AbstractResourceModel;

/**
 * Class AbstractRepository
 *
 * @package Pyntax\Repositories
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @return ResourceModelInterface
     */
    public function factory(): ResourceModelInterface
    {
        return $this->getBaseModel()->newInstance();
    }

    /**
     * @var ResourceModelInterface
     */
    protected $baseModel;

    /**
     * AbstractRepository constructor.
     * @param  ResourceModelInterface  $baseModel
     */
    public function __construct(ResourceModelInterface $baseModel)
    {
        $this->baseModel = $baseModel;
    }

    /**
     * @return ResourceModelInterface
     */
    public function getBaseModel(): ResourceModelInterface
    {
        return $this->baseModel;
    }
}