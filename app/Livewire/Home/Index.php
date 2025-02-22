<?php

namespace App\Livewire\Home;

use Exception;
use Carbon\Carbon;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\ClassSession;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    public ?string $attendanceCode;

    #[Title('سامانه جامع اساتید دانشگاه آزاد اسلامی سبزوار')]
    #[Layout('layouts.master')]
    public function render()
    {
        return view('livewire.home.index');
    }

    public function rules()
    {
        return ['attendanceCode' => 'required|string|min:10|exists:teachers,attendance_code'];
    }

    public function save()
    {
        $this->validate();

        try {
            $teacher = $this->getTeacher($this->attendanceCode);
            $validClassSession = $this->getTeacherValidClassSession($teacher);
            $currentTime = Carbon::now();

            if (is_null($validClassSession->teacher_enter_at)) {
                $validClassSession->teacher_enter_at = $currentTime;
                $validClassSession->save();

                $this->dispatchSwal('عملیات موفق', 'حضور شما در سامانه ثبت شد');
            } elseif (is_null($validClassSession->teacher_exit_at)) {
                $validClassSession->teacher_exit_at = $currentTime;
                $validClassSession->save();

                $this->dispatchSwal('عملیات موفق', 'خروج شما در سامانه ثبت شد');
            } else {
                $this->dispatchSwal('خطا', 'حضور و خروج شما قبلا ثبت شده است', 'error');
            }

            $this->reset('attendanceCode');
        } catch (Exception $e) {
            Log::alert('Attendance Error: ' . $e->getMessage(), [
                'attendanceCode' => $this->attendanceCode,
                'teacherId' => $teacher->id ?? null,
            ]);
            $this->dispatchSwal('خطا', $e->getMessage(), 'error');
        }
    }

    protected function getTeacher(string $attendanceCode): Teacher
    {
        $teacher = Teacher::whereAttendanceCode($attendanceCode)->first();

        if (!$teacher) {
            throw new Exception('استاد با کد حضور وارد شده یافت نشد.');
        }

        return $teacher;
    }

    protected function getTeacherValidClassSession(Teacher $teacher): ClassSession
    {
        $currentDate =  Carbon::now()->toDateString();

        $classSessions = ClassSession::whereBelongsTo($teacher)
            ->where('date', $currentDate)
            ->get();

        if ($classSessions->isEmpty()) {
            throw new \Exception('هیچ جلسه‌ای برای امروز یافت نشد.');
        }

        foreach ($classSessions as $classSession) {
            $attendanceTimeFrame = $classSession->classTime->classSchedule->attendance_time_frame;

            $actualStartTime = Carbon::parse($classSession->actual_start_time); // Session start time
            $actualEndTime = Carbon::parse($classSession->actual_end_time); // Session end time

            // Session valid base on[attendance time frame] start time
            $validEnterTime = $actualStartTime->copy()->subMinutes($attendanceTimeFrame);

            // Session valid base on[attendance time frame] end time
            $validExitTime = $actualEndTime->copy()->addMinutes($attendanceTimeFrame);

            /*
            If end time was fewer than start time it is midnight and should add a day
            */
            if ($actualEndTime->lt($actualStartTime)) {
                $validExitTime->addDay();
            }

            $currentTime = Carbon::now();


            if ($currentTime->between($validEnterTime, $validExitTime)) {
                return $classSession;
            }
        }

        throw new \Exception('زمان حضور یا خروج معتبر نیست.');
    }

    protected function dispatchSwal(string $title, string $message, string $icon = 'success', int $timer = 5000): void
    {
        $this->dispatch('swal', [
            'title' => $title,
            'icon' => $icon,
            'message' => $message,
            'timer' => $timer,
        ]);
    }
}
