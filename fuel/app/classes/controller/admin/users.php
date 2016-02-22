<?php

class Controller_Admin_Users extends Controller_Admin {

    public function action_create() {
        $groupList = Config::get("simpleauth.group_list");
        $data['grouplist'] = $groupList;
        if (Input::method() == 'POST') {
           $val = Model_User::validate('create');
            if ($val->run()) {
                
                
            } 
        }
        $this->template->title = "Create Users";
        $this->template->content = View::forge('admin/users/create', $data, false);
    }

}
