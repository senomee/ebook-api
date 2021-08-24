<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function me() {
    return ['NIS' => 3103119040,
        'name' => 'Bakti Surya Atmaja',
        'gender' => 'Sigma Male',
        'phone' => '182345678',
        'class' => 'XII RPL 2'];
  }
}
