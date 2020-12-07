<?php

namespace Pyntax\Models;

use Illuminate\Database\Eloquent\Model;
use Pyntax\Contracts\Models\ResourceModelInterface;
use Pyntax\Traits\DateUtils;

/**
 * Class AbstractResourceModel
 *
 * @package Pyntax\Models
 */
abstract class AbstractResourceModel extends Model implements ResourceModelInterface
{
    use DateUtils;

    /**
     * @var bool
     */
    protected $isOwnedByAccount = false;

    /**
     * @var string
     */
    protected $ownedByAccountField = 'user_id';

    /**
     * @var string
     */
    protected $userModel = 'App\Models\User';

    /**
     * @var string
     */
    protected $userModelForeignKey = 'user_id';

    /**
     * @param string $userModelForeignKey
     */
    public function setUserModelForeignKey(string $userModelForeignKey): void
    {
        $this->userModelForeignKey = $userModelForeignKey;
    }

    /**
     * @param string $userModel
     */
    public function setUserModel(string $userModel): void
    {
        $this->userModel = $userModel;
    }

    /**
     * @return bool
     */
    public function isOwnedByAccount(): bool
    {
        return $this->isOwnedByAccount;
    }

    /**
     * @return string
     */
    public function getOwnedByAccountField(): string
    {
        return $this->ownedByAccountField;
    }

    /**
     * @return mixed|string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo($this->userModel, $this->userModelForeignKey, 'id');
    }
}
