<?php

define('TABNAME', 'ref_emplacement');

class Emplacement {

    public static function getEmplacements() {
        $columns = array('code_emplacement', 'libelle');
        $emplacements = DBGetter::getColumns(TABNAME, $columns, 'getEmplacements', 'code_emplacement');
        $ret = array();
        foreach ($emplacements as $emplacement) {
            $ret[] = array('id' => $emplacement['code_emplacement'], 'name' => $emplacement['libelle']);
        }
        return json_encode($ret);
    }

}
