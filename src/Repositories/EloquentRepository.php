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
     * @param array $fieldsData
     * @return ResourceModelInterface|void
     */
    public function create(array $fieldsData)
    {
        // If we are creating a new entity and the ID is -1, we should delete it.
        if (!empty($fieldsData['id']) && $fieldsData['id'] === -1) {
            unset($fieldsData['id']);
        }

        /**
         * @var $newObject AbstractResourceModel
         */
        $newObject = $this->factory();
        $newObject->fill($fieldsData);

        $newObject->save();

        return $newObject->findOrFail($newObject->id);
    }

    /**
     * @return mixed
     */
    public function buildNewQuery()
    {
        return $this->getBaseModel()->newQuery();
    }

    /**
     * @param array $conditions
     * @param int $pageSize
     * @param int $page
     *
     * @return array|ResourceModelInterface
     */
    public function read(array $conditions, $pageSize = 20, $page = 1)
    {
        $cleanedConditions = [];
        $inConditions = [];
        $structuredQueries = [];

        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                if (array_key_exists('structured_query', $value)) {
                    $structuredQuery = $value['structured_query'];
                    if (!empty($structuredQuery['joiningExpression'])
                        && !empty($structuredQuery['values'])) {
                        $structuredQueries[$structuredQuery['joiningExpression']][$key] =
                            $structuredQuery['values'];
                    }
                } else {
                    $inConditions[$key] = $value;
                }
            } else {
                $cleanedConditions[$key] = $value;
            }
        }

        /**
         * @var Model
         */
        $klass = $this->buildNewQuery()->where($cleanedConditions);

        // Adding inConditions
        foreach ($inConditions as $key => $value) {
            $klass->whereIn($key, $value);
        }

        // Adding or conditions
        foreach ($structuredQueries as $key => $value) {
            switch ($key) {
                case "or":
                    foreach ($value as $orField => $orValues) {
                        $klass->where(function ($query) use ($orField, $orValues) {
                            foreach ($orValues as $orValue) {
                                $query->orWhere($orField, $orValue);
                            }
                        });
                    }
                    break;
            }
        }

        return $this->paginateResponse($klass, $pageSize, $page);
    }

    /**
     * @param $klass
     * @param int $pageSize
     * @param int $page
     *
     * @return mixed
     */
    public function paginateResponse($klass, $pageSize = 20, $page = 1)
    {
        $klass->orderBy($this->getBaseModel()->getPrimaryKey(), 'desc');
        if (($page - 1) > 0) {
            $klass->skip(($page - 1) * $pageSize);
        }

        return $klass->paginate($pageSize, ['*'], 'pageNumber');
    }

    /**
     * @param int $id
     * @param array $fieldsData
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
     * @param array $conditions
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
