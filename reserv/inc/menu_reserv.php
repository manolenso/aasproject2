<div class="container">
    <div class="navbar navbar-fixed-top ">
        <div class="navbar-inner">
            <div class="container">
                
                <a class="btn btn-navbar span2" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-th"></span>
                </a>

                <div class="nav-collapse subnav-collapse">
                        <ul class="nav">
                        <li >
                            <a href="<?php echo $chemin; ?>"> <i class="icon-home"></i> </a>
                        </li>
<!--         version plus-->

                <?php if (is_dir('suivi') || is_dir('../suivi') || is_dir('../../suivi')) { // module suivi 
                            ?>
                            <li class="dropdown ">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    Suivi
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo $chemin; ?>/suivi/suivi_reserv.php">Demandes</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo $chemin; ?>suivi/contrat/">Contrats</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo $chemin; ?>suivi/gestion_mails.php">Mails</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo $chemin; ?>suivi/formulaire_loueur.php">Info loueur</a>
                                    </li>
                                </ul>
                            </li>
                <?php } // fin is_dir ?>

                        <li class="dropdown ">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Listes
                                <b class="caret"></b>
                            </a>
                                <ul class="dropdown-menu">
                                    
                                <li >
                                    <a href="<?php echo $chemin; ?>liste_reserv.php">Réservations</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo $chemin; ?>liste_locations.php">Locations</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo $chemin; ?>liste_locataires.php">Locataires</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown"  href="#">
                                Code
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo $chemin; ?>code.php">Calendrier</a>
                                </li>
<!--         version plus-->
                                <?php if (is_dir('suivi') || is_dir('../suivi') || is_dir('../../suivi')) { // module suivi 
                                    ?>
                                            
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo $chemin; ?>suivi/code_formulaire_reservation.php">Formulaire</a>
                                    </li>
                            <?php } // fin is_dir  ?>
                                    
                                    

                            </ul>
                        </li>

                        <!--         version plus-->
                        <?php if (is_dir('suivi') || is_dir('../suivi') || is_dir('../../suivi')) { // module suivi 
                            ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" >
                                    Modules
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo $chemin; ?>saisons/">Saisons</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo $chemin; ?>omniresa/index_omniresa.php">Omniresa</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo $chemin; ?>suivi/csv.php">Export</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo $chemin; ?>suivi/taxe_sejour.php">Taxe de séjour</a>
                                    </li>
                                    <li class="divider">
                                    <li>
                                        <a href="<?php echo $chemin; ?>stats/stats.php">Statistiques</a>
                                    </li>
                                </ul>
                            </li>

                        <?php } // fin is_dir  ?>
                            
                            
                            
                        <li>
                            <a href="<?php echo $chemin; ?>config.php">Config</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown"  href="#">
                                Aide
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="divider"></li>
                                <li>
                                    <a href="http://cogites.com/e_reserv/saisies.php" target="_blank" >Mode d'emploi</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="http://cogites.com/e_reserv/faq_reserv.php" target="_blank">FAQ</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="http://cogites.com/e_reserv/" target="_blank">Mise à jour</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="http://cogites.com/e_reserv/e_reserv_plus.php" target="_blank">Passer à E'reserv Plus</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a  href="#" onclick="newWindow('<?php echo $chemin; ?>formulaire_reserv_loueur.php', '', 1000, 800, 1, 0, 0, 0, 0, 0, 0);return(false)"><img src="<?php echo $chemin; ?>img/ajout_reserv.png" width="25" height="25" /> </a>
                        </li>
                        <li>
                            <a href="<?php echo $chemin; ?>session/logout.php"> <i class="icon-off"></i> </a>
                        </li>
                    </ul>

                    
                    <!--         version plus-->

                <?php if (is_dir('suivi') || is_dir('../suivi') || is_dir('../../suivi')) { // module suivi ?>
                    
                    
                    <form class="navbar-form pull-right" method="POST" action="<?php echo $chemin; ?>suivi/search.php">

                        <input type="text" name="search_text"  class=" input-medium search-query" placeholder="Recherche">
                        <button type="submit" class="btn" style="margin-left: -20px" ><i class="icon-search"  ></i></button>
                    </form>

                <?php } // fin is_dir  ?>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

