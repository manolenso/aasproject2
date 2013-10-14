<?php
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------
?>

<div class="row" style="color:#FF9933; ">
    <div class="span9">
        <h4>
            Synth&egrave;se des r&eacute;servations pour l'ann&eacute;e 
            <?php
            if ($_POST) {
                $an_res = intval($_POST['an_res']);
            } elseif ($_GET) {
                $an_res = intval($_GET['an_res']);
            } else {
                $an_res = date("Y");
            }
            echo $an_res;
            ?>
        </h4>
    </div>
    <div class="span3"> 
        <form method="post" name="frmDate" action="<?php echo $_SERVER['PHP_SELF'] ?>" style="margin:0;">      
            <a href="index.php?an_res=<?php echo $an_res - 1 ?>"> <i class="icon-chevron-left"></i></a>
            <select class="input-small" id="select" name="an_res" onChange="frmDate.submit();">
                <?php $an = date('Y'); ?>
                <option value="<?php echo $an - 2 ?>" <?php
                if ($an_res == $an - 2) {
                    print 'selected';
                }
                ?>><?php echo $an - 2 ?></option>
                <option value="<?php echo $an - 1 ?>" <?php
                        if ($an_res == $an - 1) {
                            print 'selected';
                        }
                ?>><?php echo $an - 1 ?></option>
                <option value="<?php echo $an ?>" <?php
                        if ($an_res == $an) {
                            print 'selected';
                        }
                ?>>    <?php echo $an ?></option>
                <option value="<?php echo $an + 1 ?>" <?php
                        if ($an_res == $an + 1) {
                            print 'selected';
                        }
                ?>><?php echo $an + 1 ?></option>
                <option value="<?php echo $an + 2 ?>" <?php
                        if ($an_res == $an + 2) {
                            print 'selected';
                        }
                ?>><?php echo $an + 2 ?></option>
                <option value="<?php echo $an + 3 ?>" <?php
                        if ($an_res == $an + 3) {
                            print 'selected';
                        }
                ?>><?php echo $an + 3 ?></option>
            </select>
            <a href="index.php?an_res=<?php echo $an_res + 1 ?>"><i class="icon-chevron-right"></i></a> 
        </form>
    </div>
</div>



<table class="table table-hover table-condensed">
    <thead>
        <tr style="background:#F4C89F"> 
            <th width="258">Location</th>
            <th width="170" >Nbr de r&eacute;servations <sup>(1)</sup></th>
            <th width="112" >Nuitées <sup>(2)</sup></font></th>
            <th width="144" >Chiffre d'Affaire</th>
            <th width="94" >Calendrier</th>
        </tr>
    </thead>
    <tfoot>
    <td colspan="5">
        <small>(1) Nombre de r&eacute;servations qui commencent ou finissent pendant l'ann&eacute;e demand&eacute;e<br/>
            (2) Une r&eacute;servation du samedi au samedi couvre 8 jours pour 7 nuit&eacute;es. Une r&eacute;servation d'un jour compte pour une nuit&eacute;e
        </small>
    </td>
</tfoot>

<?php
// on initialise les variables de totaux	
$total_nbr_reserv = '';
$total_nuites = '';
$total_prix = '';

