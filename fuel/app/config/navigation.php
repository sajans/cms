<?php

return array(
    #default Settings
    'default' => array(
        'template' => 'template',
        'body_attr' => array(
            'class' => 'main',
        ),
        'before' => false,
        'navigation' => 'public_navigation',
        'after_navigation' => false,
        'sidebar' => false,
        'pageheader' => false,
        'css' => array(),
        'js' => array(),
    ),
    #default Settings
    #routs
    'routes' => array(
        'home' => array(
            'body_attr' => array(
                'class' => 'home-page',
            ),
            'navigation' => 'public_navigation',
        ),
        '_root_' => array(
            'body_attr' => array(
                'class' => 'front',
            ),
            'navigation' => 'public_navigation',
            'template' => 'template',
            'css' => array(
                'frontpage.css',
            ),
        ),
        'Person' => array(
            'body_attr' => array(
                'class' => 'person-page',
            ),
            'navigation' => 'public_navigation',
        ),
        'Place' => array(
            'body_attr' => array(
                'class' => 'place-page',
            ),
            'navigation' => 'public_navigation',
        ),
         'Festival' => array(
            'body_attr' => array(
                'class' => 'festival-page',
            ),
            'navigation' => 'public_navigation',
        ),
    ),
    #routs
    #links
    'links' => array(
        'public_navigation' => array(
            'home' => 'Home',
            'about-us' => 'About Us',
            'contact-us' => 'Contact Us',
            'help' => 'Help',
            /*
            'dropdown1' => array(
                'text' => 'More', //'More dropdown',
                'href' => '#',
                'children' => array(
                    'category1' => array(
                        'text' => 'Category One',
                        'href' => 'category1',
                    ),
                    'category2' => array(
                        'text' => 'Category Two',
                        'href' => 'category1',
                    ),
                ),
            ),
            */
        ),
    ),
        #links
);
