<?php

class Controller_Upload extends Controller_Base {

    public function before() {
        parent::before();
    }

    public function action_get_image($filename = null, $upload_id = null) {
        $data['name'] = $filename;
        $upload = Model_Upload::find($upload_id);
        $path = $upload->path;
        $data['path'] = $path;
        $data['mimi'] = Model_Upload::get_mime_type($filename);

        $defultlogo = 'logo.png';

        $data['path_cms'] = DOCROOT . 'assets/img/' . $defultlogo;
        $data['name_cms'] = $defultlogo;
        $data['mimi_cms'] = 'png';
        $this->template = View::forge('uploads/document', $data, false);
    }

}
