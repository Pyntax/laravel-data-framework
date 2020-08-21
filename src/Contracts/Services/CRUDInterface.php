<?php

namespace Pyntax\Contracts\Services;

use Pyntax\Contracts\Models\ResourceModelInterface;

/**
 * Interface CRUDInterface
 *
 * @package Pyntax\Contracts\Services
 */
interface CRUDInterface
{
    /**
     * @param  array  $fieldsData
     *
     * @return ResourceModelInterface
     */
    public function create(array $fieldsData);

    /**
     * @param  array  $conditions
     * @param  int  $pageSize
     * @param  int  $page
     */
    public function read(array $conditions, $pageSize = 20, $page = 1);

    /**
     * @param  int  $id
     * @param  array  $fieldsData
     */
    public function update(int $id, array $fieldsData);

    /**
     * @param  array  $conditions
     *
     * @return boolean
     */
    public function delete(array $conditions);
}