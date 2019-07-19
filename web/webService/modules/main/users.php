<?php

define('TABNAME', 'sf_guard_user');

class User {

    public static function getUsers() {
        $columns = array('id', 'username', 'password','password_nomade', 'salt');
        $res = DBGetter::getColumns(TABNAME, $columns, 'getUsers');
        return json_encode($res);
    }

}
