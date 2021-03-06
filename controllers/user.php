<?php

class User extends Controller {

    function __construct() {

        parent::__construct();
        // restrict access only to admin and onwer
        Authenticate::adminAuth();
    }

    /**
     * Display user management page
     *
     * @return void
     */
    function index() {

        $this->view->title = 'Users';
        $this->view->breadcumb = '<a href="' . URL . '">Home</a> <i class="fas fa-angle-right"></i> <a href="' . URL . 'controlPanel">Control Panel</a> <i class="fas fa-angle-right"></i> Users';

        // get number of new users
        $this->view->newUserCount = $this->model->userCount('new');
        // get number of verified users
        $this->view->verifiedUserCount = $this->model->userCount('verified');
        // get the userlist with their details
        if (isset($_GET['filter'])) {
            if ($_GET['filter'] == 'new') {
                $this->view->userList = $this->model->listUsers('new');
            } else if ($_GET['filter'] == 'verified') {
                $this->view->userList = $this->model->listUsers('verified');
            } else if ($_GET['filter'] == 'all') {
                $this->view->userList = $this->model->listUsers('');
            }
        } else {
            $this->view->userList = $this->model->listUsers();
        }

        $this->view->render('control_panel/admin/user');
    }

    /**
     * Add new user
     *
     * @return void
     */
    function create() {

        $data = array();
        $data['first_name'] = $_POST['first_name'];
        $data['last_name'] = $_POST['last_name'];
        $data['gender'] = $_POST['gender'];
        $data['email'] = $_POST['email'];
        $data['contact_no'] = $_POST['contact_no'];
        $data['username'] = $_POST['email'];
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $data['user_status'] = 'new';
        $data['user_type'] = $_POST['user_type'];

        //check whether the user exists already
        if (!$this->model->checkExists($data['username'])) {
            $this->model->create($data);
            header('location: ' . URL . 'user');
        } else {
            header('location: ' . URL . 'user?error=usernameExists#message');
        }
    }

    /**
     * Display edit user page
     *
     * @param  mixed $id User id of the user that need to br updated
     * @param  mixed $type User type of the user that need to be updated
     * @return void
     */
    function edit($id, $type) {

        $this->view->title = 'Users';
        $this->view->breadcumb = '<a href="' . URL . '">Home</a> <i class="fas fa-angle-right"></i> <a href="' . URL . 'controlPanel">Control Panel</a> <i class="fas fa-angle-right"></i><a href="' . URL . 'users">Users</a> <i class="fas fa-angle-right"></i>Edit User';

        // get the particular user details to load to the edit form
        $this->view->user = $this->model->getUser($id, $type);
        //if the action is performed by the admin and the corresponding user is the owner, deny the access
        if ($this->view->user[0]['user_type'] == 'owner' && Session::get('userType') != 'owner') {
            header('Location: ' . URL . 'user?error=accessDenied#message');
        } else {
            $this->view->render('control_panel/admin/edit_user');
        }
    }

    /**
     * Update exisiting user details
     *
     * @return void
     */
    function editSave() {

        $data = array();
        $data['first_name'] = $_POST['first_name'];
        $data['last_name'] = $_POST['last_name'];
        $data['gender'] = $_POST['gender'];
        $data['email'] = $_POST['email'];
        $data['contact_no'] = $_POST['contact_no'];
        $data['username'] = $_POST['email'];
        $data['user_status'] = $_POST['user_status'];
        $data['user_type'] = $_POST['user_type'];
        $data['user_id'] = $_POST['user_id'];
        $data['prev_user_type'] = $_POST['prev_user_type'];
        $data['login_id'] = $_POST['login_id'];

        // check whether the new email address already exists
        if (!$this->model->checkExistsWhere($data['username'], $data['login_id'])) {
            $this->model->update($data);
            header('location: ' . URL . 'user');
        } else {
            header('location: ' . URL . 'user?error=usernameExists#message');
        }
    }

    /**
     * Delete exisiting user
     *
     * @param  mixed $id User id of the user that need to be deleted
     * @param  mixed $type User type of the user that need to be deleted
     * @return void
     */
    function delete($id, $type) {

        $this->view->user = $this->model->getUser($id, $type);
        //if the action is performed by the admin and the corresponding user is the owner, deny the access
        if ($this->view->user[0]['user_type'] == 'owner' && Session::get('userType') != 'owner') {
            header('Location: ' . URL . 'user?error=accessDenied#message');
        } else {
            $this->model->delete($id, $type);
            header('location: ' . URL . 'user');
        }
    }

    /**
     * Load the data of a particular user
     *
     * @param  mixed $id User id of the user that the details should be retireved
     * @param  mixed $type User type of the user that the details should be retireved
     * @return mixed
     */
    function loadUserData($id, $type) {
        return $this->model->getUser($id, $type);
    }
}
