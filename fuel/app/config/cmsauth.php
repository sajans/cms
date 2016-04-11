<?php

/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */
/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */
return array(
    /**
     * DB connection, leave null to use default
     */
    'db_connection' => null,
    /**
     * DB write connection, leave null to use default
     */
    'db_write_connection' => null,
    /**
     * DB table name for the user table
     */
    'table_name' => 'users',
    /**
     * Choose which columns are selected, must include: username, password, email, last_login,
     * login_hash, group & profile_fields
     */
    'table_columns' => array('*'),
    /**
     * This will allow you to use the group & acl driver for non-logged in users
     */
    'guest_login' => true,
    /**
     * This will allow the same user to be logged in multiple times.
     *
     * Note that this is less secure, as session hijacking countermeasures have to
     * be disabled for this to work!
     */
    'multiple_logins' => false,
    /**
     * Remember-me functionality
     */
    'remember_me' => array(
        /**
         * Whether or not remember me functionality is enabled
         */
        'enabled' => false,
        /**
         * Name of the cookie used to record this functionality
         */
        'cookie_name' => 'rmcookie',
        /**
         * Remember me expiration (default: 31 days)
         */
        'expiration' => 86400 * 31,
    ),
    /**
     * Groups as id => array(name => <string>, roles => <array>)
     */
    'groups' => array(
        -1 => array('name' => 'Banned', 'roles' => array('banned')),
        10 => array('name' => 'Guests', 'roles' => array('guest')),
        20 => array('name' => 'Users', 'roles' => array('guest', 'user')),
        30 => array('name' => 'Writer', 'roles' => array('guest', 'user', 'writer')),
        50 => array('name' => 'Manager', 'roles' => array('guest', 'user', 'writer', 'manager')),
        100 => array('name' => 'Administrators', 'roles' => array('guest', 'user', 'writer', 'manager', 'admin')),
    ),
    'role_group' => array(
        'banned' => array('groupid' => '-1'),
        'guest' => array('groupid' => '10'),
        'user' => array('groupid' => '20'),
        'writer' => array('groupid' => '30'),
        'manager' => array('groupid' => '50'),
        'admin' => array('groupid' => '100'),
    ),
    'group_link' => array(
        '-1' => array('name' => 'banned'),
        '10' => array('name' => 'guest'),
        '20' => array('name' => 'user'),
        '30' => array('name' => 'writer'),
        '50' => array('name' => 'manager'),
        '100' => array('name' => 'admin'),
    ),
     'group_list' => array(
        '-1' =>  'banned',
        '10' =>'guest',
        '20' => 'user',
        '30' =>'writer',
        '50' =>'manager',
        '100' =>'admin',
    ),
    /**
     * Roles as name => array(location => rights)
     */
    'roles' => array(
        #Default Part
        '#' => array(
            'Controller_Welcome' => array(
                '404',
            ),
            'Controller_Pages' => array(
                'view',
            ),
            'Controller_Users' => array(
                'login',
                'logout',
            ),
            'Controller_Admin' => array(
                'login',
                'logout',
            ),
        ),
        #User Part Start
        'user' => array(
            'Controller_Users' => array(
                'index',
                'dashboard',
            ),
        ),
        #Admin Part Start
        'admin' => array(
            'Controller_Users' => array(
                'register',
            ),
            'Controller_Admin' => array(
                'index',
                'dashboard',
            ),
            'Controller_Admin_Users' => array(
                'create',
                'index',
                'list',
                'grid',
            ),
        ),
    ),
    /**
     * Salt for the login hash
     */
    'login_hash_salt' => 'put_some_salt_in_here',
    /**
     * $_POST key for login username
     */
    'username_post_key' => 'email',
    /**
     * $_POST key for login password
     */
    'password_post_key' => 'password',
);
