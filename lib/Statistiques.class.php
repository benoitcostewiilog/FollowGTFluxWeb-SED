<?php

class Statistiques
{
	static public function majKpiRetard($dateDebut, $dateFin)
	{
        $dateDebut = $dateDebut." 00:00:00";
        $dateFin   = $dateFin." 23:59:59";
        
        $con = Doctrine_Manager::getInstance()->connection();
        
        $host = "localhost";
        $user = "root";
        $password = "";
        $bdd = "gt_log_tst_01";
        $link = mysql_connect($host,$user,$password);
        mysql_select_db($bdd);
        
        // Vidage de la table tampon
        $req = $con->execute("TRUNCATE TABLE exp_kpi_retard ");

        // Ajout unite, br_sap, date_reception
        $req = $con->execute("INSERT INTO exp_kpi_retard (unite_tracking, num_arrivage, date_reception)
                                    SELECT ref_produit, br_sap, created_at
                                    FROM wrk_mouvement
                                    WHERE wrk_mouvement.created_at < '".$dateFin."'
                                    AND wrk_mouvement.created_at > '".$dateDebut."'	
                                    AND wrk_mouvement.code_emplacement = 'Réception'");

        // Arrivage
        $req = $con->execute("UPDATE exp_kpi_retard ek, wrk_arrivage_produit wap 
                              SET ek.date_arrivage = wap.created_at
                              WHERE wap.ref_produit = ek.num_arrivage
                              AND ek.num_arrivage <> 'Absent'
                              AND wap.br_sap IS NULL");

        // Dépose
        $req = $con->execute("UPDATE exp_kpi_retard ek SET ek.date_depose = 
                            (
                                SELECT wm.heure_prise
                                FROM wrk_mouvement wm
                                WHERE wm.ref_produit = ek.unite_tracking
                                AND wm.type = 'depose'
                                AND wm.code_emplacement <> 'Réception'
                                ORDER BY wm.created_at DESC
                                LIMIT 1 )");
        
        //calcul des délais
        $res = WrkMouvementTable::getInstance()->getDelaisReceptionUniteTracking($dateDebut, $dateFin);
        
        //mise à jour de la table tampon
        foreach ($res as $ut){
            $retard = $ut['date_depose'] ? $ut['time_retard_depose'] : $ut['time_retard_sans_depose'];
            $req = $con->execute("UPDATE exp_kpi_retard set delai_brut = '".$ut['time_delais_acheminement']."', "
                . "                                              delai = '".$ut['time_delais_acheminement_horaire']."',"
                . "                                              retard= '".$retard."'"
                . "               WHERE unite_tracking = '".mysql_real_escape_string($ut['unite'])."' ");
        }
        
        
        
        
        
	}
	
	
	
}