// requette de la liste des locations
$req_locations = mysql_query("SELECT nom_location, ID_location FROM $T_locations WHERE ID_location  ORDER BY nom_location ") or die("erreur requete location");
while ($val_locations = mysql_fetch_array($req_locations)) {
    ?>
    <tbody>
        <tr style="background:#FFF9F7" > 
            <td width="258"> 

                <strong><?php echo $val_locations['nom_location']; ?></strong>
            </td>
            <td width="170"> 
                <a href="liste_reserv_2.php?ID_location=<?php echo $val_locations['ID_location']; ?>&proder=der" title="liste des dernières locations" >&lt; </a> 
                <?php
                // écriture du premier janvier et 31 janvier de l'année demandée
                $premier_janv = $an_res . '0101';
                $dernier_dec = $an_res . '1231';

                $premier_janv_iso = $an_res . '-01-01';
                $dernier_dec_iso = $an_res . '-12-31';
                // requête des réservations de chaque location pour l'année demandée
                if (is_dir('suivi')) { // module suivi alors on ajoute AND ($T_reserv.etat_reserv=2)
                    $req_reserv = mysql_query("SELECT * FROM $T_reserv, $T_locations WHERE ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locations.ID_location=$val_locations[ID_location]) AND (datedeb <= '$dernier_dec_iso') AND (datefin >='$premier_janv_iso') AND ($T_reserv.etat_reserv=2)") or die("erreur requete reservations PLUS");
                } else {
                    $req_reserv = mysql_query("SELECT * FROM $T_reserv, $T_locations WHERE ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locations.ID_location=$val_locations[ID_location]) AND (datedeb <= '$dernier_dec_iso') AND (datefin >='$premier_janv_iso') ") or die("erreur requete reservations ");
                }
                // affiche le nbre de réservations
                $nbr_reserv = mysql_num_rows($req_reserv);
                echo $nbr_reserv;
                $nuites = 0;
                $prix_tot = 0;

                while ($val_nuites = mysql_fetch_array($req_reserv)) {
                    $date1 = "$val_nuites[datedeb]";
                    $date2 = "$val_nuites[datefin]";
                    // création de date de travail sous la forme AAAAMMJJ (sans le tiret)
                    $date_w1 = str_replace("-", "", "$date1");
                    $date_w2 = str_replace("-", "", "$date2");
                    // pour les réservations de début d'année
                    if ($date_w1 < $premier_janv) {
                        $date1 = $premier_janv_iso;
                    }
                    // pour les réservations de fin d'année (on ajoute un bonus d'une nuité)
                    if ($date_w2 > $dernier_dec) {
                        $date2 = $dernier_dec_iso;
                        $nuites++;
                    }
                    // si la réservation ne dure qu'une journée on compte une nuité
                    if ($date1 == $date2) {
                        $nbjours = 1;
                    } else {
                        // passage en temps unix et calcule du nombre de nuitées
                        $nbjours = round((strtotime($date2) - strtotime($date1)) / (60 * 60 * 24));
                    }
                    // calcul du nombre total de nuitées
                    $nuites += "$nbjours";
                    // calcul le total du chiffre d'affaire
                    $prix_tot += "$val_nuites[prix]";
                }
                ?>
                (<a href="liste_reserv.php?ID_location=<?php echo $val_locations['ID_location'] ?>&an_res=<?php echo $an_res ?>">Lister</a>) 
                <a href="liste_reserv_2.php?ID_location=<?php echo $val_locations['ID_location']; ?>&proder=pro" title="liste des prochaines locations">&gt;</a> 
            </td>
            <td width="112"><?php echo $nuites; ?></td>
            <td width="144"><?php echo $prix_tot; ?>&euro; </div></td>
            <td width="94"> 
                <a href="#" onClick="javascript:newWindow('cal/index.php?ID_location=<?php echo $val_locations['ID_location']; ?>&an=<?php echo $an_res; ?>', '', 1000, 900, 1, 0, 0, 0, 0, 0, 0);return(false)"><img src="img/calendrier.gif" width="24" height="24" align="absmiddle" border="0"></a>
            </td>
        </tr>

        <?php
// calcul des totaux à chaque itération
        $total_nuites += $nuites;
        $total_prix += $prix_tot;
        $total_nbr_reserv += $nbr_reserv;
    }
    ?>

    <tr style="background:#FFE0C1"> 
        <td width="258" height="22"><strong>TOTAUX</strong></td>
        <td width="170"><strong><?php echo "$total_nbr_reserv"; ?></strong></td>
        <td width="112"><strong><?php echo "$total_nuites"; ?></strong></td>
        <td width="144"><strong><?php echo "$total_prix"; ?> € </strong></td>
        <td width="94">&nbsp; </td>
    </tr>
</tbody>
</table>
