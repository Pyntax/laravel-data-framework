<?php

namespace Pyntax\Contracts\Repositories;

use Pyntax\Contracts\Models\ResourceModelInterface;
use Pyntax\Contracts\Services\CRUDInterface;

/**
 * Class RepositoryInterface
 * @package Pyntax\Repositories
 */
interface RepositoryInterface extends CRUDInterface
{
    /**
     * @return ResourceModelInterface
     */
    public function factory(): ResourceModelInterface;
}
