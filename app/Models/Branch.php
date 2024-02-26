<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Branch extends Model
{
    use HasFactory, HasRoles, SoftDeletes;

    protected $table = 'branches';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public static function generate_code_branch()
    {
        $last_code_branch = Branch::orderBy('id', 'desc')->first();
        if (! $last_code_branch) {
            $code_branch = 'CBG-1';
        } else {
            $get_last_code_branch = $last_code_branch->code;
            $last_number = substr($get_last_code_branch, 4);
            $new_number = $last_number + 1;
            $code_branch = 'CBG-'.$new_number;
        }

        return $code_branch;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function sequences()
    {
        return $this->hasMany(Sequence::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservations::class, 'branch_id', 'id');
    }

    public function doctorSchedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'branch_id', 'id');
    }

    public function user()
    {
        return $this->hasMany(Branch::class, 'branch_id', 'id');
    }

    public function shift_log()
    {
        return $this->hasMany(ShiftLog::class, 'branch_id', 'id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'branch_id', 'id');
    }

    public function medicalRecord()
    {
        return $this->hasMany(MedicalRecord::class, 'branch_id', 'id');
    }
}
