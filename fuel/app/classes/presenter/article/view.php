<?php

/**
 * The Article view Presenter.
 *
 * @package  app
 * @extends  Presenter
 */
class Presenter_Article_View extends Presenter {

    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */
    public function view() {
        $this->article = $this->article;
        $this->admin = $this->admin;
        $this->fields = Model_Article_Detail::getFields();
        $this->uploads = $this->article->getUploads(7, 1);
    }

}
