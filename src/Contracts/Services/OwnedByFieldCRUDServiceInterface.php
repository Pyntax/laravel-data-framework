<?php

namespace Pyntax\Contracts\Services;

use Pyntax\Contracts\Repositories\FetchByOwnedByFieldInterface;
use Pyntax\Contracts\Repositories\OwnedByAFieldRepositoryInterface;

/**
 * Interface OwnedByFieldCRUDServiceInterface
 *
 * @package Pyntax\Contracts\Services
 */
interface OwnedByFieldCRUDServiceInterface
    extends FetchByOwnedByFieldInterface, OwnedByAFieldRepositoryInterface, ResourceCRUDServiceInterface
{

}