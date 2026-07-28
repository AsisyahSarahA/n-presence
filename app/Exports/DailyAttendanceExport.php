<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DailyAttendanceExport implements FromView, ShouldAutoSize
{
    protected $attendances;
    protected $date;
    protected $classRoom;
    protected $schoolName;

    public function __construct($attendances, $date, $classRoom, $schoolName)
    {
        $this->attendances = $attendances;
        $this->date = $date;
        $this->classRoom = $classRoom;
        $this->schoolName = $schoolName;
    }

    public function view(): View
    {
        return view('exports.daily-excel', [
            'attendances' => $this->attendances,
            'date' => $this->date,
            'classRoom' => $this->classRoom,
            'schoolName' => $this->schoolName
        ]);
    }
}
