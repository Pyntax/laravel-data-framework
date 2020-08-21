<?php

namespace Pyntax\Contracts\Repositories;

/**
 * Interface OwnedByAFieldRepositoryInterface
 * @package Pyntax\Contracts\Repositories
 */
interface OwnedByAFieldRepositoryInterface
{
    /**
     * @return string
     */
    function getOwnedByFieldName(): string;

    /**
     * @param  int  $ownedByFieldValue
     * @return mixed
     */
    function setOwnedByFieldValue($ownedByFieldValue);
}