<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssistanceTeacher>
 */
class AssistanceTeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $counter = Teacher::count();
        $training_module = ["Profesional/Especialidad", "Transversal/Empleabilidad"];
        $period = ["Segundo", "Cuarto", "Sexto"];
        $turn = ["Diurno","Nocturno"];

        $place = ["Aula","Laboratorio","Taller"];

        $educational_platforms = [
            "Moodle Institucional", 
            "Google Meet", 
            "Otro", 
            "Moodle Institucional, Google Meet", 
            "Google Meet, Otro", 
            "Moodle Institucional, Otro", 
            "Moodle Institucional, Google Meet, Otro"
        ];

        return [
            'teacher_id' => rand(1, $counter),
            'training_module' => $training_module[rand(0,1)],
            'period' => $period[rand(0,2)],
            'turn' => $turn[rand(0,1)],
            'didactic_unit' => fake()->paragraph(),

            'theme' => "Tema de hoy",
            'place' => $place[rand(0,2)],
            'educational_platforms' => $educational_platforms[rand(0,6)],
            'remarks' => fake()->paragraph(),
        ];
    }
}
