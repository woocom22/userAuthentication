<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   protected $fillable = [
       'firstName',
       'lastName',
       'email',
       'mobile',
       'password'
   ];
   protected $attributes = [
       'OTP'=>'0'
   ];
}
