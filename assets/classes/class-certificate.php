<?php 

class Certificate {

    public $image;
    public $name;

    public function __construct($id){
        if($id){
            $user = new Aenea_User(wp_get_current_user());
            $this->image = $this->getCetificateImage($id);
            $this->name = $user->user->display_name;
        }
    }

    public function getCetificateImage($id){
        return get_field('completion_certificate_image', $id);
    }
}