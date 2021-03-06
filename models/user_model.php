<?php

class User_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function listUsers($filter = false) {

        $customers = array();
        $admins = array();
        $admins = array();
        $deliveryStaffs = array();

        if ($filter==false) {
            $customers = $this->db->runQuery("SELECT customer.user_id,customer.first_name,customer.last_name,customer.gender,customer.email,customer.contact_no,customer.is_deleted,login.user_status,login.user_type FROM customer INNER JOIN login ON customer.login_id=login.login_id");
            $admins = $this->db->runQuery("SELECT admin.user_id,admin.first_name,admin.last_name,admin.gender,admin.email,admin.contact_no,admin.is_deleted,login.user_status,login.user_type FROM admin INNER JOIN login ON admin.login_id=login.login_id");
            $owners = $this->db->runQuery("SELECT owner.user_id,owner.first_name,owner.last_name,owner.gender,owner.email,owner.contact_no,owner.is_deleted,login.user_status,login.user_type FROM owner INNER JOIN login ON owner.login_id=login.login_id");
            $deliveryStaffs = $this->db->runQuery("SELECT delivery_staff.user_id,delivery_staff.first_name,delivery_staff.last_name,delivery_staff.gender,delivery_staff.email,delivery_staff.is_deleted,delivery_staff.contact_no,login.user_status,login.user_type FROM delivery_staff INNER JOIN login ON delivery_staff.login_id=login.login_id");
        } else {
            $customers = $this->db->runQuery("SELECT customer.user_id,customer.first_name,customer.last_name,customer.gender,customer.email,customer.contact_no,customer.is_deleted,login.user_status,login.user_type FROM customer INNER JOIN login ON customer.login_id=login.login_id WHERE login.user_status=:filter",array('filter'=>$filter));
            $admins = $this->db->runQuery("SELECT admin.user_id,admin.first_name,admin.last_name,admin.gender,admin.email,admin.contact_no,admin.is_deleted,login.user_status,login.user_type FROM admin INNER JOIN login ON admin.login_id=login.login_id  WHERE login.user_status=:filter",array('filter'=>$filter));
            $owners = $this->db->runQuery("SELECT owner.user_id,owner.first_name,owner.last_name,owner.gender,owner.email,owner.contact_no,owner.is_deleted,login.user_status,login.user_type FROM owner INNER JOIN login ON owner.login_id=login.login_id WHERE login.user_status=:filter",array('filter'=>$filter));
            $deliveryStaffs = $this->db->runQuery("SELECT delivery_staff.user_id,delivery_staff.first_name,delivery_staff.last_name,delivery_staff.gender,delivery_staff.email,delivery_staff.is_deleted,delivery_staff.contact_no,login.user_status,login.user_type FROM delivery_staff INNER JOIN login ON delivery_staff.login_id=login.login_id WHERE login.user_status=:filter",array('filter'=>$filter));
        }
        return array_merge($customers, $admins, $owners, $deliveryStaffs);
    }

    function getUser($id, $type) {

        if ($type == 'customer') {
            return $this->db->runQuery("SELECT customer.user_id,customer.first_name,customer.last_name,customer.gender,customer.email,customer.contact_no,login.login_id,login.user_status,login.user_type FROM customer INNER JOIN login ON customer.login_id=login.login_id WHERE customer.user_id=:id;",array('id'=>$id));
        } else if ($type == 'admin') {
            return $this->db->runQuery("SELECT admin.user_id,admin.first_name,admin.last_name,admin.gender,admin.email,admin.contact_no,login.login_id,login.user_status,login.user_type FROM admin INNER JOIN login ON admin.login_id=login.login_id WHERE admin.user_id=:id;",array('id'=>$id));
        } else if ($type == 'owner') {
            return $this->db->runQuery("SELECT owner.user_id,owner.first_name,owner.last_name,owner.gender,owner.email,owner.contact_no,login.login_id,login.user_status,login.user_type FROM owner INNER JOIN login ON owner.login_id=login.login_id WHERE owner.user_id=:id;",array('id'=>$id));
        } else if ($type == 'delivery_staff') {
            return $this->db->runQuery("SELECT delivery_staff.user_id,delivery_staff.first_name,delivery_staff.last_name,delivery_staff.gender,delivery_staff.email,delivery_staff.contact_no,login.login_id,login.user_status,login.user_type FROM delivery_staff INNER JOIN login ON delivery_staff.login_id=login.login_id WHERE delivery_staff.user_id=:id;",array('id'=>$id));
        }
    }

    function create($data) {

        $this->db->insert('login', array(
            'username' => $data['username'],
            'password' => $data['password'],
            'user_status' => $data['user_status'],
            'user_type' => $data['user_type']
        ));

        $username = $data['username'];

        $login_id = $this->db->selectOneWhere('login', array('login_id'),  'username=:username',array('username'=>$username));

        $this->db->insert($data['user_type'], array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'contact_no' => $data['contact_no'],
            'login_id' => $login_id['login_id']
        ));
    }


    function update($data) {

        if ($data['user_type'] == $data['prev_user_type']) {
            $this->db->update($data['user_type'], array(
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'email' => $data['email'],
                'contact_no' => $data['contact_no']
            ), "user_id = :user_id",array('user_id'=>$data['user_id']));

            $this->db->update('login', array('user_status' => $data['user_status'], 'username' => $data['username']), "login_id = :login_id",array('login_id'=>$data['login_id']));
        } else {
            $this->db->insert($data['user_type'], array(
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'email' => $data['email'],
                'contact_no' => $data['contact_no'],
                'login_id' => $data['login_id']
            ));

            $this->db->update('login', array('user_type' => $data['user_type'], 'user_status' => $data['user_status'], 'username' => $data['username']), "login_id = :login_id",array('login_id'=>$data['login_id']));

            $this->db->delete($data['prev_user_type'], "user_id = :user_id",array('user_id'=>$data['user_id']));
        }
    }

    function checkExists($username) {
        $user = $this->db->selectOneWhere('login', array('username'),  'username=:username',array('username'=>$username));

        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    function checkExistsWhere($username, $loginId) {
        $user = $this->db->selectOneWhere('login', array('username'), "username=:username AND login_id<>:loginId" ,array('username'=>$username,'loginId'=>$loginId));

        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    function delete($userId, $userType) {
        $data = $this->db->selectOneWhere($userType, array('login_id'),  "user_id = :userId",array('userId'=>$userId));

        if ($userType == 'owner') {
            return false;
        } else {
            $this->db->update('login', array('user_status' => 'blocked'), "login_id = :login_id",array('login_id'=>$data['login_id']));
            $this->db->update($userType, array('is_deleted' => 'yes'), "user_id = :userId",array('userId'=>$userId));
        }
    }

    function userCount($status) {
        return $this->db->selectOneWhere('login', array('COUNT(login_id)'), "user_status=:status",array('status'=>$status))['COUNT(login_id)'];
    }
}
