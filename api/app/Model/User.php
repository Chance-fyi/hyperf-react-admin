<?php

declare (strict_types=1);
namespace App\Model;

use Qbhy\HyperfAuth\Authenticatable;

/**
 * @property int $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property \Carbon\Carbon $createdAt
 * @property \Carbon\Carbon $updatedAt
 */
class User extends Model implements Authenticatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function getId(): int
    {
        return $this->id;
    }

    public static function retrieveById($key): User
    {
        return self::find($key);
    }
}