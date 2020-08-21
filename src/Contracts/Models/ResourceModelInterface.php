<?php

namespace Pyntax\Contracts\Models;

/**
 * Interface BaseModelInterface
 * @package Pyntax\Models
 */
interface ResourceModelInterface
{
    /**
     * @return bool
     */
    public function isOwnedByAccount(): bool;

    /**
     * @return mixed
     */
    public function getPrimaryKey();

    /**
     * @param  array  $attributes
     * @param  false  $exists
     *
     * @return mixed
     */
    function newInstance($attributes = [], $exists = false);
}
