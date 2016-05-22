<?php

class Controller_Article extends Controller_Base {

    public function before() {
        parent::before();
    }

    public function action_view($id = null) {


        $article = Model_Article::find_by_url_title($id);
        if ($article) {
            $view = Presenter::forge('article/view');
            $view->set('article', $article);
            $this->template->set('content', $view);
        } else {
            return Response::forge(Presenter::forge('welcome/404'), 404);
        }
    }

    public function action_edit_info($article_id = null, $save = null) {
        $article = Model_Article::find($article_id);

        if ($save) {
            if (Input::method() == "POST") {
                $postData = Input::post();

                #validation
                $val = Validation::forge();
                $val->add('mother_tongue', 'Mother Tounge')
                        ->add_rule('required');
                #validation
                if ($val->run()) {

                    foreach ($postData as $key => $p) {
                        $article->detail->$key = $p;
                    }
                    if ($article->save()) {
                        $data1['status'] = "success";
                        $data1['refresh'] = 'true';
                        $data1['msg'] = "Updated Successfully";
                    } else {
                        $data1['status'] = "false";
                        $data1['msg'] = "Cannot Update";
                    }
                } else {
                    $errors = $val->error();
                    $data1['status'] = 'false';
                    $data1['validation'] = 'true';
                    $data1['validation_fields'] = array('mother_tongue');
                    $data1['mother_tongue'] = isset($errors['mother_tongue']) ? $errors['mother_tongue']->get_message() : null;
                }
            }
            $data2['response'] = json_encode($data1);
            $view = View::forge('admin/response', $data2, false);
        } else {
            $data['article'] = $article;
            $data['form_id'] = "form_edit_info";
            $data['form_action'] = Uri::create('article/edit_info/' . $article->id . "/save");
            $data['fields'] = Model_Article_Detail::getFields();
            $view = View::forge('article/edit_info', $data, false);
        }
        $this->template = $view;
    }

}
