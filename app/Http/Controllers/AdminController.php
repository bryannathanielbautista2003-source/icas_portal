<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\FacultyAttendanceRecord;
use App\Models\StudentModuleRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        // Placeholder data to ensure dashboard details are fully visible
        $totalUsers = 134;
        $activeTeachers = 28;
        $activeStudents = 104;
        $pendingRequests = 2;

        $summary = [
            ['label' => 'Total Users', 'value' => (string) $totalUsers],
            ['label' => 'Active Teachers', 'value' => (string) $activeTeachers],
            ['label' => 'Active Students', 'value' => (string) $activeStudents],
            ['label' => 'Pending Requests', 'value' => (string) $pendingRequests],
        ];

        $totalEnrollments = 342;
        $totalClassrooms = 12;
        $totalAttendanceRecords = 1204;
        $totalAnnouncements = 45;

        $overview = [
            ['title' => 'Total Enrollments', 'value' => (string) $totalEnrollments],
            ['title' => 'Active Classrooms', 'value' => (string) $totalClassrooms],
            ['title' => 'Attendance Records', 'value' => (string) $totalAttendanceRecords],
            ['title' => 'Total Announcements', 'value' => (string) $totalAnnouncements],
        ];

        $recentActions = [
            ['title' => 'Total Registered Users', 'subtitle' => $totalUsers.' users in the system'],
            ['title' => 'Active Courses', 'subtitle' => 'System is running smoothly'],
            ['title' => 'System Health', 'subtitle' => 'All systems operational'],
        ];

        $enrollmentPending = 18;
        $enrollmentEnrolled = 310;
        $enrollmentDropped = 14;

        return view('admin.dashboard', compact(
            'summary',
            'overview',
            'recentActions',
            'enrollmentPending',
            'enrollmentEnrolled',
            'enrollmentDropped'
        ));
    }

    public function users(): View
    {
        $users = [
            ['id' => 1,  'name' => 'Admin User',         'email' => 'admin@icas.edu',       'role' => 'admin',   'status' => 'active',   'joined' => 'Aug 15, 2022'],
            ['id' => 2,  'name' => 'Dr. Maria Santos',   'email' => 'santos@icas.edu',       'role' => 'faculty', 'status' => 'active',   'joined' => 'Jun 1, 2023'],
            ['id' => 3,  'name' => 'Prof. Juan Cruz',    'email' => 'cruz@icas.edu',         'role' => 'faculty', 'status' => 'active',   'joined' => 'Jun 1, 2023'],
            ['id' => 4,  'name' => 'Prof. Ana Dela Rosa','email' => 'delarosa@icas.edu',     'role' => 'faculty', 'status' => 'active',   'joined' => 'Jul 12, 2023'],
            ['id' => 5,  'name' => 'Miguel Santos',      'email' => 'miguel.s@school.edu',   'role' => 'student', 'status' => 'active',   'joined' => 'Sep 1, 2024'],
            ['id' => 6,  'name' => 'Andrea Reyes',       'email' => 'andrea.r@school.edu',   'role' => 'student', 'status' => 'active',   'joined' => 'Sep 1, 2024'],
            ['id' => 7,  'name' => 'Carlo Dela Cruz',    'email' => 'carlo.c@school.edu',    'role' => 'student', 'status' => 'active',   'joined' => 'Sep 1, 2024'],
            ['id' => 8,  'name' => 'Bea Villanueva',     'email' => 'bea.v@school.edu',      'role' => 'student', 'status' => 'active',   'joined' => 'Sep 1, 2023'],
            ['id' => 9,  'name' => 'Janelle Mendoza',    'email' => 'janelle.m@school.edu',  'role' => 'student', 'status' => 'active',   'joined' => 'Sep 1, 2023'],
            ['id' => 10, 'name' => 'Paolo Domingo',      'email' => 'paolo.d@school.edu',    'role' => 'student', 'status' => 'inactive', 'joined' => 'Sep 1, 2025'],
            ['id' => 11, 'name' => 'Lara Bautista',      'email' => 'lara.b@school.edu',     'role' => 'student', 'status' => 'active',   'joined' => 'Sep 1, 2024'],
            ['id' => 12, 'name' => 'Rico Fernandez',     'email' => 'rico.f@school.edu',     'role' => 'student', 'status' => 'pending',  'joined' => 'Jan 10, 2025'],
        ];
        $roleFilter   = request('role',   '');
        $statusFilter = request('status', '');
        $search       = request('search', '');
        $filtered = collect($users)
            ->when($roleFilter,   fn($c) => $c->where('role',   $roleFilter))
            ->when($statusFilter, fn($c) => $c->where('status', $statusFilter))
            ->when($search,       fn($c) => $c->filter(fn($u)  => stripos($u['name'], $search) !== false || stripos($u['email'], $search) !== false))
            ->values()
            ->all();
        $stats = [
            'total'    => count($users),
            'students' => collect($users)->where('role', 'student')->count(),
            'faculty'  => collect($users)->where('role', 'faculty')->count(),
            'admins'   => collect($users)->where('role', 'admin')->count(),
            'pending'  => collect($users)->where('status', 'pending')->count(),
        ];
        return view('admin.users', compact('filtered', 'stats', 'roleFilter', 'statusFilter', 'search'));
    }

    public function settings(): View
    {
        $schoolSettings = [
            'school_name'   => 'ICAS Learning Management System',
            'school_code'   => 'ICAS-2024',
            'academic_year' => '2024–2025',
            'semester'      => 'Second Semester',
            'enrollment_start' => 'January 6, 2025',
            'enrollment_end'   => 'January 31, 2025',
            'exam_start'       => 'March 17, 2025',
            'timezone'         => 'Asia/Manila (UTC+8)',
            'default_passing_grade' => '75%',
        ];
        return view('admin.settings', compact('schoolSettings'));
    }

    public function attendance(Request $request): View
    {
        $filters = $this->resolveAttendanceFilters($request);
        $activeFilters = collect($filters)
            ->filter(function (string $value): bool {
                return $value !== '';
            })
            ->all();

        $baseQuery = $this->queryAttendanceRecords($filters);

        $totalRecords = (clone $baseQuery)->count();
        $presentRecords = (clone $baseQuery)->where('status', 'Present')->count();
        $absentRecords = (clone $baseQuery)->where('status', 'Absent')->count();
        $lateRecords = (clone $baseQuery)->where('status', 'Late')->count();
        $uniqueStudents = (clone $baseQuery)
            ->select('student_name')
            ->distinct()
            ->count('student_name');

        $attendanceRate = $totalRecords > 0
            ? (string) round(($presentRecords / $totalRecords) * 100).'%'
            : '0%';

        $summary = [
            ['label' => 'Total Records', 'value' => (string) $totalRecords],
            ['label' => 'Present', 'value' => (string) $presentRecords],
            ['label' => 'Absent', 'value' => (string) $absentRecords],
            ['label' => 'Late', 'value' => (string) $lateRecords],
            ['label' => 'Attendance Rate', 'value' => $attendanceRate],
            ['label' => 'Unique Students', 'value' => (string) $uniqueStudents],
        ];

        $records = (clone $baseQuery)
            ->with(['faculty:id,name'])
            ->orderByDesc('attendance_date')
            ->orderBy('student_name')
            ->paginate(12)
            ->withQueryString();

        $classOptions = FacultyAttendanceRecord::query()
            ->select('student_class')
            ->distinct()
            ->orderBy('student_class')
            ->pluck('student_class')
            ->all();

        $facultyOptions = User::query()
            ->where('role', 'faculty')
            ->whereHas('facultyAttendanceRecords')
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(function (User $faculty): array {
                return [
                    'id' => $faculty->id,
                    'name' => $faculty->name,
                ];
            })
            ->all();

        return view('admin.attendance', compact('summary', 'records', 'filters', 'activeFilters', 'classOptions', 'facultyOptions'));
    }

    public function grades(): View
    {
        $grades = StudentModuleRecord::query()
            ->whereNotNull('grade_percent')
            ->selectRaw('module_name, AVG(grade_percent) as average_grade')
            ->groupBy('module_name')
            ->orderBy('module_name')
            ->get()
            ->map(function (StudentModuleRecord $record): array {
                $averageGrade = (float) ($record->average_grade ?? 0);

                return [
                    'course' => $record->module_name,
                    'average' => number_format($averageGrade, 0).'%',
                    'status' => $this->resolveGradeStatus($averageGrade),
                ];
            })
            ->all();

        return view('admin.grades', compact('grades'));
    }

    public function exportGrades(): StreamedResponse
    {
        $records = StudentModuleRecord::query()
            ->with(['user:id,name,email'])
            ->orderBy('module_name')
            ->orderBy('module_code')
            ->get();

        $filename = 'grade-generator-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($records): void {
            $output = fopen('php://output', 'w');

            if ($output === false) {
                return;
            }

            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Student Name', 'Student Email', 'Module Name', 'Module Code', 'Instructor', 'Schedule', 'Grade Percent']);

            foreach ($records as $record) {
                fputcsv($output, [
                    $record->user?->name ?? 'Unknown Student',
                    $record->user?->email ?? '',
                    $record->module_name,
                    $record->module_code,
                    $record->instructor ?? '',
                    $record->schedule ?? '',
                    $record->grade_percent !== null ? number_format((float) $record->grade_percent, 2) : '',
                ]);
            }

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
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

    /**
     * @return array{search: string, status: string, student_class: string, faculty_user_id: string, from_date: string, to_date: string}
     */
    private function resolveAttendanceFilters(Request $request): array
    {
        $status = trim((string) $request->query('status', ''));

        if (! in_array($status, ['Present', 'Absent', 'Late'], true)) {
            $status = '';
        }

        $facultyUserId = trim((string) $request->query('faculty_user_id', ''));

        if ($facultyUserId !== '' && ! ctype_digit($facultyUserId)) {
            $facultyUserId = '';
        }

        return [
            'search' => trim((string) $request->query('search', '')),
            'status' => $status,
            'student_class' => trim((string) $request->query('student_class', '')),
            'faculty_user_id' => $facultyUserId,
            'from_date' => trim((string) $request->query('from_date', '')),
            'to_date' => trim((string) $request->query('to_date', '')),
        ];
    }

    /**
     * @param  array{search: string, status: string, student_class: string, faculty_user_id: string, from_date: string, to_date: string}  $filters
     */
    private function queryAttendanceRecords(array $filters): Builder
    {
        return FacultyAttendanceRecord::query()
            ->when($filters['search'] !== '', function (Builder $query) use ($filters): void {
                $query->where('student_name', 'like', '%'.$filters['search'].'%');
            })
            ->when($filters['status'] !== '', function (Builder $query) use ($filters): void {
                $query->where('status', $filters['status']);
            })
            ->when($filters['student_class'] !== '', function (Builder $query) use ($filters): void {
                $query->where('student_class', $filters['student_class']);
            })
            ->when($filters['faculty_user_id'] !== '', function (Builder $query) use ($filters): void {
                $query->where('faculty_user_id', (int) $filters['faculty_user_id']);
            })
            ->when($filters['from_date'] !== '', function (Builder $query) use ($filters): void {
                $query->whereDate('attendance_date', '>=', $filters['from_date']);
            })
            ->when($filters['to_date'] !== '', function (Builder $query) use ($filters): void {
                $query->whereDate('attendance_date', '<=', $filters['to_date']);
            });
    }

    private function resolveGradeStatus(float $averageGrade): string
    {
        if ($averageGrade >= 85) {
            return 'On track';
        }

        if ($averageGrade >= 75) {
            return 'Needs review';
        }

        return 'At risk';
    }

    public function enrollments(Request $request): View
    {
        $tab = in_array($request->query('tab'), ['pending', 'enrolled', 'dropped'], true)
            ? $request->query('tab')
            : 'pending';

        $courseFilter = trim((string) $request->query('course', ''));

        $enrollments = StudentModuleRecord::query()
            ->where('enrollment_status', $tab)
            ->with(['user:id,name,email'])
            ->when($courseFilter !== '', function ($query) use ($courseFilter): void {
                $query->where('module_code', $courseFilter);
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $enrolledCount = StudentModuleRecord::where('enrollment_status', 'enrolled')->count();
        $pendingCount = StudentModuleRecord::where('enrollment_status', 'pending')->count();
        $droppedCount = StudentModuleRecord::where('enrollment_status', 'dropped')->count();

        $summary = [
            ['label' => 'Pending', 'value' => (string) $pendingCount, 'color' => 'amber', 'tab' => 'pending'],
            ['label' => 'Enrolled', 'value' => (string) $enrolledCount, 'color' => 'emerald', 'tab' => 'enrolled'],
            ['label' => 'Dropped', 'value' => (string) $droppedCount, 'color' => 'rose', 'tab' => 'dropped'],
        ];

        $courseOptions = StudentModuleRecord::query()
            ->select('module_code', 'module_name')
            ->distinct()
            ->orderBy('module_name')
            ->get()
            ->map(fn (StudentModuleRecord $r): array => [
                'code' => $r->module_code,
                'name' => $r->module_name,
            ])
            ->all();

        return view('admin.enrollments', compact('enrollments', 'summary', 'tab', 'courseFilter', 'courseOptions'));
    }

    public function approveEnrollment(StudentModuleRecord $moduleRecord): RedirectResponse
    {
        $moduleRecord->update(['enrollment_status' => 'enrolled']);

        return redirect()
            ->route('admin.enrollments', ['tab' => 'pending'])
            ->with('status', 'Enrollment approved for '.$moduleRecord->user->name.' in '.$moduleRecord->module_name.'.');
    }

    public function assignSection(Request $request, StudentModuleRecord $moduleRecord): RedirectResponse
    {
        $validated = $request->validate([
            'section' => ['required', 'string', 'max:50'],
        ]);

        $moduleRecord->update(['section' => $validated['section']]);

        return redirect()
            ->route('admin.enrollments', ['tab' => request()->query('tab', 'pending')])
            ->with('status', 'Section assigned: '.$validated['section'].' for '.$moduleRecord->user->name.'.');
    }

    public function encodeCourse(Request $request, StudentModuleRecord $moduleRecord): RedirectResponse
    {
        $validated = $request->validate([
            'module_name' => ['required', 'string', 'max:255'],
            'module_code' => ['required', 'string', 'max:20'],
            'instructor'  => ['nullable', 'string', 'max:255'],
            'schedule'    => ['nullable', 'string', 'max:255'],
        ]);

        $moduleRecord->update($validated);

        return redirect()
            ->route('admin.enrollments', ['tab' => 'enrolled'])
            ->with('status', 'Course details updated for '.$moduleRecord->user->name.'.');
    }

    public function auditTrail(Request $request): View
    {
        $actions = [
            ['time' => 'Apr 21, 2026 10:42 AM', 'user' => 'Admin User',         'role' => 'admin',   'action' => 'Login',    'module' => 'Auth',         'ip' => '192.168.1.5',   'detail' => 'Logged in successfully'],
            ['time' => 'Apr 21, 2026 10:45 AM', 'user' => 'Admin User',         'role' => 'admin',   'action' => 'Update',   'module' => 'Enrollments',  'ip' => '192.168.1.5',   'detail' => 'Approved enrollment for Ana Reyes — MATH301'],
            ['time' => 'Apr 21, 2026 10:48 AM', 'user' => 'Admin User',         'role' => 'admin',   'action' => 'Create',   'module' => 'Announcements','ip' => '192.168.1.5',   'detail' => 'Posted new announcement: "Mid-term Schedule"'],
            ['time' => 'Apr 21, 2026 11:00 AM', 'user' => 'Dr. Maria Fernandez','role' => 'faculty', 'action' => 'Login',    'module' => 'Auth',         'ip' => '192.168.1.12',  'detail' => 'Logged in successfully'],
            ['time' => 'Apr 21, 2026 11:03 AM', 'user' => 'Dr. Maria Fernandez','role' => 'faculty', 'action' => 'Create',   'module' => 'Classrooms',   'ip' => '192.168.1.12',  'detail' => 'Created classroom: Advanced Mathematics (MATH301)'],
            ['time' => 'Apr 21, 2026 11:15 AM', 'user' => 'Dr. Maria Fernandez','role' => 'faculty', 'action' => 'Create',   'module' => 'Attendance',   'ip' => '192.168.1.12',  'detail' => 'Marked attendance for 28 students — MATH301'],
            ['time' => 'Apr 21, 2026 11:30 AM', 'user' => 'Ana Reyes',          'role' => 'student', 'action' => 'Login',    'module' => 'Auth',         'ip' => '192.168.1.22',  'detail' => 'Logged in successfully'],
            ['time' => 'Apr 21, 2026 11:32 AM', 'user' => 'Ana Reyes',          'role' => 'student', 'action' => 'Create',   'module' => 'Enrollment',   'ip' => '192.168.1.22',  'detail' => 'Enrolled in Physics I (PHY201)'],
            ['time' => 'Apr 21, 2026 11:45 AM', 'user' => 'Ana Reyes',          'role' => 'student', 'action' => 'Create',   'module' => 'Documents',    'ip' => '192.168.1.22',  'detail' => 'Submitted document request: Transcript'],
            ['time' => 'Apr 21, 2026 12:00 PM', 'user' => 'Admin User',         'role' => 'admin',   'action' => 'Update',   'module' => 'Documents',    'ip' => '192.168.1.5',   'detail' => 'Updated request status to Processing'],
            ['time' => 'Apr 21, 2026 12:10 PM', 'user' => 'Miguel Santos',      'role' => 'student', 'action' => 'Login',    'module' => 'Auth',         'ip' => '192.168.1.31',  'detail' => 'Logged in successfully'],
            ['time' => 'Apr 21, 2026 12:12 PM', 'user' => 'Miguel Santos',      'role' => 'student', 'action' => 'Create',   'module' => 'Forum',        'ip' => '192.168.1.31',  'detail' => 'Posted new thread: "Physics Exam Tips"'],
            ['time' => 'Apr 21, 2026 12:30 PM', 'user' => 'Mr. Paulo Navarro',  'role' => 'faculty', 'action' => 'Update',   'module' => 'Grades',       'ip' => '192.168.1.14',  'detail' => 'Encoded grades for Miguel Santos — PHY201'],
            ['time' => 'Apr 21, 2026 01:00 PM', 'user' => 'Admin User',         'role' => 'admin',   'action' => 'Delete',   'module' => 'Forum',        'ip' => '192.168.1.5',   'detail' => 'Removed flagged forum post #42'],
            ['time' => 'Apr 21, 2026 01:15 PM', 'user' => 'Sofia Cruz',         'role' => 'student', 'action' => 'Logout',   'module' => 'Auth',         'ip' => '192.168.1.28',  'detail' => 'Logged out'],
            ['time' => 'Apr 21, 2026 01:30 PM', 'user' => 'Dr. Maria Fernandez','role' => 'faculty', 'action' => 'Update',   'module' => 'Classrooms',   'ip' => '192.168.1.12',  'detail' => 'Updated classroom status to inactive'],
            ['time' => 'Apr 21, 2026 01:45 PM', 'user' => 'Admin User',         'role' => 'admin',   'action' => 'Update',   'module' => 'Enrollments',  'ip' => '192.168.1.5',   'detail' => 'Assigned Section A to Sofia Cruz — HIST201'],
            ['time' => 'Apr 21, 2026 02:00 PM', 'user' => 'Admin User',         'role' => 'admin',   'action' => 'Logout',   'module' => 'Auth',         'ip' => '192.168.1.5',   'detail' => 'Logged out'],
        ];

        $userFilter   = trim((string) $request->query('user', ''));
        $roleFilter   = trim((string) $request->query('role', ''));
        $actionFilter = trim((string) $request->query('action', ''));
        $dateFilter   = trim((string) $request->query('date', ''));

        if ($userFilter !== '') {
            $actions = array_filter($actions, fn (array $a): bool => str_contains(strtolower($a['user']), strtolower($userFilter)));
        }
        if ($roleFilter !== '') {
            $actions = array_filter($actions, fn (array $a): bool => $a['role'] === $roleFilter);
        }
        if ($actionFilter !== '') {
            $actions = array_filter($actions, fn (array $a): bool => $a['action'] === $actionFilter);
        }

        $stats = [
            ['label' => 'Total Actions', 'value' => count($actions)],
            ['label' => 'Logins',        'value' => count(array_filter($actions, fn ($a) => $a['action'] === 'Login'))],
            ['label' => 'Creates',       'value' => count(array_filter($actions, fn ($a) => $a['action'] === 'Create'))],
            ['label' => 'Updates',       'value' => count(array_filter($actions, fn ($a) => $a['action'] === 'Update'))],
            ['label' => 'Deletes',       'value' => count(array_filter($actions, fn ($a) => $a['action'] === 'Delete'))],
        ];

        return view('admin.audit-trail', [
            'actions'      => array_values($actions),
            'stats'        => $stats,
            'userFilter'   => $userFilter,
            'roleFilter'   => $roleFilter,
            'actionFilter' => $actionFilter,
            'dateFilter'   => $dateFilter,
        ]);
    }

    public function systemMonitoring(): View
    {
        $serverStats = [
            ['label' => 'CPU Usage',    'value' => 34,  'unit' => '%',  'color' => 'emerald', 'status' => 'Normal'],
            ['label' => 'Memory Usage', 'value' => 61,  'unit' => '%',  'color' => 'amber',   'status' => 'Moderate'],
            ['label' => 'Disk Usage',   'value' => 47,  'unit' => '%',  'color' => 'sky',     'status' => 'Normal'],
            ['label' => 'Network I/O',  'value' => 18,  'unit' => 'MB/s','color' => 'violet', 'status' => 'Normal'],
        ];

        $platformStats = [
            ['label' => 'Total Users',          'value' => '134',  'icon' => 'users'],
            ['label' => 'Active Sessions',       'value' => '12',   'icon' => 'activity'],
            ['label' => 'Total Classrooms',      'value' => '8',    'icon' => 'classroom'],
            ['label' => 'Attendance Records',    'value' => '1,204','icon' => 'check'],
            ['label' => 'Document Requests',     'value' => '47',   'icon' => 'doc'],
            ['label' => 'Forum Posts',           'value' => '89',   'icon' => 'chat'],
        ];

        $registrationTrend = [
            ['month' => 'Nov', 'students' => 12, 'faculty' => 2],
            ['month' => 'Dec', 'students' => 8,  'faculty' => 0],
            ['month' => 'Jan', 'students' => 31, 'faculty' => 3],
            ['month' => 'Feb', 'students' => 24, 'faculty' => 1],
            ['month' => 'Mar', 'students' => 38, 'faculty' => 4],
            ['month' => 'Apr', 'students' => 21, 'faculty' => 2],
        ];

        $healthChecks = [
            ['name' => 'Database Connection',  'status' => 'ok',      'detail' => 'MySQL connected'],
            ['name' => 'Cache (Redis)',         'status' => 'ok',      'detail' => 'Redis responding'],
            ['name' => 'Email Server',         'status' => 'ok',      'detail' => 'SMTP reachable'],
            ['name' => 'File Storage',         'status' => 'ok',      'detail' => 'Disk writable'],
            ['name' => 'Queue Worker',         'status' => 'warning', 'detail' => '2 failed jobs pending'],
            ['name' => 'SSL Certificate',      'status' => 'ok',      'detail' => 'Expires in 88 days'],
        ];

        return view('admin.system-monitoring', compact('serverStats', 'platformStats', 'registrationTrend', 'healthChecks'));
    }
}

