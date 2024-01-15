<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Stamp;

class StampController extends Controller
{
    public function clockIn()
    {
        auth()->user()->stamps()->create([
            'timestamp' => now(),
            'is_working' => true,
            'is_on_break' => false,
        ]);

        return redirect()->back();
    }

    public function clockOut()
    {
        auth()->user()->stamps()->create([
            'timestamp' => now(),
            'is_working' => false,
            'is_on_break' => false,
        ]);

        return redirect()->back();
    }

    public function clock()
    {
        $user = auth()->user();
        $lastStamp = $user->stamps()->latest()->first();

        if ($this->isDifferentDay($lastStamp)) {
            $this->startWorking($user);
        } else {
            $this->updateWorkingStatus($user, $lastStamp);
        }

        return redirect()->back();
    }

    private function isDifferentDay($lastStamp)
    {
        return $lastStamp && now()->diffInDays($lastStamp->timestamp) > 0;
    }

    private function startWorking($user)
    {
        $user->stamps()->create([
            'timestamp' => now(),
            'is_working' => true,
            'is_on_break' => false,
        ]);
    }

    private function updateWorkingStatus($user, $lastStamp)
    {
        if ($this->isMidnight() && $lastStamp) {
            $this->handleMidnightCase($user, $lastStamp);
        } else {
            $this->updateStatusBasedOnTime($user, $lastStamp);
        }
    }

    private function isMidnight()
    {
        return now()->hour === 0 && now()->minute === 0;
    }

    private function handleMidnightCase($user, $lastStamp)
    {
        if ($lastStamp->is_working) {
            $lastStamp->update([
                'timestamp' => now(),
                'is_working' => false,
                'is_on_break' => false,
            ]);

            $this->startWorking($user);
        } elseif ($lastStamp->is_on_break) {
            $lastStamp->update([
                'timestamp' => now(),
                'is_working' => false,
                'is_on_break' => false,
            ]);

            $this->startWorking($user);
        }
    }

    private function updateStatusBasedOnTime($user, $lastStamp)
    {
        $user->stamps()->create([
            'timestamp' => now(),
            'is_working' => !$lastStamp || !$lastStamp->is_working,
            'is_on_break' => $lastStamp && $lastStamp->is_working && !$lastStamp->is_on_break,
        ]);
    }
    public function index()
    {
        $stamps = Stamp::all();
        return view('stamps.index', compact('stamps'));
    }
}