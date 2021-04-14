<?php

namespace Hihuangwei\CAS\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ServiceHost
 * @package Hihuangwei\CAS\Models
 *
 * @property integer $service_id
 * @property Service $service
 */
class ServiceHost extends Model
{
    protected $table = 'cas_service_hosts';
    public $timestamps = false;
    protected $fillable = ['host'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
