<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentModuleRecordRequest;
use App\Models\StudentModuleRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            ['label' => 'Average Grade', 'value' => '87%', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>', 'color' => 'emerald'],
            ['label' => 'Enrolled Courses', 'value' => '3', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>', 'color' => 'sky'],
            ['label' => 'Upcoming Quizzes', 'value' => '2', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>', 'color' => 'violet'],
            ['label' => 'Documents', 'value' => '2', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>', 'color' => 'amber'],
        ];

        $courses = [
            ['name' => 'Advanced Mathematics', 'code' => 'MATH301', 'instructor' => 'Dr. Sarah Anderson', 'schedule' => 'Mon, Wed, Fri 9:00 AM', 'description' => 'ICAS (Internal Continuous Assessment) - 40%'],
            ['name' => 'Physics I', 'code' => 'PHY201', 'instructor' => 'Mr. James Thompson', 'schedule' => 'Tue, Thu 10:00 AM', 'description' => 'ICAS (Internal Continuous Assessment) - 40%'],
            ['name' => 'World History', 'code' => 'HIST201', 'instructor' => 'Mrs. Jessica Miller', 'schedule' => 'Mon, Wed 2:00 PM', 'description' => 'ICAS (Internal Continuous Assessment) - 40%'],
        ];

        $assessments = [
            ['title' => 'Algebra Quiz 1', 'course' => 'Advanced Mathematics', 'points' => '100 pts', 'due' => '4/5/2026', 'duration' => '45 min'],
            ['title' => "Newton's Laws Quiz", 'course' => 'Physics I', 'points' => '100 pts', 'due' => '4/10/2026', 'duration' => '30 min'],
        ];

        $savedModuleCodes = StudentModuleRecord::query()
            ->where('user_id', auth()->id())
            ->pluck('module_code')
            ->all();

        return view('student.dashboard', compact('stats', 'courses', 'assessments', 'savedModuleCodes'));
    }

    public function storeModuleRecord(StoreStudentModuleRecordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        StudentModuleRecord::query()->updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'module_code' => $validated['module_code'],
            ],
            [
                'module_name' => $validated['module_name'],
                'instructor' => $validated['instructor'] ?? null,
                'schedule' => $validated['schedule'] ?? null,
                'description' => $validated['description'] ?? null,
            ]
        );

        return redirect()->route('student.dashboard')->with('status', 'Module record saved successfully.');
    }

    public function grades(): View
    {
        $summary = [
            ['label' => 'Overall Average', 'value' => '87%'],
            ['label' => 'Average ICAS', 'value' => '35%'],
            ['label' => 'Courses', 'value' => '3'],
        ];

        $courses = [
            ['name' => 'Advanced Mathematics', 'description' => 'ICAS (Internal Continuous Assessment) - 40%', 'grade' => 'A - 90%', 'progress' => 36, 'quizzes' => [
                ['label' => 'Quiz 1', 'score' => '85%'],
                ['label' => 'Quiz 2', 'score' => '90%'],
                ['label' => 'Quiz 3', 'score' => '88%'],
                ['label' => 'Participation', 'score' => '95%'],
            ]],
            ['name' => 'Physics I', 'description' => 'ICAS (Internal Continuous Assessment) - 40%', 'grade' => 'B+ - 83%', 'progress' => 72, 'quizzes' => [
                ['label' => 'Quiz 1', 'score' => '78%'],
                ['label' => 'Quiz 2', 'score' => '82%'],
                ['label' => 'Quiz 3', 'score' => '85%'],
                ['label' => 'Participation', 'score' => '90%'],
            ]],
        ];

        $majorExams = [
            ['label' => 'Midterm', 'value' => '92%'],
            ['label' => 'Final', 'value' => '87%'],
            ['label' => 'Assignment Average', 'value' => '89%'],
        ];

        return view('student.grades', compact('summary', 'courses', 'majorExams'));
    }

    public function classrooms(): View
    {
        $classrooms = [
            ['name' => 'Advanced Mathematics', 'code' => 'MATH301', 'instructor' => 'Dr. Sarah Anderson', 'schedule' => 'Mon, Wed, Fri 9:00 AM', 'quizzes' => 1],
            ['name' => 'Physics I', 'code' => 'PHY201', 'instructor' => 'Mr. James Thompson', 'schedule' => 'Tue, Thu 10:00 AM', 'quizzes' => 1],
            ['name' => 'World History', 'code' => 'HIST201', 'instructor' => 'Mrs. Jessica Miller', 'schedule' => 'Mon, Wed 2:00 PM', 'quizzes' => 0],
        ];

        return view('student.classrooms', compact('classrooms'));
    }

    public function documents(): View
    {
        $summary = [
            ['label' => 'Pending', 'value' => '1'],
            ['label' => 'Approved', 'value' => '1'],
            ['label' => 'Ready', 'value' => '0'],
            ['label' => 'Total', 'value' => '2'],
        ];

        $requests = [
            ['title' => 'Transcript', 'purpose' => 'College Application', 'requested' => '3/25/2026', 'status' => 'Approved', 'note' => 'Will be ready in 3-5 business days.'],
            ['title' => 'Certificate of Enrollment', 'purpose' => 'Scholarship Application', 'requested' => '3/28/2026', 'status' => 'Pending', 'note' => null],
        ];

        return view('student.documents', compact('summary', 'requests'));
    }

    public function forum(): View
    {
        $posts = [
            ['author' => 'Emma Johnson', 'role' => 'Student', 'time' => '3 days ago', 'course' => 'Physics I', 'content' => 'Can someone explain the difference between velocity and acceleration?'],
            ['author' => 'Mr. James Thompson', 'role' => 'Faculty', 'time' => '3 days ago', 'course' => 'Physics I', 'content' => 'Great question! Velocity is the rate of change of position, while acceleration is the rate of change of velocity.'],
        ];

        $topics = [
            ['title' => 'Advanced Mathematics', 'count' => 1],
            ['title' => 'Physics I', 'count' => 2],
        ];

        $courses = [
            ['name' => 'Advanced Mathematics', 'code' => 'MATH301'],
            ['name' => 'Physics I', 'code' => 'PHY201'],
            ['name' => 'World History', 'code' => 'HIST201'],
        ];

        return view('student.forum', compact('posts', 'topics', 'courses'));
    }
}
