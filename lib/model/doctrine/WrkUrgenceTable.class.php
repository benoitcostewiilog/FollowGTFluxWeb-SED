<?php

/**
 * WrkUrgenceTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class WrkUrgenceTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object WrkUrgenceTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('WrkUrgence');
    }
    
      public function getUrgences($heureDebut = '', $heureFin = '', $fournisseur = '', $transporteur = '', $statut = '', $produit = '', $urgent = '') {
        $req = $this->createQuery()
                ->select('w.*,f.*,t.*,c.*,n.*,ap.*')
                ->from('WrkUrgence w')
                ->leftJoin('w.RefFournisseur f')
                ->leftJoin('w.RefTransporteur t')
                ->orderBy('w.created_at desc');

        if ($heureDebut != '') {
            $req->andWhere('w.created_at >=?', $heureDebut);
        }
        if ($heureFin != '') {
            $req->andWhere('w.created_at <=?', $heureFin);
        }
        if ($fournisseur != '') {
            $req->andWhere('w.id_fournisseur= ?', $fournisseur);
        }
        if ($transporteur != '') {
            $req->andWhere('w.id_transporteur = ?', $transporteur);
        }
     
   

        return $req->execute();
    }

    /**
     * Retourne la date du dernier urgence ou la date du jour si il n'y a pas d'urgence
     * @return type
     */
    public function getDernierUrgenceDate() {
        $dateArray = $this->createQuery()
                ->select('MAX(DATE(a.created_at))')
                ->from('WrkUrgence a')
                ->fetchArray();

        if (count($dateArray) > 0) {
            return date('d/m/Y', strtotime($dateArray[0]['MAX']));
        }
        return date('d/m/Y');
    }

    /**
     * 
     * @param WrkUrgence $urgence
     * @return boolean
     */
    public function envoiMail($urgence) {
        
         //A decommenter en PROD
      $emails = array($urgence->getRefInterlocuteur()->getMail());

        if (count($emails) == 0) {
            return true;
        }

        if ($emails[0]=="") {
            return true;
        }
        
        
          
        $titre ="Déclaration d'une urgence";
        $message="Numéro d'urgence : ".$urgence->getNumUrgence()."<br>";
        $message.="Intitulé fournisseur : ".$urgence->getRefFournisseur()->getLibelle()."<br>";
          $message.="N° tracking fournisseur : ".$urgence->getTrackingFour()."<br>";
            $message.="N° commande d'achat : ".$urgence->getCommandeAchat()."<br>";
              $message.="Horodatage de l'urgence : ".DateTime::createFromFormat('Y-m-d H:i:s', $urgence->getCreatedAt())->format('d/m/Y H:i:s')."<br>";

               try {
        $mail = Swift_Message::newInstance()
                ->setFrom('noreply@mobileit.fr', 'Follow GT')
                ->setTo($emails)
                ->setSubject($titre)
                ->setContentType('text/html')
                ->setBody(self::getBodyMail($titre, $message));
        $mailer = sfContext::getInstance()->getMailer();
       
            $mailer->send($mail);
        } catch (Swift_TransportException $e) {
           
        } catch (Swift_RfcComplianceException $e){
            
        }
        return true;
    }

      private static function getBodyMail($titre, $message) {
    
           $lienHTML = '<tr><td class="content-block aligncenter"><a href="gt-sed.mobilestock.fr" class="btn-primary">Cliquez ici pour accéder à l\'application</a></td></tr>';
    

        $template = '
      <!DOCTYPE html>
      <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>' . $titre . '</title>
        <style>
        .body-wrap,body{background-color:#f6f6f6}.footer,.footer a{color:#999}.aligncenter,.btn-primary{text-align:center}*{margin:0;padding:0;font-family:"Open Sans", "open sans", Arial,sans-serif;box-sizing:border-box;font-size:14px}.content,.content-wrap{padding:20px}img{max-width:100%}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%;line-height:1.6}table td{vertical-align:top}.body-wrap{width:100%}.container{display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important}.content{max-width:600px;margin:0 auto;display:block}.main{background:#fff;border:1px solid #e9e9e9;border-radius:3px}.content-block{padding:0 0 20px}.footer{width:100%;clear:both;padding:20px}.footer a,.footer td{font-size:12px}h1,h2,h3,tr,td{font-family:"Open Sans","open sans",Arial,"Lucida Grande",sans-serif;color:#676a6c;margin:40px 0 0;line-height:1.2;font-weight:400}h1{font-size:32px;font-weight:500}h2{font-size:24px}h3{font-size:18px}h4{font-size:14px;font-weight:600}ol,p,ul{margin-bottom:10px;font-weight:400}a{color:#1ab394;text-decoration:underline}.btn-primary{text-decoration:none;background-color:#f2971d;border:solid #f2971d;color:#FFF;border-width:5px 10px;line-height:2;font-weight:700;cursor:pointer;display:inline-block;border-radius:5px}@media only screen and (max-width:640px){h1,h2,h3,h4{font-weight:600!important;margin:20px 0 5px!important}h1{font-size:22px!important}h2{font-size:18px!important}h3{font-size:16px!important}.container{width:100%!important}.content,.content-wrap{padding:10px!important}}
        </style>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
      </head>
      <body>
        <table class="body-wrap">
          <tr>
            <td class="container" width="600">
              <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="content-wrap">
                      <table  cellpadding="0" cellspacing="0">
                        <tr>
                          <td>
                          <img id="aeromobile-logo" alt="image" src="http://gt-sed.mobilestock.fr/img/followgtmail.png" />'.
                          /*
                            <img class="img-responsive" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIcAAACJCAYAAAAG7St6AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkM4N0QxREVCOTdFMDExRTQ5OUU1RjI4MTVBOEU5OTE3IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkM4N0QxREVDOTdFMDExRTQ5OUU1RjI4MTVBOEU5OTE3Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6Qzg3RDFERTk5N0UwMTFFNDk5RTVGMjgxNUE4RTk5MTciIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6Qzg3RDFERUE5N0UwMTFFNDk5RTVGMjgxNUE4RTk5MTciLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4M3aYfAAAWjklEQVR42uydPYgjTXrH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"/>
                            */
                            '
                          </td>
                        </tr>
                        <tr>
                          <td class="content-block">
                            <h3>' . $titre . '</h3>
                          </td>
                        </tr>
                        <tr>
                          <td class="content-block">
                            ' . $message . '
                          </td>
                        </tr>
                        ' . $lienHTML . '
                      </table>
                    </td>
                  </tr>
                </table>
                <div class="footer">
                  <table width="100%">
                    <tr>
                      <td class="aligncenter content-block">Copyright <a href="http://www.mobileit.fr">MobileIT</a> © 20' . date('y') . '</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </body>
          </html>';

        return $template;
    }
}