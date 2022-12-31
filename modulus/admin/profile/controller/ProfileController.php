<?php 

namespace modulus\admin\profile\controller;
use modulus\admin\profile\model\ProfileModel;
use core\controller;

class ProfileController extends controller
{
    public $profile;
    
    public function __construct()
    {
        $this->profile = new ProfileModel();
    }

    public function ProfileInfo()
    {
        $this->layout('panel', 'admin', 'profile', 'profile', []);
    }

    public function update()
    {
        $this->layout('panel', 'admin', 'profile', 'update', []);
    }

    public function ProfileUpdate()
    {
        $this->profile->ProfileUpdate();
    }
}
