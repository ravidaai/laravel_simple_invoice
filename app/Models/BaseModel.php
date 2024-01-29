<?php


namespace App\Models;

use App\Traits\EncryptionTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use EncryptionTrait;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    function getIdHashAttribute()
    {
        return $this->encrypt($this->id);
    }
    /////////////////////////////////////////////////////////
    public function getHumansDateAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
