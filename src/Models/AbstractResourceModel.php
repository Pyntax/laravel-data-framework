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
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}