<?php


namespace Pyntax\Contracts\Repositories;


/**
 * Interface FetchByOwnedByFieldInterface
 * @package Pyntax\Contracts\Repositories
 */
interface FetchByOwnedByFieldInterface
{
    /**
     * @param  int  $id
     * @param  int  $ownedByFieldId
     *
     * @return mixed
     */
    public function findById(int $id, int $ownedByFieldId);

    /**
     * @param  int  $id
     * @param  int  $ownedByFieldId
     *
     * @return bool
     */
    public function deleteById(int $id, int $ownedByFieldId): bool;
}