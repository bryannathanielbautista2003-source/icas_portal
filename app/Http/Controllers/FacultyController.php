<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FacultyController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            ['label' => 'My Courses', 'value' => '1', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>'],
            ['label' => 'Total Students', 'value' => '28', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'],
            ['label' => 'Graded', 'value' => '2', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>'],
            ['label' => 'Avg Performance', 'value' => '87%', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>'],
        ];

        $courses = [
            ['name' => 'Advanced Mathematics', 'code' => 'MATH301', 'schedule' => 'Mon, Wed, Fri 9:00 AM', 'students' => 28, 'grade' => '10th'],
        ];

        return view('faculty.dashboard', compact('stats', 'courses'));
    }

    public function students(): View
    {
        $students = [
            ['initials' => 'EJ', 'name' => 'Emma Johnson', 'email' => 'emma.j@school.edu', 'grade' => '10th', 'class' => 'A', 'enrolled' => '9/1/2024', 'status' => 'active'],
            ['initials' => 'LS', 'name' => 'Liam Smith', 'email' => 'liam.s@school.edu', 'grade' => '10th', 'class' => 'A', 'enrolled' => '9/1/2024', 'status' => 'active'],
            ['initials' => 'OB', 'name' => 'Olivia Brown', 'email' => 'olivia.b@school.edu', 'grade' => '10th', 'class' => 'B', 'enrolled' => '9/1/2024', 'status' => 'active'],
            ['initials' => 'ND', 'name' => 'Noah Davis', 'email' => 'noah.d@school.edu', 'grade' => '11th', 'class' => 'A', 'enrolled' => '9/1/2023', 'status' => 'active'],
            ['initials' => 'AW', 'name' => 'Ava Wilson', 'email' => 'ava.w@school.edu', 'grade' => '11th', 'class' => 'B', 'enrolled' => '9/1/2023', 'status' => 'active'],
            ['initials' => 'EM', 'name' => 'Ethan Martinez', 'email' => 'ethan.m@school.edu', 'grade' => '9th', 'class' => 'A', 'enrolled' => '9/1/2025', 'status' => 'active'],
        ];

        return view('faculty.students', compact('students'));
    }

    public function grades(): View
    {
        $summary = [
            ['label' => 'Attendance Rate', 'value' => '75%'],
            ['label' => 'Present', 'value' => '6'],
            ['label' => 'Absent', 'value' => '1'],
            ['label' => 'Late', 'value' => '1'],
        ];

        $records = [
            ['initials' => 'EJ', 'name' => 'Emma Johnson', 'class' => '10th A', 'date' => '3/28/2026', 'status' => 'Present'],
            ['initials' => 'LS', 'name' => 'Liam Smith', 'class' => '10th A', 'date' => '3/28/2026', 'status' => 'Present'],
            ['initials' => 'OB', 'name' => 'Olivia Brown', 'class' => '10th B', 'date' => '3/28/2026', 'status' => 'Late'],
        ];

        return view('faculty.grades', compact('summary', 'records'));
    }
}
