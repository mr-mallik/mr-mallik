<?php

$CONN = DBConnect(DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD);

function siteMenu()
{
    $menu = [
        '' => 'Home',
        'about' => 'About',
        'projects' => 'Works',
        'stories' => 'Stories',
        'contact' => 'Contact',
    ];

    return $menu;
}