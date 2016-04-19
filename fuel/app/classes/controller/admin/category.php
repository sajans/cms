<?php

class Controller_Admin_Category extends Controller_Admin {

    protected $_paginationConfig = "";

    public function before() {
        //parent::before();
        $this->_paginationConfig = array(
            'prev_img' => Asset::img('pagination/prev.png', array("alt" => "Previous", 'class' => "prev-img")),
            'prev_img_active' => Asset::img('pagination/prev.png', array("alt" => "Previous", 'class' => "prev-img-active")),
            'first_img' => Asset::img('pagination/first.png', array("alt" => "first", 'class' => "first-img")),
            'first_img_active' => Asset::img('pagination/first.png', array("alt" => "first", 'class' => "first-img-active")),
            'next_img' => Asset::img('pagination/next.png', array("alt" => "Next", 'class' => "next-img")),
            'next_img_active' => Asset::img('pagination/next.png', array("alt" => "Next", 'class' => "next-img-active")),
            'last_img' => Asset::img('pagination/last.png', array("alt" => "Last", 'class' => "last-img")),
            'last_img_active' => Asset::img('pagination/last.png', array("alt" => "Last", 'class' => "last-img-active")),
            'css_id_prefix' => 'Category',
            'ajax_method' => 'loadCategoryGrid',
            'limit_default' => 30,
            'limiter_choices' => array(30, 60, 100),
            'limiter_prefix' => 'Category',
        );

        parent::before();
    }

    public function action_index() {
        $data = array();
        $this->template->title = "Categories";
        $this->template->content = View::forge('admin/category/index', $data);
    }

    public function action_grid() {

        $name = Input::post('name');
        if (empty($name)) {
            $name = "%%";
        } else {
            $name = "%" . $name . "%";
        }
        $limit = (int) Input::post('limit');
        $page = (int) Input::post('page');
        $limit = isset($limit) ? $limit : $this->_paginationConfig['limit_default'];
        $page = isset($page) ? $page : 1;
        $result = DB::select(DB::expr('COUNT(id) as total'))->from('categories')
                        ->where('name', 'like', $name)
                        ->execute()->as_array();
        $total = $result[0]['total'];
        $pagination = Model_Paginator::getPaginationData($page, $limit, $total, $this->_paginationConfig);
        $data['pagination'] = $pagination;
        $data['categories'] = DB::select()->from('categories')
                ->where('name', 'like', $name)
                ->order_by("created_at", "desc")
                ->limit($pagination->limit)
                ->offset($pagination->offset)
                ->as_object()
                ->execute();
        $this->template = View::forge('admin/category/grid', $data, false);
    }

    public function action_create() {
        if (Input::method() == 'POST') {
            $val = Model_Category::validate('create');

            if ($val->run()) {
                $category = Model_Category::forge(array(
                            'name' => Input::post('name'),
                            'keywords' => Input::post('keywords'),
                            'meta' => Input::post('meta'),
                ));

                if ($category and $category->save()) {
                    Session::set_flash('success', 'Added category #' . $category->id . '.');

                    Response::redirect('category');
                } else {
                    Session::set_flash('error', 'Could not save category.');
                }
            } else {
                Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = "Categories";
        $this->template->content = View::forge('admin/category/create');
    }

    public function action_edit($id = null) {
        is_null($id) and Response::redirect('category');

        if (!$category = Model_Category::find($id)) {
            Session::set_flash('error', 'Could not find category #' . $id);
            Response::redirect('category');
        }

        $val = Model_Category::validate('edit');

        if ($val->run()) {
            $category->name = Input::post('name');
            $category->keywords = Input::post('keywords');
            $category->meta = Input::post('meta');

            if ($category->save()) {
                Session::set_flash('success', 'Updated category #' . $id);

                Response::redirect('admin/category');
            } else {
                Session::set_flash('error', 'Could not update category #' . $id);
            }
        } else {
            if (Input::method() == 'POST') {
                $category->name = $val->validated('name');
                $category->keywords = $val->validated('keywords');
                $category->meta = $val->validated('meta');

                Session::set_flash('error', $val->error());
            }

            $this->template->set_global('category', $category, false);
        }

        $this->template->title = "Categories";
        $this->template->content = View::forge('admin/category/create');
    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('category');

        if ($category = Model_Category::find($id)) {
            $category->delete();

            Session::set_flash('success', 'Deleted category #' . $id);
        } else {
            Session::set_flash('error', 'Could not delete category #' . $id);
        }

        Response::redirect('category');
    }

}
