<?php

namespace Pyntax\Contracts\Managers;

/**
 * Interface ResourceManagerOwnedByUser
 * @package Pyntax\Contracts\Managers
 */
interface ResourceManagerOwnedByUser
{
    /**
     * @param int $resourceOwnerId
     * @return mixed
     */
    public function setResourceOwnerId($resourceOwnerId);
}
