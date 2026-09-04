<?php 

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->call->database();

        $this->call->model('UserModel');

        $data['users'] = $this->UserModel->all();

        $this->call->view('Usersview', $data);
    }
}

?>