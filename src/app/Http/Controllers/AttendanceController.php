<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;

class AttendanceController extends Controller
{
    public function showAttendancePage()
    {
        $user = auth()->user();
        $latestWork = $user->works()->latest()->first();
        $hasStartedWork = $latestWork && $latestWork->action == 'start_work';
        $hasStartedBreak = $latestWork && $latestWork->action == 'start_break';

        return view('auth.attendance', compact('hasStartedWork', 'hasStartedBreak'));
    }
    public function startWork()
    {
        $userId = auth()->user()->id;

        $hasStartedBreak = Work::where('user_id', $userId)
        ->where('action', 'start_break')
        ->latest()
        ->first();

        if ($hasStartedBreak) {
            return redirect()->back()->with('warning', '休憩中は休憩終了ボタンか勤務終了ボタンを押してください。');
        }

        if (Work::where('user_id', $userId)->where('action', 'start_work')->exists()) {
            return redirect()->back()->with('warning', '既に勤務が開始されています。');
        }

        Work::create([
            'user_id' => $userId,
            'action' => 'start_work',
            'timestamp' => now(),
        ]);

        return redirect()->back()->with('success', '勤務を開始しました。');
    }

    public function endWork()
    {
        $userId = auth()->user()->id;

        if (Work::where('user_id', $userId)->where('action', 'end_work')->exists()) {
            return redirect()->back()->with('warning', '既に勤務が終了しています。');
        }

        if (!Work::where('user_id', $userId)->where('action', 'start_break')->exists()) {
            return redirect()->back()->with('warning', '休憩が開始されていません。');
        }

        Work::create([
            'user_id' => $userId,
            'action' => 'end_work',
            'timestamp' => now(),
        ]);

        return redirect()->back()->with('success', '勤務を終了しました。');
    }

    public function startBreak()
    {
        $userId = auth()->user()->id;

        if (Work::where('user_id', $userId)->where('action', 'start_break')->exists()) {
            return redirect()->back()->with('warning', '既に休憩が開始されています。');
        }

        if (!Work::where('user_id', $userId)->where('action', 'start_work')->exists()) {
            return redirect()->back()->with('warning', '勤務が開始されていません。');
        }

        Work::create([
            'user_id' => $userId,
            'action' => 'start_break',
            'timestamp' => now(),
        ]);

        return redirect()->back()->with('success', '休憩を開始しました。');
    }

    public function endBreak()
    {
        $userId = auth()->user()->id;

        if (!Work::where('user_id', $userId)->where('action', 'start_work')->exists()) {
            return redirect()->back()->with('warning', '勤務が開始されていません。');
        }

        $latestBreak = Work::where('user_id', $userId)
            ->where('action', 'start_break')
            ->latest()
            ->first();

        if (!$latestBreak || $latestBreak->action == 'end_break') {
            return redirect()->back()->with('warning', '休憩が開始されていません。');
        }

        Work::create([
            'user_id' => $userId,
            'action' => 'end_break',
            'timestamp' => now(),
        ]);

        return redirect()->back()->with('success', '休憩を終了しました。');
    }

}
