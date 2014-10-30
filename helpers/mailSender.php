<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mailSender
 *
 * @author asus
 */
class mailSender {
    //put your code here
    function __construct() {
        echo "ok";
    }
    
    function send(){
        $to = "adrianotalvaro@hotmail.com";
        $subject = "test";
        $message = "message";

        if(!function_exists('wp_mail'))
            echo "wp_mail";
        //else
         //   echo "paila";
        $headers[] = 'From: Me Myself <me@example.net>';

        wp_mail( $to, $subject, $message );
    }
    
}
