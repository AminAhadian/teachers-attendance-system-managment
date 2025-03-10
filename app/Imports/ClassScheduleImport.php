<?php

namespace App\Imports;

use Exception;
use App\Helper\Helper;
use App\Models\Teacher;
use App\Models\ClassTime;
use App\Models\TermSchedule;
use App\Models\ClassSchedule;
use App\Models\EducationalGroup;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Filament\Notifications\Notification;
use EightyNine\ExcelImport\DefaultImport;


class ClassScheduleImport extends DefaultImport
{
    protected array $termCache = [];
    protected array $teacherCache = [];
    protected array $educationalGroupCache = [];

    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {

            foreach ($rows as $index => $row) {
                $index = $index + 2;
                $data = $row->toArray();
                $this->processRow($data, $index);
            }

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error importing class schedule: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function processRow($row, $index)
    {
        $term = $this->getTerm($row['term']);
        $teacher = $this->getTeacher($row['ostad_personnel_code']);
        $educationalGroup = $this->getEducationalGroup($row['educational_group_code']);

        if (!$term || !$teacher || !$educationalGroup) {
            return;
        }

        $classSchedule = ClassSchedule::create([
            'name' => $row['name'],
            'teacher_id' => $teacher->id,
            'code' => $row['code'],
            'term_id' => $term->id,
            'presentation_code' => $row['presentation_code'],
            'location' => $row['location'],
            'educational_group_id' => $educationalGroup->id,
        ]);

        $this->createClassTimes($classSchedule, $row['calendar']);
    }

    function transformErrors(array $errors): string
    {
        $transformed = [];

        foreach ($errors as $field => $messages) {
            foreach ($messages as $message) {
                $transformed[] = $message;
            }
        }
        return implode("\n", $transformed);
    }

    protected function getTerm($termCode)
    {
        if (!isset($this->termCache[$termCode])) {
            $this->termCache[$termCode] = TermSchedule::whereCode($termCode)->first();
        }

        return $this->termCache[$termCode];
    }

    protected function getTeacher($personnelCode)
    {
        if (!isset($this->teacherCache[$personnelCode])) {
            $this->teacherCache[$personnelCode] = Teacher::wherePersonnelCode($personnelCode)->first();
        }

        return $this->teacherCache[$personnelCode];
    }

    protected function getEducationalGroup($groupCode)
    {
        if (!isset($this->educationalGroupCache[$groupCode])) {
            $this->educationalGroupCache[$groupCode] = EducationalGroup::whereCode($groupCode)->first();
        }

        return $this->educationalGroupCache[$groupCode];
    }

    protected function createClassTimes($classSchedule, $calendarString)
    {
        $classTimes = Helper::parseClassTimeString($calendarString);

        foreach ($classTimes as $classTime) {
            ClassTime::create([
                'class_id' => $classSchedule->id,
                'day' => $classTime['day'],
                'start_time' => $classTime['start_time'],
                'end_time' => $classTime['end_time'],
                'type' => $classTime['type'],
            ]);
        }
    }
}
