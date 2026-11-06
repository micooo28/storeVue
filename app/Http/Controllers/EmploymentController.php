<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\EmploymentModel;
use Illuminate\Http\Request;

class EmploymentController extends Controller
{
    public function index(){
           $employment = EmploymentModel::select(
            'employer',
            'employer_name',
        )->get();
        return $employment;
    }
}
