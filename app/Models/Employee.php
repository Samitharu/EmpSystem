<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory,SoftDeletes;


    protected $table = 'employees';

    
    protected $primaryKey = 'employeeId';

    protected $dates = ['deleted_at'];
    public $timestamps = true;

    
    protected $fillable = [
        'firstName',
        'lastName',
        'gender',
        'joiningDate',
        'nic',
        'departmentId',
        'resignedDate',
        'address',
        'isDeleted',
        'contactNo',
       
        
    ];
}
