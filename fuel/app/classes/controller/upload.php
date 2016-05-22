<?php

class Controller_Pages extends Controller_Base {

    public function before() {
        parent::before();
    }

    public function action_upload() {
        
    }

    public function action_upload_pic() {
        if (Input::get('object_id')) {
            $user = Model_User::find(Input::get('object_id'));
        } else {
            $user = $this->current_user;
        }
        $output = $user->uploadProfileLogo();
        $data['response'] = json_encode($output);
        return Response::forge(View::forge('response', $data, false));
    }

    public function action_remove_pic() {
        $img_name = Input::post('logo');
        $uid = Input::post('user_id');
        if ($uid) {
            if ($img_name) {
                $model = new Model_User();
                $output = $model->removeProfileLogo($img_name, $uid);
            }
            $user = Model_User::find($uid);
            if ($user) {
                $user->profile_pic = NULL;
                $user->save();
                $xx["msg"] = "photo_deleted_successfully";
                $xx["status"] = "success";
            } else {
                $xx["msg"] = "Delete Fail";
                $xx["status"] = "fail";
            }
            $data['response'] = json_encode($xx);
        } else {
            $xx["msg"] = "photo_deleted_successfully";
            $xx["status"] = "success";
            $data['response'] = json_encode($xx);
        }
        return Response::forge(View::forge('response', $data, false));
    }

}
