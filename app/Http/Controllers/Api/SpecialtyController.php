<?php

namespace App\Http\Controllers\Api;

use App\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{
    public function doctors(Specialty $specialty)
    {
        return $specialty->users()->get(['users.id', 'users.name']);
    }
}
