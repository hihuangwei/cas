<?php

namespace Hihuangwei\CAS\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * @package Hihuangwei\CAS\Models
 *
 * @property string $name
 * @property boolean $allow_proxy
 * @property boolean $enabled
 */
class Service extends Model
{
    protected $table = 'cas_services';
    protected $fillable = ['name', 'enabled', 'allow_proxy'];
    protected $casts = [
        'enabled' => 'boolean',
        'allow_proxy' => 'boolean',
    ];

    public function hosts()
    {
        return $this->hasMany(ServiceHost::class);
    }
}
