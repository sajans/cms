<?php

class Controller_Admin_Article extends Controller_Admin {

    protected $_paginationConfig = "";

    public function before() {
        $this->_paginationConfig = array(
            'prev_img' => Asset::img('pagination/prev.png', array("alt" => "Previous", 'class' => "prev-img")),
            'prev_img_active' => Asset::img('pagination/prev.png', array("alt" => "Previous", 'class' => "prev-img-active")),
            'first_img' => Asset::img('pagination/first.png', array("alt" => "first", 'class' => "first-img")),
            'first_img_active' => Asset::img('pagination/first.png', array("alt" => "first", 'class' => "first-img-active")),
            'next_img' => Asset::img('pagination/next.png', array("alt" => "Next", 'class' => "next-img")),
            'next_img_active' => Asset::img('pagination/next.png', array("alt" => "Next", 'class' => "next-img-active")),
            'last_img' => Asset::img('pagination/last.png', array("alt" => "Last", 'class' => "last-img")),
            'last_img_active' => Asset::img('pagination/last.png', array("alt" => "Last", 'class' => "last-img-active")),
            'css_id_prefix' => 'Articles',
            'ajax_method' => 'loadArticleGrid',
            'limit_default' => 30,
            'limiter_choices' => array(30, 60, 100),
            'limiter_prefix' => 'Article',
        );

        parent::before();
    }

    public function action_index() {
        $data['categories'] = Model_Category::getSelectList();
        $data['writters'] = Model_User::getwritterList();
        $this->template->title = "Articles";
        $this->template->content = View::forge('admin/article/index', $data);
    }

    public function action_grid() {

        $name = Input::post('name');
        if (empty($name)) {
            $name = "%%";
        } else {
            $name = "%" . $name . "%";
        }
        $category = Input::post('category');
        if (empty($category)) {
            $operator = "!=";
            $category = "";
        } else {
            $operator = "=";
            $category = $category;
        }

        $writter = Input::post('writter');
        if (empty($writter)) {
            $writterOperator = "!=";
            $writter = "";
        } else {
            $writterOperator = "=";
            $writter = $writter;
        }
        $status = Input::post('status');
        if (empty($status)) {
            $statusOperator = "!=";
            $status = "";
        } else {
            $statusOperator = "=";
            $status = $status;
        }

        $deleted = Input::post('deleted');
        if (empty($deleted)) {
            $deletedOperator = "=";
            $deleted = 0;
        } else {
            $deletedOperator = "=";
            $deleted = $deleted;
        }
        $completion = Input::post('completion');
        if (empty($completion)) {
            $completionOperator = "!=";
            $completion = "";
        } else {
            $completionOperator = "=";
            $completion = $completion;
        }


        $limit = (int) Input::post('limit');
        $page = (int) Input::post('page');
        $limit = isset($limit) ? $limit : $this->_paginationConfig['limit_default'];
        $page = isset($page) ? $page : 1;
        $result = DB::select(DB::expr('COUNT(id) as total'))->from('articles')
                        ->where('name', 'like', $name)
                        ->where('category_id', $operator, $category)
                        ->where('user_id', $writterOperator, $writter)
                        ->where('status', $statusOperator, $status)
                        ->where('deleted', $deletedOperator, $deleted)
                        ->where('completion', $completionOperator, $completion)
                        ->execute()->as_array();
        $total = $result[0]['total'];
        $pagination = Model_Paginator::getPaginationData($page, $limit, $total, $this->_paginationConfig);
        $data['pagination'] = $pagination;
        $data['articles'] = DB::select()->from('articles')
                ->where('name', 'like', $name)
                ->where('category_id', $operator, $category)
                ->where('user_id', $writterOperator, $writter)
                ->where('status', $statusOperator, $status)
                ->where('deleted', $deletedOperator, $deleted)
                ->where('completion', $completionOperator, $completion)
                ->order_by("created_at", "desc")
                ->limit($pagination->limit)
                ->offset($pagination->offset)
                ->as_object()
                ->execute();
        //echo DB::last_query(); 
        $this->template = View::forge('admin/article/grid', $data, false);
    }

