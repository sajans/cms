<?php

abstract class Controller_Base extends Controller_Template {

    public $_template = 'template';

    public function before() {
        parent::before();
        if (Request::main() === Request::active() || Request::active()->uri->uri == 'welcome/404') {
            $this->check_auth();
            $this->set_user();
            $this->set_theme();
        } else {
            $this->set_user();
        }
    }
 public function after($response)
    {
        return parent::after($response);
    }
    public function check_auth() {
        if (!Auth::has_access(array($this->request->controller, $this->request->action))) {

            if (Auth::check()) {
                $this->set_user();
                Session::set_flash('error', 'Permission Denied.');
                Response::redirect('');
            } else {
                Session::set_flash('error', "Not Logged in.");
                $request_uri = urlencode($this->request->uri->uri);
                if (preg_match('/Controller_Admin/', $this->request->controller)) {
                    Response::redirect('admin/login/?uri=' . $request_uri);
                } else {
                    Response::redirect('users/login');
                }
            }
        } else {
            if (Auth::check()) {
                $this->set_user();
            }
        }
    }

    protected function set_theme() {


        View::bind_global('before', $false);
        View::bind_global('navigation', $false);
        View::bind_global('after_navigation', $false);
        View::bind_global('sidebar', $false);
        View::bind_global('pageheader', $false);
        //echo "<pre>";var_dump(Uri::current()); exit;
        //$theme = Utils_Themer::get_theme(Uri::current());
        $theme = Utils_Themer::get_theme($this->request->uri->uri);
        //var_dump($theme); exit;
        $this->template = view::forge($theme['template']);
        View::bind_global('body_attr', $theme['body_attr']);
        Asset::css($theme['css'], array(), 'head_css');
        foreach ($theme['js'] as $js) {
            Casset\Casset::js($js);
        }
   
        if ($theme['navigation']) {
            $navigation = call_user_func('Utils_Navigation::get_links', $theme['navigation']);
            View::bind_global('navigation', $navigation, false);
        }
      

        if ($theme['pageheader']) {
            View::bind_global('pageheader', $theme['pageheader']);
        }
    }

    public function set_user() {

        $user = NULL;

        if (Session::get('loginAs')) {
            $this->current_user = Model_User::find(Session::get('loginAs'));
            View::set_global('current_user', $this->current_user);
        } else {
            if (Input::method() == 'POST') {
                $id = Arr::get(Auth::get_user_id(), 1);
                $post = Input::Post();
                $notMe = isset($post['notMe']) ? $post['notMe'] : NULL;
                $group = isset($user->group) ? $user->group : null;
                if ($id) {
                    $user = Model_User::find($id);
                }
                if ($this->not_me_check($notMe, $group)) {
                    $user = Model_User::find((int) $post['editAs']);
                }
            }

            $id = Arr::get(Auth::get_user_id(), 1);
            if ($id) {
                $user = Model_User::find($id);
            }
            $this->current_user = Auth::check() ? $user : null;
            View::set_global('current_user', $this->current_user);
        }
    }

    public function not_me_check($notMe, $group) {
        if ($notMe && $group == "100") {
            return true;
        }
        return false;
    }

}
