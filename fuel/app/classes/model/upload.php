<?php

class Model_Upload extends \Orm\Model {

    protected static $_properties = array(
        'id',
        'user_id',
        'type_id',
        'join_id',
        'join_type',
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
    protected static $_belongs_to = array(
        'articles' => array(
            'key_from' => 'join_id',
            'model_to' => 'Model_Article',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
            'conditions' => array(
                'where' => array(
                    array('join_type', '=', Model_Article::JOINTYPE_UPLOAD),
                ),
            ),
        ),
            /*
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
             */
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

    public function removeFiles() {
        $uploadType = Model_Upload_Type::find($this->type_id);
        if ($uploadType->thumbnail == 1) {
            $thumbnail_path = DOCROOT . self::_THUMBNAIL_PATH;
            if (file_exists($thumbnail_path . $this->path)) {
                File::delete($thumbnail_path . $this->path);
            }
        }
        if (file_exists($this->path . $this->name)) {
            File::delete($this->path . $this->name);
        }
        DB::query("DELETE FROM `uploads` WHERE id='" . $this->id . "'")->execute();
    }

    public function cropCoverPhoto($Croppath, $upload_id) {
        $uploader = new Utils_Uploader(array('jpeg', 'jpg', 'png'));
        $uploads = self::find($upload_id);
        $oldpath = $uploads->path;
        $oldname = $uploads->name;
        $uploadTypeModel = Model_Upload_Type::find($uploads->type_id);
        $typeName = $uploadTypeModel->types;
        if (file_exists($oldpath . $oldname)) {
            File::delete($oldpath . $oldname);
        }

        $img = $Croppath;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);


        $file = $oldpath ."crop_image_".$upload_id.".png";
        $original = $oldpath.$oldname;
        //$thumbnail = $path . 'min_' . $newFile;
        $success = file_put_contents($file, $data);
        //Image::load($file)->preset('coverimage')->save($thumbnail); //360 width
        Image::load($file)->preset($typeName)->save($original); //1260 width
        File::delete($file);
        return $oldname;
    }

}
