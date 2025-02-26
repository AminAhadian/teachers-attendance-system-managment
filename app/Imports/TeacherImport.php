<?php

namespace App\Imports;

use App\Enum\Gender;
use App\Models\User;
use App\Models\Degree;
use App\Helper\Helper;
use App\Models\Teacher;
use App\Models\AcademicField;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeacherImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $user = User::updateOrCreate(
                [
                    'username' => $row['personnel_code'],
                ],
                [
                    'name' => $row['name'],
                    'username' => $row['personnel_code'],
                    'password' => Hash::make($row['personnel_code']),
                    'gender' => $this->mapGender($row['gender'])
                ]
            );

            $degree = Degree::whereName($row['degree'])->first();
            if (!$degree) {
                continue;
            }

            $academicField = AcademicField::whereName($row['academic_field'])->first();
            if (!$academicField) {
                continue;
            }

            Teacher::create([
                'personnel_code' => $row['personnel_code'],
                'user_id' => $user->id,
                'degree_id' => $degree->id ?? null,
                'academic_field_id' => $academicField->id ?? null,
                'attendance_code' => Helper::generateAttendanceCode($row['personnel_code'])
            ]);
        }
    }

    protected function mapGender(string $genderPersian)
    {
        return match ($genderPersian) {
            'زن' => Gender::Female->value,
            'مرد' => Gender::Male->value,
            default => Gender::Male->value,
        };
    }
}
