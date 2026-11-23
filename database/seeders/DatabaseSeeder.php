<?php

namespace Database\Seeders;

use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $profesor = User::updateOrCreate(
            ['email' => 'profesor@escuela.edu.mx'],
            [
                'name' => 'Prof. Carlos Mendoza',
                'password' => Hash::make('Profesor1234!'),
                'role' => 'profesor',
            ]
        );

        $alumno1 = User::updateOrCreate(
            ['email' => 'alumno@escuela.edu.mx'],
            [
                'name' => 'Ana Sofía Ramírez',
                'password' => Hash::make('Alumno1234!'),
                'role' => 'alumno',
            ]
        );

        StudentRecord::updateOrCreate(
            ['user_id' => $alumno1->id],
            [
                'student_name' => 'Ana Sofía Ramírez',
                'absences' => 2,
                'grade' => 9.4,
            ]
        );

        $registrosExtra = [
            ['student_name' => 'Luis Fernando Torres', 'absences' => 6, 'grade' => 5.2],
            ['student_name' => 'Valeria Guadalupe Cruz', 'absences' => 1, 'grade' => 8.3],
            ['student_name' => 'Diego Alejandro Ruiz', 'absences' => 4, 'grade' => 6.8],
        ];

        foreach ($registrosExtra as $item) {
            StudentRecord::updateOrCreate(
                ['student_name' => $item['student_name']],
                [
                    'user_id' => null,
                    'absences' => $item['absences'],
                    'grade' => $item['grade'],
                ]
            );
        }
    }
}