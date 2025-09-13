<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Interview;
use App\Models\Question;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@intervue.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $reviewer = User::create([
            'name' => 'Reviewer User',
            'email' => 'reviewer@intervue.com',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
        ]);

        $candidate = User::create([
            'name' => 'Candidate User',
            'email' => 'candidate@intervue.com',
            'password' => bcrypt('password'),
            'role' => 'candidate',
        ]);

        $interview = Interview::create([
            'title' => 'Software Developer Position',
            'description' => 'This interview is for the Software Developer position at our company. Please answer the following questions.',
            'created_by' => $admin->id,
        ]);

        $question1 = Question::create([
            'question_text' => 'Tell us about your experience with web development.',
            'time_limit' => 120, // 2 minutes
            'interview_id' => $interview->id,
        ]);

        $question2 = Question::create([
            'question_text' => 'Describe a challenging project you worked on and how you overcame the challenges.',
            'time_limit' => 180,
            'interview_id' => $interview->id,
        ]);

        $question3 = Question::create([
            'question_text' => 'How do you stay updated with the latest trends and technologies in software development?',
            'time_limit' => 90,
            'interview_id' => $interview->id,
        ]);


        $interview2 = Interview::create([
            'title' => 'Frontend Developer Position',
            'description' => 'This interview is for the Frontend Developer position. Please answer the following questions.',
            'created_by' => $reviewer->id,
        ]);

        $question4 = Question::create([
            'question_text' => 'What is your experience with JavaScript frameworks like React, Vue, or Angular?',
            'time_limit' => 120,
            'interview_id' => $interview2->id,
        ]);

        $question5 = Question::create([
            'question_text' => 'How do you ensure your web applications are responsive and accessible?',
            'time_limit' => 150,
            'interview_id' => $interview2->id,
        ]);
    }
}
