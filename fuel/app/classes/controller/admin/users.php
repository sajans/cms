<?php

class Controller_Admin_Users extends Controller_Admin {

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
            'css_id_prefix' => 'Users',
            'ajax_method' => 'loadUsersGrid',
            'limit_default' => 30,
            'limiter_choices' => array(30, 60, 100),
            'limiter_prefix' => 'Users',
        );

        parent::before();
    }

    public function action_create() {
        $auth = Auth::instance();
        $groupList = Config::get("cmsauth.group_list");
        $data['grouplist'] = $groupList;
        if (Input::method() == 'POST') {
            $val = Model_User::validate('create');
            if ($val->run()) {
                $ignore = array('button', 'submit', 'password', 'confirm_password', 'email', 'group');
                foreach (Input::Post() as $feild => $value) {
                    if (!in_array($feild, $ignore)) {
                        $fields[$feild] = $value;
                    }
                }
                $username = Input::post('first_name');
                $password = Input::post('password');
                $email = Input::post('email');
                $group = Input::post('group');
                $post_data = Input::post();
                try {
                    $auth = Auth::instance();
                    $user = $auth->create_user($username, $password, $email, $group, $fields, $post_data);
                    Response::redirect("admin");
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    var_dump($error);
                    die();
                }
            } else {
                $data['status'] = "fail";
                $data['msg'] = $val->show_errors();
            }
        }
        $this->template->title = "Create Users";
        $this->template->content = View::forge('admin/users/create', $data, false);
    }

    public function action_index() {
        $this->template->title = "Users";
        $data = array();
        $this->template->content = View::forge('admin/users/index', $data, false);
    }

    public function action_grid() {

        $userName = Input::post('username');
        if (empty($userName)) {
            $userName = "%%";
        } else {
            $userName = "%" . $userName . "%";
        }


        $email = Input::post('email');
        if (empty($email)) {
            $email = "%%";
        } else {
            $email = "%" . $email . "%";
        }
        $limit = (int) Input::post('limit');
        $page = (int) Input::post('page');
        $limit = isset($limit) ? $limit : $this->_paginationConfig['limit_default'];
        $page = isset($page) ? $page : 1;
        $result = DB::select(DB::expr('COUNT(id) as total'))->from('users')
                        ->where('username', 'like', $userName)
                        ->where('email', 'like', $email)
                        //->and_where_open()
                        // ->where('value', 'like', $label)
                        // ->where('labelid', 'like', $labelId)
                        // ->where('site_id', '=', 'UKAIN')
                        //->or_where($feildName, 'like', $label)
                        //->and_where_close()
                        ->execute()->as_array();
        $total = $result[0]['total'];
        $pagination = Model_Paginator::getPaginationData($page, $limit, $total, $this->_paginationConfig);
        $data['pagination'] = $pagination;
        $data['users'] = DB::select()->from('users')
                  ->where('username', 'like', $userName)
                        ->where('email', 'like', $email)
                //  ->where('page', 'like', $label_page)
                //->and_where_open()
                // ->where('value', 'like', $label)
                // ->where('labelid', 'like', $labelId)
                // ->where('site_id', '=', 'UKAIN')
                //->or_where($feildName, 'like', $label)
                //->and_where_close()
                ->order_by("created_at", "desc")
                ->limit($pagination->limit)
                ->offset($pagination->offset)
                ->as_object()
                ->execute();
        $this->template = View::forge('admin/users/grid', $data, false);
    }

}
