<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
class StudentController extends Controller
{
    public function index()
    {
        $student = [
           'student_id' => 'MCC2024-00086',
            'name' => 'Adrian James Famadulan',
            'course' => 'BS Information Technology',
            'year' => '3nd Year',
            'section' => '3-F2',
            'email' => 'ajfamadulan8@gmail.com',
            'address' => 'Bonbon Taas, Calapan City',
            'ContactNumber' => '09618223822',
            'hobbies' => 'Drawing, Playing Games, Playing Guitar, Listening Music',
            'social_media' => [
                'facebook'  => 'https://www.facebook.com/aj.famadulan',
                'github'    => 'https://github.com/Sh1rr0',
                'render'    => 'https://famadulan-adrian-lavalust.onrender.com',   
            ]
           
        ];
        $this->call->view('student_home', $student);

    }
    public function profile()
    {
        $student = [
            'student_id' => 'MCC2024-00086',
            'name' => 'Adrian James Famadulan',
            'course' => 'BS Information Technology',
            'year' => '3nd Year',
            'section' => '3-F2',
            'email' => 'ajfamadulan8@gmail.com',
            'address' => 'Bonbon Taas, Calapan City',
            'ContactNumber' => '09618223822',
            'hobbies' => 'Drawing, Playing Games, Playing Guitar, Listening Music',
            'social_media' => [
                'facebook'  => 'https://www.facebook.com/aj.famadulan',
                'github'    => 'https://github.com/Sh1rr0',
                'render'    => 'https://famadulan-adrian-lavalust.onrender.com',   
            ]
           
        ];
         $this->call->view('student_profile', $student);

    }
}