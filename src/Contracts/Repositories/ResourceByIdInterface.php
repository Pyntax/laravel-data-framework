<?php

namespace Pyntax\Contracts\Repositories;

/**
 * Interface ResourceByIdInterface
 * @package Pyntax\Contracts\Repositories
 */
interface ResourceByIdInterface
{
    /**
     * @param  int  $id
     * @return mixed|null
     */
    public function findById(int $id);

    /**
     * @param  int  $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}