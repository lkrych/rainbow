<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function seed(){
      Artisan::call('db:seed');
    }
}
