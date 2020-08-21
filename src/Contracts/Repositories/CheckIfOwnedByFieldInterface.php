<?php


namespace Pyntax\Contracts\Repositories;

/**
 * Interface CheckIfOwnedByFieldInterface
 * @package Pyntax\Contracts\Repositories
 */
interface CheckIfOwnedByFieldInterface
{
    /**
     * @param  array  $fieldsData
     * @return mixed
     */
    function checkIsOwnedByAccount(array $fieldsData);
}