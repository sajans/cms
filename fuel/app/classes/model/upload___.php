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

    static function get_mime_type($file) {

        // our list of mime types
        $mime_types = array(
            "pdf" => "application/pdf"
            , "exe" => "application/octet-stream"
            , "zip" => "application/zip"
            // ,"docx"=>"application/msword"
            , "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
            , "doc" => "application/msword"
            , "rtf" => "text/rtf"
            , "txt" => "text/plain"
            , "xls" => "application/vnd.ms-excel"
            , "ppt" => "application/vnd.ms-powerpoint"
            , "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation"
            , "gif" => "image/gif"
            , "png" => "image/png"
            , "jpeg" => "image/jpg"
            , "jpg" => "image/jpg"
            , "mp3" => "audio/mpeg"
            , "wav" => "audio/x-wav"
            , "mpeg" => "video/mpeg"
            , "mpg" => "video/mpeg"
            , "mpe" => "video/mpeg"
            , "mov" => "video/quicktime"
            , "avi" => "video/x-msvideo"
            , "3gp" => "video/3gpp"
            , "css" => "text/css"
            , "jsc" => "application/javascript"
            , "js" => "application/javascript"
            , "php" => "text/html"
            , "htm" => "text/html"
            , "html" => "text/html"
            , "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            , "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
            , "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template"
            , "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow"
            , "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation"
            , "sldx" => "application/vnd.openxmlformats-officedocument.presentationml.slide"
            , "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
            , "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template"
            , "xlam" => "application/vnd.ms-excel.addin.macroEnabled.12"
            , "xlsb" => "application/vnd.ms-excel.sheet.binary.macroEnabled.12"
        );
        $extention = explode('.', $file);
        $extension = end($extention);
        $extension = strtolower($extension);
        return $mime_types[$extension];
    }

    public static function uploadPicture() {
        $user_id = Input::get('object_id');
        $type = Input::get('object_type');
        $user_id = Input::get('user_id');
        $uploader = new Utils_Uploader(array('jpeg', 'jpg', 'png'));
        $path = DOCROOT . 'assets/uploads' . DS;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $typeName = Model_Upload_Type::find($type)->types;
        $pic_name = $typeName . "_" . time();
        $original = $path . $pic_name;
        $output = $uploader->handleUploadRename($path, $pic_name);
        if (isset($output['success'])) {
            $original = $path . $output['full_filename'];
            $uploadAll = Model_Upload::forge();
            $uploadAll->user_id = $user_id;
            $uploadAll->type_id = $type;
            $uploadAll->name = $output['full_filename'];
            $uploadAll->original_name = $output['full_filename'];
            $uploadAll->path = $original;
            $uploadAll->save();
            $output['upload_id'] = $uploadAll->id;
            Image::load($original)->preset($typeName)->save($original);
            $localFileName = $path . $output['full_filename'];
            $remoteFileName = DOCROOT . 'assets/uploads/' . DS . $output['full_filename'];
            $output['uri'] = Uri::create('upload/get_image/' . $output['full_filename'] . '/' . $output['upload_id']);
        }
        return $output;
    }

    /*
      public function removeProfileLogo($img_name, $upload_id, $type_id) {
      $uploadType = Model_Upload_Type::find($type_id);
      $uploadModel = self::find($upload_id);
      if ($uploadType->thumbnail == 1) {
      $thumbnail_path = self::_THUMBNAIL_PATH;
      File::delete($thumbnail_path . $uploadModel->path);
      }
      File::delete($uploadModel->path);
      $uploadModel->delete();
      }

     */

    public function removeFiles() {
        $uploadType = Model_Upload_Type::find($this->type_id);
        if ($uploadType->thumbnail == 1) {
            $thumbnail_path = DOCROOT . self::_THUMBNAIL_PATH;
            if (file_exists($thumbnail_path . $this->path)) {
                File::delete($thumbnail_path . $this->path);
            }
        }
        if (file_exists($this->path)) {
            File::delete($this->path);
        }
        DB::query("DELETE FROM `uploads` WHERE id='".$this->id."'")->execute();
    }

}
