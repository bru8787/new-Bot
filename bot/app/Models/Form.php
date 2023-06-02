<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{


	public $table = 'form';


	public $fillable = ['sender_id','message'];


}
