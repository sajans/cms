<?php

class Controller_Pages extends Controller_Base {

    public function before() {
        parent::before();
    }

    public function action_view($type = 'home') {

        //var_dump($type); exit;
        if ($type == 'person') {
            $this->template->title = 'Person';
            $this->template->content = 'Person Page';
        } elseif ($type == 'festival') {
            $this->template->title = 'Festival';
            $this->template->content = 'Festival Page';
        } else {
            $this->template->title = 'Home';
            $this->template->content = View::forge("pages/home");;
        }
        $this->template->navClass ='active';
    }

}