    public function action_view($id = null) {
        is_null($id) and Response::redirect('article');

        if (!$data['article'] = Model_Article::find($id)) {
            Session::set_flash('error', 'Could not find article #' . $id);
            Response::redirect('article');
        }

        $this->template->title = "Article";
        $this->template->content = View::forge('admin/article/view', $data);
    }

    public function action_create() {
        if (Input::method() == 'POST') {
            $val = Model_Article::validate('create');

            if ($val->run()) {
                $article = Model_Article::forge(array(
                            'category_id' => Input::post('category_id'),
                            'user_id' => $this->current_user->id,
                            'name' => Input::post('name'),
                            'url_title' => str_replace(" ", "-", strtolower(Input::post('name'))),
                            'description' => Input::post('description'),
                            'keywords' => Input::post('keywords'),
                            'image' => Input::post('image'),
                ));

                if ($article and $article->save()) {
                    Session::set_flash('success', 'Added article #' . $article->id . '.');

                    Response::redirect('admin/article');
                } else {
                    Session::set_flash('error', 'Could not save article.');
                }
            } else {
                Session::set_flash('error', $val->error());
            }
        }
        $data['categories'] = Model_Category::getSelectList();
        $this->template->title = "Articles";
        $this->template->content = View::forge('admin/article/create', $data);
    }

    public function action_edit($id = null) {
        is_null($id) and Response::redirect('article');

        if (!$article = Model_Article::find($id)) {
            Session::set_flash('error', 'Could not find article #' . $id);
            Response::redirect('article');
        }

        $val = Model_Article::validate('edit');

        if ($val->run()) {
            $article->category_id = Input::post('category_id');
            $article->name = Input::post('name');
            $article->url_title = str_replace(" ", "-", strtolower(Input::post('name')));
            $article->description = Input::post('description');
            $article->keywords = Input::post('keywords');
            $article->image = Input::post('image');
            $article->editor_id = $this->current_user->id;
            if ($article->save()) {
                Session::set_flash('success', 'Updated article #' . $id);

                Response::redirect('admin/article');
            } else {
                Session::set_flash('error', 'Could not update article #' . $id);
            }
        } else {
            if (Input::method() == 'POST') {
                $article->category_id = $val->validated('category_id');
                $article->name = $val->validated('name');
                $article->description = $val->validated('description');
                $article->keywords = $val->validated('keywords');
                $article->image = $val->validated('image');

                Session::set_flash('error', $val->error());
            }

            $this->template->set_global('article', $article, false);
        }

        $this->template->title = "Articles";
        $data['categories'] = Model_Category::getSelectList();
        $this->template->content = View::forge('admin/article/create', $data);
    }

    public function action_delete($id = null, $save = null) {

        if ($save) {
            if ($article = Model_Category::find($id)) {
                $article->deleted = 1;
                $article->save();
                $data['status'] = "success";
                $data['msg'] = "successfully Deleted Article";
            } else {
                $data['status'] = "fales";
                $data['msg'] = "Articles not found";
            }
            $data1['response'] = json_encode($data);
            $view = View::forge('admin/response', $data1, false);
        } else {
            $view = View::forge('admin/modal/delete', array('control' => 'article', 'ajaxload' => 'loadArticleGrid', 'url' => Uri::create("admin/article/delete/" . $id . '/save')), false);
        }
        $this->template = $view;
    }

    public function action_make_active($id = null) {
        if ($article = Model_Category::find($id)) {
            $article->deleted = 0;
            $article->save();
            $data['status'] = "success";
            $data['msg'] = "successfully Active Article";
        } else {
            $data['status'] = "fales";
            $data['msg'] = "Articles not found";
        }
        $data1['response'] = json_encode($data);
        $view = View::forge('admin/response', $data1, false);

        $this->template = $view;
    }

}
