<?php


namespace Pyntax\Repositories;

use Illuminate\Database\Eloquent\Model;
use Pyntax\Models\AbstractResourceModel;
use Pyntax\Contracts\Models\ResourceModelInterface;

/**
 * Class EloquentRepository
 * @package Pyntax\Repositories
 */
class EloquentRepository extends AbstractRepository
{
    /**
     * @param  array  $fieldsData
     * @return ResourceModelInterface|void
     */
    public function create(array $fieldsData)
    {
        /**
         * @var $newObject AbstractResourceModel
         */
        $newObject = $this->factory();
        $newObject->fill($fieldsData);

        $newObject->save();

        return $newObject->findOrFail($newObject->id);
    }

    /**
     * @param  array  $conditions
     * @param  int  $pageSize
     * @param  int  $page
     *
     * @return array|ResourceModelInterface
     */
    public function read(array $conditions, $pageSize = 20, $page = 1)
    {
        $cleanedConditions = [];
        $inConditions = [];

        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                $inConditions[$key] = $value;
            } else {
                $cleanedConditions[$key] = $value;
            }
        }
        /**
         * @var Model
         */
        $klass = $this->getBaseModel()->newQuery()->where($cleanedConditions);
        foreach ($inConditions as $key => $value) {
            $klass->whereIn($key, $value);
        }

        $klass->orderBy($this->getBaseModel()->getPrimaryKey(), 'desc');
        if (($page - 1) > 0) {
            $klass->skip(($page - 1) * $pageSize);
        }

        return $klass->take($pageSize)->paginate();
    }

    /**
     * @param  int  $id
     * @param  array  $fieldsData
     * @return ResourceModelInterface
     */
    public function update(int $id, array $fieldsData)
    {
        $model = $this->read(
            [
                $this->getBaseModel()->getPrimaryKey() => $id,
            ],
            1,
            1
        )->first();
        $model->fill($fieldsData);

        if ($model->isDirty()) {
            $model->save();
        }

        return $model->findOrFail($id);
    }

    /**
     * @param  array  $conditions
     * @return bool
     */
    public function delete(array $conditions)
    {
        $primaryKeyId = $conditions[$this->getBaseModel()->getPrimaryKey()] ?? null;
        if (!empty($primaryKeyId)) {
            $model = $this->read(
                [
                    $this->getBaseModel()->getPrimaryKey() => $conditions[$this->getBaseModel()->getPrimaryKey()],
                ]
            );

            return $model->delete();
        }

        return false;
    }
}
