<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function counts()
    {
        $batches = Batch::count();
        $total_students = Student::count();
        $students = Student::where('status', 1)->count();
        $graduated = Student::where('status', 2)->count();

        return [
            'batches' => $batches,
            'total_students' => $total_students,
            'students' => $students,
            'graduated' => $graduated
        ];
    }

    public function batchCounts()
    {
        $batches = Batch::all();
        $data = [];

        if ($batches && count($batches) > 0) {
            foreach ($batches as $key => $batch) {
                $total_students = $batch->students()->count();
                $dropped = $batch->students()->where('status', 0)->count();
                $dropped_perc = $this->getPercentage($dropped, $total_students);
                $studying = $batch->students()->where('status', 1)->count();
                $studying_perc = $this->getPercentage($studying, $total_students);
                $graduated = $batch->students()->where('status', 2)->count();
                $graduated_perc = $this->getPercentage($graduated, $total_students);

                array_push($data, [
                    'name' => $batch->name,
                    'start' => Carbon::parse($batch->start)->format('d-m-Y'),
                    'end' => Carbon::parse($batch->end)->format('d-m-Y'),
                    'total_students' => $total_students,
                    'dropped' => $dropped,
                    'dropped_perc' => $dropped_perc,
                    'studying' => $studying,
                    'studying_perc' => $studying_perc,
                    'graduated' => $graduated,
                    'graduated_perc' => $graduated_perc
                ]);
            }
        }

        return $data;
    }


    private function getPercentage($number, $total)
    {
        if ($number > 0 && $total > 0) {
            // number x 100 / total
            $perc = ($number * 100) / $total;

            if (floor($perc) != $perc) {
                return number_format($perc, 2);
            } else {
                return $perc;
            }
        } else {
            return 0;
        }
    }
}
