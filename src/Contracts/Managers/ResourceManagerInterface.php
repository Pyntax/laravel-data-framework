<?php

namespace Pyntax\Contracts\Managers;

/**
 * Interface ResourceManagerInterface
 *
 * @package Pyntax\Contracts\Managers
 */
interface ResourceManagerInterface
{
    /**
     * @param  array  $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $keyword
     * @param  array  $conditions
     * @param  int  $pageSize
     * @param  int  $page
     *
     * @return mixed
     */
    public function search(
        $keyword,
        array $conditions = [],
        $pageSize = 20,
        $page = 1
    );

    /**
     * @param  array  $conditions
     * @param  int  $pageSize
     * @param  int  $page
     *
     * @return mixed
     */
    public function read(array $conditions = [], $pageSize = 20, $page = 1);

    /**
     * @param  int  $resourceId
     * @param  array  $additionalData
     *
     * @return mixed
     */
    public function findById(int $resourceId, array $additionalData = []);

    /**
     * @param  int  $resourceId
     *
     * @return mixed
     */
    public function deleteById(int $resourceId);

    /**
     * @param  int  $resourceId
     * @param  array  $newData
     *
     * @return mixed
     */
    public function update(int $resourceId, array $newData);
}
