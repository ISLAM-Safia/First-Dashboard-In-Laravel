<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class City extends Model
{
    use HasFactory;
    public function userName(): Attribute
    {
        return new Attribute(get: fn () => $this->name_en);
    }

    public function getActiveKeyAttribute(){
        return $this->active ? 'Active ' : 'inActive' ;
    }
}
