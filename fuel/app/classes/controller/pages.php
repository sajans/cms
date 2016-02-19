<?php

class Controller_Pages extends Controller_Base {

    public function before() {
        parent::before();
    }

    public function action_view($type = 'home') {

        //var_dump($type); exit;
        if ($type == 'news') {
            $this->template->title = 'news';
            $this->template->content = 'news Page';
        } elseif ($type == 'fashion') {
            $this->template->title = 'fashion';
            $this->template->content = 'Fashion Page';
        } else {
            $this->template->title = 'Home';
            $this->template->content = 'Home Page';
        }
        $this->template->navClass ='active';
    }

}
