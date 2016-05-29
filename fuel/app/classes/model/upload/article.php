<?php

class Model_Upload_Article extends \Orm\Model {

    protected static $_properties = array(
        'id',
        'upload_id',
        'article_id',
    );
    protected static $_table_name = 'upload_articles';

}
