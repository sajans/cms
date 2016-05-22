<?php

class Model_Upload extends \Orm\Model {

    protected static $_properties = array(
        'id',
        'user_id',
        'type_id',
        'name',
        'original_name',
        'path',
        'size',
        'created_at',
        'updated_at',
    );
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
    protected static $_table_name = 'uploads';
    protected static $_many_many = array(
        'articles' => array(
            'key_from' => 'id',
            'key_through_from' => ' upload_id',
            'table_through' => 'upload_articles',
            'key_through_to' => 'article_id',
            'model_to' => 'Model_Article',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );

    public function uploadProfileLogo() {
        $user_id = Input::get('object_id');
        $type = Input::get('object_type');
        $uploader = new Utils_Uploader(array('jpeg', 'jpg', 'png'));
        $path = DOCROOT . 'assets/uploads/users/' . $this->id . DS;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $pic_name = 'profile_logo_' . time();
        $original = $path . $pic_name;
        $output = $uploader->handleUploadRename($path, $pic_name);
        if (isset($output['success'])) {
            $this->profile_pic = $output['full_filename'];
            $this->save();

            $uploadAll = Model_Uploadall::forge();
            $uploadAll->user_id = $this->id;
            $uploadAll->type = $type;
            $uploadAll->name = $output['full_filename'];
            $uploadAll->save();

            $original = $path . $output['full_filename'];
            Image::load($original)->preset('defaultlogo')->save($original);
            if (\Config::get('live')) {
                $localFileName = $path . $output['full_filename'];
                $remoteFileName = DOCROOT . 'assets/uploads/users/' . $this->id . DS . $output['full_filename'];
                Model_Rackspace::uploadObject($localFileName, $remoteFileName);
                File::delete(DOCROOT . 'assets/uploads/users/' . $user_id . DS . $output['full_filename']);
            }
            $output['uri'] = Uri::create('users/get_logo/' . $output['full_filename'] . '/' . $user_id);
        }
        return $output;
    }

    public function removeProfileLogo($img_name, $u_id) {
        Model_Rackspace::deleteObject('assets/uploads/users/' . $u_id . DS . $img_name);
    }

}
