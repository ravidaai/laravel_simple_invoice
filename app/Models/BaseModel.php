<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 12:24 PM
 */

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