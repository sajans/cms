<?php

class Model_User extends \Orm\Model {

    protected static $_properties = array(
        'id',
        'username',
        'first_name',
        'last_name',
        'password',
        'password_',
        'group',
        'email',
        'last_login',
        'login_hash',
        'profile_fields',
        'address',
        'mobile_number',
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
    protected static $_table_name = 'users';

    public static function populate_register_fieldset(Fieldset $form) {
        $form->add('username', 'Username:')->add_rule('required');
        $form->add('password', 'Choose Password:', array('type' => 'password'))->add_rule('required');
        $form->add('password2', 'Re-type Password:', array('type' => 'password'))->add_rule('required');
        $form->add('email', 'E-mail:')->add_rule('required')->add_rule('valid_email');
        $form->add('submit', ' ', array('type' => 'submit', 'value' => 'Register'));
        return $form;
    }

    public static function register(Fieldset $form) {
        $form->add('username', 'Username:')->add_rule('required');
        $form->add('password', 'Choose Password', array('type' => 'password'))->add_rule('required');
        $form->add('password2', 'Re-type Password:', array('type' => 'password'))->add_rule('required');
        $form->add('email', 'E-mail:')->add_rule('required')->add_rule('valid_email');
        $form->add('submit', ' ', array('type' => 'submit', 'value' => 'Register'));
        return $form;
    }

    public static function validate($factory) {
        $val = Validation::forge($factory);
        $val->add_field('password', 'Password', 'required|max_length[255]');
        //$val->add_callable('Utils_Validationrules');
        $val->add('email', 'Email')
                ->add_rule('required')
                ->add_rule('max_length', 255)
                ->add_rule('valid_email');


        $val->add_field('first_name', 'First Name', 'required|max_length[255]');

        return $val;
    }

    public static function validate_registration(Fieldset $form, $auth) {
        $form->field('password')->add_rule('match_value', $form->field('password2')->get_attribute('value'));
        $val = $form->validation();
        $val->set_message('required', 'The field :field is required');
        $val->set_message('valid_email', 'The field :field must be an email address');
        $val->set_message('match_value', 'The passwords must match');

        if ($val->run()) {
            $username = $form->field('username')->get_attribute('value');
            $password = $form->field('password')->get_attribute('value');
            $email = $form->field('email')->get_attribute('value');
            try {
                $user = $auth->create_user($username, $password, $email);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }

            if (isset($user)) {
                $auth->login($username, $password);
            } else {
                if (isset($error)) {
                    $li = $error;
                } else {
                    $li = 'Something went wrong with creating the user!';
                }
                $errors = Html::ul(array($li));
                return array('e_found' => true, 'errors' => $errors);
            }
        } else {
            $errors = $val->show_errors();
            return array('e_found' => true, 'errors' => $errors);
        }
    }
    
        public static function getwritterList() {

        $writters = self::find("all");
        $selectList[''] = "Please Select";
        if ($writters) {
            foreach ($writters as $writter) {
                $selectList[$writter->id] = $writter->first_name." ".$writter->last_name;
            }
        }
        return  $selectList;
    }

}
