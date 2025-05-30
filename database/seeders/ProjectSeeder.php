<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $date = Carbon::now();
        $date1 = Carbon::tomorrow();
        $projects = [
            ['Project1', 'Description1', $date, $date1],
            ['Project2', 'Description2', $date, $date1],
            ['Project3', 'Description3', $date, $date1],
            ['Project4', 'Description4', $date, $date1],
            ['Project5', 'Description5', $date, $date1],
            ['Project6', 'Description6', $date, $date1],
            ['Project7', 'Description7', $date, $date1],
            ['Project8', 'Description8', $date, $date1],
            ['Project9', 'Description9', $date, $date1],
            ['Project10', 'Description10', $date, $date1],
        ];

        foreach ($projects as $projectName) {
            Project::create(['name' => $projectName[0], 'description' => $projectName[1], 'start'=> $projectName[2], 'end'=> $projectName[3]]);
        }
    }
}
