<?php

abstract class Controller_Base extends Controller_Template {

    protected $_template = 'template';

    public function before() {
        parent::before();
        $this->set_theme();
    }

    protected function set_theme() {


        View::bind_global('before', $false);
        View::bind_global('navigation', $false);
        View::bind_global('after_navigation', $false);
        View::bind_global('sidebar', $false);
        View::bind_global('pageheader', $false);
        //echo "<pre>";var_dump(Uri::current()); exit;
        //$theme = Utils_Themer::get_theme(Uri::current());
        $theme = Utils_Themer::get_theme($this->request->uri->uri);
        //var_dump($theme); exit;
        $this->template = view::forge($theme['template']);
        View::bind_global('body_attr', $theme['body_attr']);
        Asset::css($theme['css'], array(), 'head_css');
        foreach ($theme['js'] as $js) {
            Casset\Casset::js($js);
        }
        if ($theme['before']) {
            $before = array();
            $before['content'] = View::forge('big_bar', $theme['before']);
            View::bind_global('before', $before);
        }
        if ($theme['navigation']) {
            $navigation = call_user_func('Utils_Navigation::get_links', $theme['navigation']);
            View::bind_global('navigation', $navigation, false);
        }
        if ($theme['after_navigation']) {
            View::bind_global('after_navigation', $theme['after_navigation'], false);
        }

        if ($theme['sidebar']) {
            View::bind_global('sidebar', $theme['sidebar']);
        }

        if ($theme['pageheader']) {
            View::bind_global('pageheader', $theme['pageheader']);
        }
    }

}
