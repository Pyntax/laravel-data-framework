<?php

namespace Pyntax\Repositories;

use Pyntax\Contracts\Models\ResourceModelInterface;
use Pyntax\Contracts\Repositories\CheckIfOwnedByFieldInterface;
use Pyntax\Contracts\Repositories\FetchByOwnedByFieldInterface;
use Pyntax\Contracts\Repositories\OwnedByAFieldRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class OwnedByUserRepository
 *
 * @package Pyntax\Repositories
 */
class OwnedByUserRepository extends EloquentRepository
    implements OwnedByAFieldRepositoryInterface, FetchByOwnedByFieldInterface, CheckIfOwnedByFieldInterface
{
    /**
     * @var null
     */
    protected $ownedByFieldId = null;

    /**
     * OwnedByUserRepository constructor.
     *
     * @param  ResourceModelInterface  $baseModel
     *
     * @param $ownedByFieldId
     */
    public function __construct(ResourceModelInterface $baseModel, $ownedByFieldId)
    {
        parent::__construct($baseModel);
        $this->ownedByFieldId = $ownedByFieldId;
    }

    /**
     * @param  int  $ownedByFieldValue
     *
     * @return mixed|void
     */
    function setOwnedByFieldValue($ownedByFieldValue)
    {
        $this->ownedByFieldId = $ownedByFieldValue;
    }

    /**
     * @param  array  $fieldsData
     *
     * @throws NotFoundHttpException
     */
    function checkIsOwnedByAccount(array $fieldsData)
    {
        // We need to make sure the account_id is set!
        if ($this->getBaseModel()->isOwnedByAccount()
            && empty($fieldsData[$this->getOwnedByFieldName()])
        ) {
            throw new NotFoundHttpException("Id not found");
        }
    }

    /**
     * @return string
     */
    function getOwnedByFieldName(): string
    {
        return $this->ownedByFieldId;
    }

    /**
     * @param  int  $id
     * @param  int  $ownedByFieldId
     *
     * @return mixed|null
     *
     * @throws NotFoundHttpException
     */
    public function findById(int $id, int $ownedByFieldId)
    {
        $this->checkIsOwnedByAccount([$this->ownedByFieldId => $ownedByFieldId]);

        $conditions = [
            $this->getBaseModel()->getPrimaryKey() => $id,
            $this->ownedByFieldId                  => $ownedByFieldId,
        ];

        $searchResults = $this->read($conditions);

        return $searchResults[0] ?? null;
    }

    /**
     * @param  int  $id
     * @param  int  $ownedByFieldId
     *
     * @return bool
     *
     * @throws NotFoundHttpException
     */
    public function deleteById(int $id, int $ownedByFieldId): bool
    {
        $this->checkIsOwnedByAccount([$this->ownedByFieldId => $ownedByFieldId]);

        $conditions = [
            $this->getBaseModel()->getPrimaryKey() => $id,
            $this->ownedByFieldId                  => $ownedByFieldId,
        ];

        return $this->delete($conditions);
    }

    /**
     * @param  array  $fieldsData
     *
     * @return ResourceModelInterface|void
     *
     * @throws NotFoundHttpException
     */
    public function create(array $fieldsData)
    {
        $this->checkIsOwnedByAccount($fieldsData);

        return parent::create($fieldsData);
    }

    /**
     * @param  array  $conditions
     * @param  int  $pageSize
     * @param  int  $page
     *
     * @return array|ResourceModelInterface
     *
     * @throws NotFoundHttpException
     */
    public function read(array $conditions, $pageSize = 20, $page = 1)
    {
        $this->checkIsOwnedByAccount($conditions);

        return parent::read($conditions, $pageSize, $page);
    }

    /**
     * @param  int  $id
     * @param  array  $fieldsData
     *
     * @return ResourceModelInterface
     *
     * @throws NotFoundHttpException
     */
    public function update(int $id, array $fieldsData)
    {
        $this->checkIsOwnedByAccount($fieldsData);

        return parent::update($id, $fieldsData);
    }

    /**
     * @param  array  $conditions
     *
     * @return bool
     * @throws NotFoundHttpException
     */
    public function delete(array $conditions)
    {
        $this->checkIsOwnedByAccount($conditions);

        return parent::delete($conditions);
    }
}