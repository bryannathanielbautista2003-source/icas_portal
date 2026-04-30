<?php

namespace App\Services;

class AcademicTermService
{
    protected SystemSettingsService $settings;

    public function __construct()
    {
        $this->settings = new SystemSettingsService();
    }

    public function getCurrentSemester(): string
    {
        return (string) $this->settings->get('current_semester', 'Second Semester');
    }

    public function enrollmentOpen(): bool
    {
        $start = $this->settings->get('enrollment_start');
        $end = $this->settings->get('enrollment_end');
        if (!$start || !$end) return false;

        $now = now()->startOfDay();
        return $now->between(
            \Carbon\Carbon::parse($start)->startOfDay(),
            \Carbon\Carbon::parse($end)->endOfDay()
        );
    }

    public function finalExamStarted(): bool
    {
        $exam = $this->settings->get('final_exam_start');
        if (!$exam) return false;
        return now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($exam));
    }
}
