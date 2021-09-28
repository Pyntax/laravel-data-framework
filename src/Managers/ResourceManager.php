<?php

namespace Pyntax\Managers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Pyntax\Contracts\Models\ResourceModelInterface;

/**
 * Class ResourceManager
 *
 * @package Pyntax\Managers
 */
class ResourceManager extends AbstractResourceManager
{
    /**
     * @param $resourceData
     * @param bool $isCollection
     *
     * @return mixed|null
     */
    protected function renderResource($resourceData, $isCollection = false)
    {
        if (!$this->shouldRenderResource()) {
            return $resourceData;
        }

        return $this->resourceFactory->create(
            $this->resource,
            $resourceData,
            $isCollection
        );
    }

    /**
     * @param array $newData
     *
     * @return \Illuminate\Http\JsonResponse|ResourceModelInterface
     * @throws \Exception
     */
    public function create(array $newData)
    {
        DB::beginTransaction();

        $validator = $this->validatorFactory->make($this->resource, $newData);
        try {

            if (!empty($validator)) {
                $validator->validate();
            }

            $newRecord = $this->crudService->create($newData);
            DB::commit();

            return $this->renderResource($newRecord);
        } catch (ValidationException $validationException) {
            DB::rollBack();

            throw $validationException;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param int $resourceId
     * @param array $newData
     *
     * @return mixed|ResourceModelInterface
     */
    public function update(int $resourceId, array $newData)
    {
        DB::beginTransaction();

        try {
            $updatedRecord = $this->crudService->update($resourceId, $newData);
            DB::commit();

            return $this->renderResource($updatedRecord);
        } catch (ValidationException $validationException) {
            DB::rollBack();

            throw $validationException;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param $keyword
     * @param array $conditions
     * @param int $pageSize
     * @param int $page
     *
     * @return mixed|null
     */
    public function search($keyword, array $conditions = [], $pageSize = 20, $page = 1)
    {
        $records = $this->crudService->read($conditions, $pageSize, $page);

        return $this->renderResource($records, true);
    }

    /**
     * @param array $conditions
     * @param int $pageSize
     * @param int $page
     *
     * @return Collection
     */
    public function read(array $conditions = [], $pageSize = 20, $page = 1)
    {
        $records = $this->crudService->read($conditions, $pageSize, $page);

        return $this->renderResource($records, true);
    }

    /**
     * @param int $resourceId
     * @param array $additionalData
     *
     * @return mixed|null
     */
    public function findById(int $resourceId, array $additionalData = [])
    {
        $conditions = ['id' => $resourceId];
        $records = $this->crudService->read($conditions, 1);

        if (count($records) > 0) {
            return $this->renderResource($records[0]);
        }

        throw new NotFoundHttpException("Resource not found");
    }

    /**
     * @param int $resourceId
     *
     * @return bool
     */
    public function deleteById(int $resourceId)
    {
        return $this->crudService->delete(['id' => $resourceId]);
    }
}
