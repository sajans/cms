<?php

class Controller_Article extends Controller_Base {

    public function before() {
        parent::before();
    }

    public function action_index($id=null) {

        $article = Model_Article::find_by_url_title($id);
        if ($article) {
            $view = Presenter::forge('article/view');
            $view->set('article', $article);
            $this->template->set('content', $view);
        } else {
            return Response::forge(Presenter::forge('welcome/404'), 404);
        }
    }

}
