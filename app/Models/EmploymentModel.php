<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentModel extends Model
{
    protected $table = "employment";
    protected $primaryKey = 'employer';
    protected $fillable = [
        "employer_name",
    ] ;
}
