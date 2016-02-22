<?php

class Controller_Users extends Controller_Base {

    public static $login_redirect = '';

    public function action_login() {
        $data = array();
        if (Auth::check()) {
            Session::set_flash('error', "You are already Logged in");
            $this->_getDashboard();
        }
        $auth = Auth::instance();
        $view = View::forge('users/login', $data);
        if (Input::post()) {
            $redirect = (Input::post('redirect', false)) ? Input::post('redirect') : self::$login_redirect;
            if ($auth->login(Input::post('email'), Input::post('password'))) {
                $this->set_user();
                Session::set_flash('success', 'Successfully logged in! Welcome ' . $auth->get_screen_name());
                //Response::redirect('users/dashboard');
                $this->_getDashboard();
            } else {
                Session::set_flash('error', 'Username or password incorrect.');
            }
        }
        $this->template->title = 'User &raquo; Login';
        $this->template->content = $view;
    }

    public function action_logout() {
        $auth = Auth::instance();
        $auth->logout();
        Session::set_flash('success', 'Logged out.');
        Response::redirect('/');
    }

    public function action_register() {
        $data["subnav"] = array('register' => 'active');
        $this->template->title = 'Users &raquo; Register';
        $this->template->content = View::forge('users/register', $data);
    }

    public static function get_register($fieldset = null, $errors = null) {
        $data["subnav"] = array('register' => 'active');
        $auth = Auth::instance();
        $view = View::forge('users/register', $data);

        if (empty($fieldset)) {
            $fieldset = Fieldset::forge('register');
            Model_User::populate_register_fieldset($fieldset);
        }

        $view->set('reg', $fieldset->build(), false);
        if ($errors)
            $view->set_safe('errors', $errors);
        $this->template->title = 'Users &raquo; Register';
        $this->template->content = $view;
    }

    public function post_register() {

        $fieldset = Model_User::populate_register_fieldset(Fieldset::forge('register'));
        $fieldset->repopulate();
        $result = Model_User::validate_registration($fieldset, Auth::instance());
        if ($result['e_found']) {
            return $this->get_register($fieldset, $result['errors']);
        }

        Session::set_flash('success', 'User created.');
        Response::redirect('./');
    }

    public function action_dashboard() {
        echo "I am Logged in";
        $this->template->content = '';
    }

    protected function _getDashboard() {
        $groupid = $this->current_user->group;
        $groupName = Config::get('simpleauth.group_link.' . $groupid . '.name');
        Response::redirect($groupName . '/dashboard');
    }

}
