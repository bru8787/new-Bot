<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    public $table = 'country_list';


	public $fillable = ['code','name','timezone','mobilecode','utc'];


public function form()
    {
      return $this->belongsTo(Form::class);
    }

}
