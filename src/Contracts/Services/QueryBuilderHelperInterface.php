<?php

namespace Pyntax\Contracts\Services;

/**
 * Interface QueryBuilderHelperInterface
 * @package Pyntax\Contracts\Services
 */
interface QueryBuilderHelperInterface
{
    /**
     * @return mixed
     */
    public function buildNewQuery();

    /**
     * @param $klass
     * @param int $pageSize
     * @param int $page
     *
     * @return mixed
     */
    public function paginateResponse($klass, $pageSize = 20, $page = 1);
}