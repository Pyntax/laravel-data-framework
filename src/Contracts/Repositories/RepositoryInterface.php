<?php

namespace Pyntax\Contracts\Repositories;

use Pyntax\Contracts\Models\ResourceModelInterface;
use Pyntax\Contracts\Services\CRUDInterface;
use Pyntax\Contracts\Services\QueryBuilderHelperInterface;

/**
 * Class RepositoryInterface
 * @package Pyntax\Repositories
 */
interface RepositoryInterface extends CRUDInterface, QueryBuilderHelperInterface
{
    /**
     * @return ResourceModelInterface
     */
    public function factory(): ResourceModelInterface;
}
