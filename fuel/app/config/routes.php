<?php
return array(
	'_root_'  => 'pages/view/home',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
        'person' => 'pages/view/person', //person
        'place' => 'pages/view/place', //place
        'home' => 'pages/view/home', //home
        'festival' => 'pages/view/festival', //festival
        'about-us' => 'pages/view/about-us', //About Us
        'contact-us' => 'pages/view/contact-us', //Contact Us
        'help' => 'pages/view/help', //Contact Us
      //  '(:any)' => 'article/index/$1', #not work
);