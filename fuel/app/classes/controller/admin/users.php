<?php

class Controller_Admin_Users extends Controller_Admin {

    public function action_create() {
        $auth = Auth::instance();
        //echo "<pre>"; var_dump($auth); exit;

        $groupList = Config::get("cmsauth.group_list");
        $data['grouplist'] = $groupList;
        if (Input::method() == 'POST') {
            //echo "<pre>"; var_dump(Input::post()); exit;
            $val = Model_User::validate('create');
            //echo "<pre>"; var_dump($val);  die();
            if ($val->run()) {
                $ignore = array('button', 'submit', 'password','confirm_password', 'email', 'group');
                foreach (Input::Post() as $feild => $value) {
                    if (!in_array($feild, $ignore)) {
                        $fields[$feild] = $value;
                    }
                }
                $username = Input::post('first_name');
                $password = Input::post('password');
                $email = Input::post('email');
                $group = Input::post('group');
                $post_data = Input::post();
                try {
                    $auth = Auth::instance();
                    $user = $auth->create_user($username, $password, $email, $group, $fields, $post_data);
                    Response::redirect("admin");
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    var_dump($error);
                    die();
                }
            } else {
                $data['status'] = "fail";
                $data['msg'] = $val->show_errors();
            }
        }
        $this->template->title = "Create Users";
        $this->template->content = View::forge('admin/users/create', $data, false);
    }

}
