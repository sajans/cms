<?php

use Orm\Model;

class Model_Article extends Model {

    const JOINTYPE_UPLOAD = 1;

    protected static $_properties = array(
        'id',
        'category_id',
        'user_id',
        'editor_id',
        'name',
        'url_title',
        'description',
        'keywords',
        'status' => array(
            'default' => 'A',
        ),
        'deleted' => array(
            'default' => 0,
        ),
        'completion' => array(
            'default' => 'NC',
        ),
        'created_at',
        'updated_at',
    );
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => false,
        ),
    );
    protected static $_has_one = array(
        'detail' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Article_Detail',
            'key_to' => 'article_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
    );
    protected static $_has_many = array(
        'dates' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Date',
            'key_to' => 'article_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
        'uploads' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Upload',
            'key_to' => 'join_id',
            'cascade_save' => true,
            'cascade_delete' => true,
            'conditions' => array(
                'where' => array(
                    array('join_type', '=', self::JOINTYPE_UPLOAD),
                ),
            ),
        ),
    );

    public static function validate($factory) {
        $val = Validation::forge($factory);
        $val->add_field('category_id', 'Category Id', 'required|valid_string[numeric]');
        $val->add_field('name', 'Name', 'required|max_length[255]');
        //$val->add_field('description', 'Description', 'required');
        //$val->add_field('keywords', 'Keywords', 'required');
        //$val->add_field('image', 'Image', 'required|max_length[255]');

        return $val;
    }

    public static function validateEdit($factory) {
        $val = Validation::forge($factory);
        //$val->add_field('name', 'Name', 'required|max_length[255]');
        $val->add_field('description', 'Description', 'required');
        //$val->add_field('keywords', 'Keywords', 'required');
        //$val->add_field('image', 'Image', 'required|max_length[255]');

        return $val;
    }

    public static function getFields() {
        $result = array();
        $sep = " ";
        $ignore = array('id', 'category_id', 'user_id', 'editor_id', 'name', 'keywords', 'url_title', 'status', 'deleted', 'completion', 'created_at', 'updated_at');
        foreach (self::$_properties as $key => $property) {
            $labelArray = array();
            if (is_array($property)) {
                if (!in_array($key, $ignore)) {
                    $labelArray = explode("_", $key);
                }
            } else {
                if (!in_array($property, $ignore)) {
                    $labelArray = explode("_", $property);
                }
            }
            $label = "";
            $countlabelArray = count($labelArray);
            if ($countlabelArray >= 1) {
                for ($i = 0; $i < $countlabelArray; $i++) {
                    if ($i != 0) {
                        $label .=$sep;
                    }
                    $label .= ucfirst($labelArray[$i]);
                }
                $result[$property] = $label;
            }
        }
        return $result;
    }

    public function getDetail() {

        if ($this->detail === null) {
            $this->detail = new Model_Article_Detail();
            $this->save();
        }
        return $this->detail;
    }

    public function getUploads($type = null, $limit = null) {
        $uploadAll = $this->uploads;
        if ($type) {
            if (count($this->uploads) >= 1) {
                foreach ($this->uploads as $key => $upload) {
                    $k = $key;
                    if ($upload->type_id != $type) {
                        unset($uploadAll[$key]);
                    }
                }
            }
        }
        if ($limit) {
            if (count($uploadAll) >= 1) {
                $uploads = $uploadAll[$k];
            } else {
                $uploads = null;
            }
        }
        //echo "<pre>"; var_dump($uploads); exit;
        return $uploads;
    }

    public static function uploadPicture() {
        $join_id = Input::get('object_id');
        $type = Input::get('object_type');
        $user_id = Input::get('user_id');
        $join_type = self::JOINTYPE_UPLOAD;
        $uploader = new Utils_Uploader(array('jpeg', 'jpg', 'png'));
        $path = DOCROOT . 'assets/uploads' . DS;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $uploadTypeModel = Model_Upload_Type::find($type);
        $typeName = $uploadTypeModel->types;
        $pic_name = $typeName . "_" . time();
        $original = $path . $pic_name;
        $output = $uploader->handleUploadRename($path, $pic_name);
        if (isset($output['success'])) {
            $original = $path . $output['full_filename'];
            $uploadAll = Model_Upload::forge();
            $uploadAll->user_id = $user_id;
            $uploadAll->type_id = $type;
            $uploadAll->join_id = $join_id;
            $uploadAll->join_type = $join_type;
            $uploadAll->name = $output['full_filename'];
            $uploadAll->original_name = $output['full_filename'];
            $uploadAll->path = $original;
            $uploadAll->save();
            $output['upload_id'] = $uploadAll->id;
            if ($uploadTypeModel->crop == 0) { #If not set crop then preset other preset after crop
                Image::load($original)->preset($typeName)->save($original);
            }
            $localFileName = $path . $output['full_filename'];
            $remoteFileName = DOCROOT . 'assets/uploads/' . DS . $output['full_filename'];
            $output['uri'] = Uri::create('upload/get_image/' . $output['full_filename'] . '/' . $output['upload_id']);
        }
        return $output;
    }

}
