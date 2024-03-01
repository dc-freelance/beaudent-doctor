<?php

namespace App\Repositories;

use App\Interfaces\DoctorInterface;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class DoctorRepository implements DoctorInterface
{
    private $doctor;

    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    public function get()
    {
        return $this->doctor->with('doctorCategory')->get();
    }

    public function getById($id)
    {
        return $this->doctor->with('doctorCategory')->find($id);
    }

    public function store($data)
    {
        $data['password'] = bcrypt('password');

        return $this->doctor->create($data);
    }

    public function update($id, $data)
    {
        return $this->doctor->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->doctor->find($id)->delete();
    }

    public function changePassword($id, $data)
    {
        $currentPassword = $this->doctor->find($id)->password;
        if (!Hash::check($data['current_password'], $currentPassword)) {
            throw new \Exception('Password lama tidak sesuai');
        }

        return $this->doctor->find($id)->update(['password' => bcrypt($data['new_password'])]);
    }
}
