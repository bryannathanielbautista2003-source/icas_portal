<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $summary = [
            ['label' => 'Total Users', 'value' => '1,238'],
            ['label' => 'Active Teachers', 'value' => '72'],
            ['label' => 'Active Students', 'value' => '1,102'],
            ['label' => 'Pending Requests', 'value' => '14'],
        ];

        $overview = [
            ['title' => 'New registrations', 'value' => '24'],
            ['title' => 'Open support tickets', 'value' => '7'],
        ];

        $recentActions = [
            ['title' => 'New teacher account created', 'subtitle' => 'Dr. Cameron Lee'],
            ['title' => 'Policy document updated', 'subtitle' => 'Admissions handbook'],
            ['title' => 'Backup completed', 'subtitle' => '3 hours ago'],
        ];

        return view('admin.dashboard', compact('summary', 'overview', 'recentActions'));
    }

    public function grades(): View
    {
        $grades = [
            ['course' => 'Advanced Mathematics', 'average' => '88%', 'status' => 'On track'],
            ['course' => 'Physics I', 'average' => '84%', 'status' => 'Needs review'],
        ];

        return view('admin.grades', compact('grades'));
    }

    public function classrooms(): View
    {
        $classrooms = [
            ['name' => 'Advanced Mathematics', 'teacher' => 'Dr. Sarah Anderson', 'students' => 28, 'status' => 'Active'],
            ['name' => 'Physics I', 'teacher' => 'Mr. James Thompson', 'students' => 24, 'status' => 'Active'],
            ['name' => 'World History', 'teacher' => 'Mrs. Jessica Miller', 'students' => 30, 'status' => 'Active'],
        ];

        return view('admin.classrooms', compact('classrooms'));
    }

    public function documents(): View
    {
        $documents = [
            ['title' => 'Transcript Request', 'status' => 'Approved', 'requested' => '3/25/2026'],
            ['title' => 'Enrollment Certificate', 'status' => 'Pending', 'requested' => '3/28/2026'],
            ['title' => 'Policy Manual', 'status' => 'Published', 'requested' => '3/29/2026'],
        ];

        return view('admin.documents', compact('documents'));
    }

    public function forum(): View
    {
        $threads = [
            ['title' => 'Staff meeting agenda', 'activity' => '6 comments'],
            ['title' => 'System update schedule', 'activity' => '3 comments'],
        ];

        return view('admin.forum', compact('threads'));
    }
}
