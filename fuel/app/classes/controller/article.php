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
            $data['data'] = $article->detail;
            $data['article'] = $article;
            $data['form_id'] = "form_edit_info";
            $data['form_title'] = "Edit Information";
            $data['form_action'] = Uri::create('article/edit_info/' . $article->id . "/save");
            $data['fields'] = Model_Article_Detail::getFields();
            $view = View::forge('article/edit_info', $data, false);
        }
        $this->template = $view;
    }

    public function action_edit_date($article_id = null, $date_id = null, $save = null) {
        $date = Model_Date::find($date_id);
        if ($save) {
            if (Input::method() == "POST") {
                $postData = Input::post();

                #validation
                $val = Model_Date::validate('Date');
                #validation
                if ($val->run()) {

                    foreach ($postData as $key => $p) {
                        if ($key == 'date') {
                            $date->$key = strtotime($p);
                        } else {
                            $date->$key = $p;
                        }
                    }
                    if ($date->save()) {
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
                    $data1['validation_fields'] = array('title', 'date', 'summary', 'date_keywords');
                    $data1['title'] = isset($errors['title']) ? $errors['title']->get_message() : null;
                    $data1['date'] = isset($errors['date']) ? $errors['date']->get_message() : null;
                    $data1['summary'] = isset($errors['summary']) ? $errors['summary']->get_message() : null;
                    $data1['date_keywords'] = isset($errors['date_keywords']) ? $errors['date_keywords']->get_message() : null;
                }
            }
            $data2['response'] = json_encode($data1);
            $view = View::forge('admin/response', $data2, false);
        } else {
            $data['data'] = $date;
            $data['article_id'] = $article_id;
            $data['form_title'] = "Edit Date";
            $data['form_id'] = "form_edit_info";
            $data['form_action'] = Uri::create('article/edit_date/' . $article_id . "/" . $date_id . "/save");
            $data['fields'] = Model_Date::getFields();
            $view = View::forge('article/edit_date', $data, false);
        }
        $this->template = $view;
    }

    public function action_create_date($article_id = null, $save = null) {
        $article = Model_Article::find($article_id);
        if ($save) {
            if (Input::method() == "POST") {
                $postData = Input::post();
                #validation
                $val = Model_Date::validate('Date');
                #validation
                if ($val->run()) {
                    $dateModel = Model_Date::forge();
                    $dateModel->article_id = $article_id;
                    foreach ($postData as $key => $p) {
                        if ($key == 'date') {
                            $dateModel->$key = strtotime($p);
                        } else {
                            $dateModel->$key = $p;
                        }
                    }
                    if ($dateModel->save()) {
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
                    $data1['validation_fields'] = array('title', 'date', 'summary', 'date_keywords');
                    $data1['title'] = isset($errors['title']) ? $errors['title']->get_message() : null;
                    $data1['date'] = isset($errors['date']) ? $errors['date']->get_message() : null;
                    $data1['summary'] = isset($errors['summary']) ? $errors['summary']->get_message() : null;
                    $data1['date_keywords'] = isset($errors['date_keywords']) ? $errors['date_keywords']->get_message() : null;
                }
            }
            $data2['response'] = json_encode($data1);
            $view = View::forge('admin/response', $data2, false);
        } else {
            $data['data'] = null;
            $data['form_title'] = "Add New  Date";
            $data['form_id'] = "form_add_date";
            $data['form_action'] = Uri::create('article/create_date/' . $article_id . "/save");
            $data['fields'] = Model_Date::getFields();
            $view = View::forge('article/edit_date', $data, false);
        }
        $this->template = $view;
    }

    public function action_edit_article($article_id = null, $save = null) {
        $article = Model_Article::find($article_id);

        if ($save) {
            if (Input::method() == "POST") {
                $postData = Input::post();

                #validation
                $val = Model_Article::validateEdit('article');
                #validation
                if ($val->run()) {

                    foreach ($postData as $key => $p) {
                        $article->$key = $p;
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
                    $data1['validation_fields'] = array('description');
                    $data1['description'] = isset($errors['description']) ? $errors['description']->get_message() : null;
                }
            }
            $data2['response'] = json_encode($data1);
            $view = View::forge('admin/response', $data2, false);
        } else {
            $data['data'] = $article;
            $data['article'] = $article;
            $data['form_id'] = "form_edit_article";
            $data['form_title'] = "Edit Article";
            $data['form_action'] = Uri::create('article/edit_article/' . $article->id . "/save");
            $data['fields'] = Model_Article::getFields();
            $view = View::forge('article/edit_article', $data, false);
        }
        $this->template = $view;
    }

}
