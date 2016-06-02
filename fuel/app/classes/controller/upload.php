<?php

class Controller_Upload extends Controller_Base {

    public function before() {
        parent::before();
    }

    public function action_get_image($filename = null, $upload_id = null) {
        $data['name'] = $filename;
        $upload = Model_Upload::find($upload_id);
        $path = $upload->path;
        $name = $upload->name;
        $data['path'] = $path.$name;
        $data['mimi'] = Model_Upload::get_mime_type($filename);

        $defultlogo = 'logo.png';

        $data['path_cms'] = DOCROOT . 'assets/img/' . $defultlogo;
        $data['name_cms'] = $defultlogo;
        $data['mimi_cms'] = 'png';
        $this->template = View::forge('uploads/document', $data, false);
    }

    public function action_crop_init() {
        $data['upload_id'] = Input::get('upload_id');
       // $data['article_id'] = Input::get('article_id');
       // $data['type_id'] = Input::get('type_id');
        $data["uploads"] = Model_Upload::find(Input::get('upload_id'));
        $this->template = View::forge('uploads/crop', $data, false);
    }

    public function action_crop_upload() {
        $path = Input::post('imgpath');
        $upload_id = Input::post('upload_id');
        $Model_Upload = new Model_Upload();
        $output = $Model_Upload->cropCoverPhoto($path, $upload_id);
        $data['background_name'] = $output;
        $data['status'] = "success";
        $data['msg'] = "Cropped Successfully";
        $data['response'] = json_encode($data);
        $this->template = View::forge('response', $data, false);
    }

}
