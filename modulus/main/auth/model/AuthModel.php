<?php 

namespace modulus\main\auth\model;
use core\model;
use \library\error;
use \Valitron\Validator as v;
use UserCookie;
use User;
use old;

class AuthModel extends model
{
    #sign in
    public function signIn()
    {
        $http1 = 'auth';

        $form = [
            'user_email',
            'user_password',
        ];

        #array diff keys
        array_different($form, $_POST) ?: 
            $this->return->code(404)->return('error_form')->get()->referer();

        #peel tags of array
        $data = peel_tag_array($_POST);
        old::create($data);

        #check via valitron
        $v = new v($data);

        $v->rule('required', 'user_email');
        $v->rule('required', 'user_password');

        $v->rule('lengthMin', 'user_email', 7);
        $v->rule('lengthMin', 'user_password', 3);

        $v->rule('lengthMax', 'user_email', 30);
        $v->rule('lengthMax', 'user_password', 30);
        error::valitron($v, $http1);
        
        #user
        $user = $this->db->t1where('user', 'user_email=? && user_password=?', [
            $data['user_email'], $data['user_password']
        ]);

        $user ?: $this->return->code(404)->return('user_not_found')->get()->referer();
        
        $update = $this->db->update('user', [
            'user_id' => $user->user_id,
            'user_ip' => REMOTE_ADDR(),
            'user_updated' => date('Y-m-d H:i:s')
        ], ['id' => 'user_id']);

        $update['status'] == TRUE ?:
            $this->return->code(404)->return('error')->get()->referer();

        UserCookie::create([
            'user_email' => $user->user_email,
            'user_login' => $user->user_login,
            'user_password' => $user->user_password,
        ]);

        User::create($user);

        old::delete($data);

        #unset variables
        unset($http1); unset($data); unset($_POST); unset($v); unset($user); unset($form);

        $this->return->code(200)->return('login', User::user_login())->get()->http();
    }

    public function signOut()
    {
        $login = User::user_login();
        $http1 = 'auth';

        User::delete('user');

        User::has() 
            ? $this->return->code(404)->return('error')->get()->referer() 
            : $this->return->code(200)->return('logout', $login)->get()->http();
    }

}

