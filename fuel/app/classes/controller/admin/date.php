<?php

class Controller_Admin_Date extends Controller_Admin {

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
            'css_id_prefix' => 'Dates',
            'ajax_method' => 'loadDatesGrid',
            'limit_default' => 30,
            'limiter_choices' => array(30, 60, 100),
            'limiter_prefix' => 'Dates',
        );

        parent::before();
    }

    public function action_index() {
        $data = array();
        $this->template->title = "Dates";
        $this->template->content = View::forge('admin/date/index', $data);
    }

    public function action_grid() {
        $title = Input::post('title');
        if (empty($title)) {
            $title = "%%";
        } else {
            $title = "%" . $title . "%";
        }
        $summary = Input::post('summary');
        if (empty($summary)) {
            $summary = "%%";
        } else {
            $summary = "%" . $summary . "%";
        }
        $date = Input::post('date');
        if (empty($date)) {
            $date = "%%";
        } else {
            $date = "%" . $date . "%";
        }

        $limit = (int) Input::post('limit');
        $page = (int) Input::post('page');
        $limit = isset($limit) ? $limit : $this->_paginationConfig['limit_default'];
        $page = isset($page) ? $page : 1;
        $result = DB::select(DB::expr('COUNT(id) as total'))->from('dates')
                        ->where('title', 'like', $title)
                        ->where('summary', 'like', $summary)
                        ->execute()->as_array();
        $total = $result[0]['total'];
        $pagination = Model_Paginator::getPaginationData($page, $limit, $total, $this->_paginationConfig);
        $data['pagination'] = $pagination;
        $data['dates'] = DB::select()->from('dates')
                ->where('title', 'like', $title)
                ->where('summary', 'like', $summary)
                ->order_by("created_at", "desc")
                ->limit($pagination->limit)
                ->offset($pagination->offset)
                ->as_object()
                ->execute();
        $this->template = View::forge('admin/date/grid', $data, false);
    }

    public function action_create() {
        if (Input::method() == 'POST') {
            $val = Model_Date::validate('create');
            //var_dump(Input::post(),strtotime(Input::post('date')));
            //exit;
            if ($val->run()) {
                $date = Model_Date::forge(array(
                            'title' => Input::post('title'),
                            'summary' => Input::post('summary'),
                            'date' => strtotime(Input::post('date')),
                            'date_keywords' => Input::post('date_keywords'),
                ));

                if ($date and $date->save()) {
                    Session::set_flash('success', 'Added date #' . $date->id . '.');

                    Response::redirect('admin/date');
                } else {
                    Session::set_flash('error', 'Could not save date.');
                }
            } else {
                Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = "Dates";
        $this->template->content = View::forge('admin/date/create');
    }

    public function action_edit($id = null) {
        is_null($id) and Response::redirect('date');

        if (!$date = Model_Date::find($id)) {
            Session::set_flash('error', 'Could not find Date' . $id);
            Response::redirect('date');
        }

        $val = Model_Date::validate('date');

        if ($val->run()) {
            $date->title = Input::post('title');
            $date->summary = Input::post('summary');
            $date->date = strtotime(Input::post('date'));
            $date->date_keywords = Input::post('date_keywords');

            if ($date->save()) {
                Session::set_flash('success', 'Updated Dates #' . $id);

                Response::redirect('admin/date');
            } else {
                Session::set_flash('error', 'Could not update date #' . $id);
            }
        } else {
            if (Input::method() == 'POST') {
                $date->title = Input::post('title');
                $date->summary = Input::post('summary');
                $date->date = Input::post('date');
                $date->date_keywords = Input::post('date_keywords');

                Session::set_flash('error', $val->error());
            }

            $this->template->set_global('date', $date, false);
        }

        $this->template->title = "Dates";
        $this->template->content = View::forge('admin/date/create');
    }

    public function action_delete($id = null, $save = null) {

        if ($save) {
            if ($category = Model_Date::find($id)) {
                $category->delete();
                $data['status'] = "success";
                $data['msg'] = "successfully Deleted Date";
            } else {
                $data['status'] = "fales";
                $data['msg'] = "Date not found";
            }
            $data1['response'] = json_encode($data);
            $view = View::forge('admin/response', $data1, false);
        } else {
            $view = View::forge('admin/modal/delete', array('control' => 'date', 'ajaxload' => 'loadDateGrid', 'url' => Uri::create("admin/date/delete/" . $id . '/save')), false);
        }
        $this->template = $view;
    }

}
