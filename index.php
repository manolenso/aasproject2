<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Page accueil ASS</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 100px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html save -->


        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Association des Anciens de la SIRLO</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cabourg
                             <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="galerycabourg.html">L'appartement</a></li>
                                    <li><a href="cartecabourg.php">La situation</a></li>
                                    <li><a href="#">Les équipements</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header"></li>
                                    <li><a href="#">Les tarifs</a></li>
                                    <li><a href="calreserv_cabourg.php">Disponibilitées</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menton
                             <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="galerymenton.html">L'appartement</a></li>
                                    <li><a href="cartementon.php">La situation</a></li>
                                    <li><a href="#">Les équipements</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header"></li>
                                    <li><a href="#">Les tarifs</a></li>
                                    <li><a href="calreserv_menton.php#">Disponibilitées</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Meribel <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="galerymeribel.html">L'appartement</a></li>
                                    <li><a href="cartemeribel.php">La situation</a></li>
                                    <li><a href="carr.php">Les équipements</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header"></li>
                                    <li><a href="#">Les tarifs</a></li>
                                    <li><a href="calreserv_meribel.php#">Disponibilitées</a></li>
                                </ul>

                                    <li class="active"><a href="forum/index.php">Forum</a></li>
                                    <li><a href="#about">A Propos</a></li>
                                    <li><a href="#contact">Contact</a></li>
                      </ul> <!-- class=nav -->

<form class="navbar-form pull-right"><!-- modal block connection form  -->

  <a class="btn btn-primary" data-toggle="modal" href="#myModal" >Se connecter</a>

<div class="modal hide" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Bienvenue sur l'AAS</h3>
      </div>
      <div class="modal-body">
<form method="post" action='' name="login_form">

<p><input type="text" class="span3" name="eid" id="email" placeholder="Email"></p>
<p><input type="password" class="span3" name="passwd" placeholder="Mot de passe"></p>
<p><button type="submit" class="btn btn-primary">Se connecter</button>
        <a href="#">Mot de passe oublié?</a>
</p>
    </form><!-- footer -->
     </div>
    <div class="modal-footer">
<a class="btn btn-primary" data-toggle="modal" href="#register" >s'enregistrer sur l'AAS</a>
      </div>
    </div>
  </form>
<!-- end modal block connection form  -->

</div>

<div class="modal hide" id="register">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">x</button>
     <h3>Enregistrement sur l'AAS</h3>
</div>
      <div class="modal-body">
<form method="post" action='' name="login_form">
<p><label><input type="text" class="span3" name="eid" id="email" placeholder="Email"></label></p>
<p><label><input type="password" class="span3" name="passwd" placeholder="Mot de passe"></label></p>
<p><label><input type="password" class="span3" name="passwd2" placeholder="Confirmation mot de passe"></label></p>
<p><input type="submit" class="btn btn-primary" value="Enregistrement"/></p>
</form>
</div>
</div>

 <!-- Fin modal block connection form  -->
<?php
if(!empty($_POST['eid']))
{
// D'abord, je me connecte à la base de données.
mysql_connect("localhost", "root", "");
mysql_select_db("nom_db");

// Je mets aussi certaines sécurités ici…
$passwd = mysql_real_escape_string(htmlspecialchars($_POST['passwd']));
$passwd2 = mysql_real_escape_string(htmlspecialchars($_POST['passwd2']));
if($passwd == $passwd2)
{
$eid = mysql_real_escape_string(htmlspecialchars($_POST['eid']));

// Je vais crypter le mot de passe.
$passwd = sha1($passwd);

mysql_query("INSERT INTO validation VALUES('', '$eid', '$passwd' )");
}

else
{
echo 'Les deux mots de passe que vous avez rentrés ne correspondent pas…';
}
}
?>

                </div> <!-- .nav-collapse -->
            </div> <!--  .navbar-inner -->
        </div> <!--  .navbar navbar-inverse navbar-fixed-top -->
</div> <!-- /container -->

   <div class="container">
             <!--  Carousel taille des photos 1200x600px -->
   <!--  consult Bootstrap docs at
            http://twitter.github.com/bootstrap/javascript.html#carousel -->
  <div id="this-carousel-id" class="carousel slide">
     <div class="carousel-inner">

       <div class="item active"><!-- debut item active cabourg -->
         <a href="http://fr.wikipedia.org/wiki/Cabourg">  <img src="images/entete-cabourg1.jpg" alt="cabourg" />
            </a>
            <div class="carousel-caption">
              <p>Une architecture typique!</p>
              <p><a href="http://www.cabourg.net">Office du Tourisme de Cabourg &raquo;</a></p>
            </div>
          </div> <!-- fin cabourg -->

          <div class="item"> <!-- debut item meribel -->
            <a href="http://fr.wikipedia.org/wiki/Méribel">
              <img src="images/entete-meribel1.jpg" alt="meribel" />
            </a>
            <div class="carousel-caption">
              <p>Méribel centre</p>
              <p><a href="http://www.meribel.net/montagne-2012/footer/contact.html">Office du Tourisme de Meribel &raquo;</a></p>
            </div>
          </div> <!-- fin item meribel -->

          <div class="item"> <!-- debut item menton -->
            <a href="http://fr.wikipedia.org/wiki/Menton_(Alpes-Maritimes)">
              <img src="images/entete-menton1.jpg" alt="menton" />
            </a>
            <div class="carousel-caption">
              <p>Le port de Plaisance</p>
              <p><a href="http://www.tourisme-menton.fr">Office du Tourisme de Menton &raquo;</a></p>
            </div>
          </div> <!-- fin item menton -->

          <div class="item"><!-- debut item active cabourg -->
            <a href="http://fr.wikipedia.org/wiki/Cabourg">  <img src="images/entete-cabourg2.jpg" alt="cabourg" />
            </a>
            <div class="carousel-caption">
              <p>La plage du Casino</p>
              <p><a href="http://www.cabourg.net">Office du Tourisme de Cabourg &raquo;</a></p>
            </div>
          </div> <!-- fin cabourg -->

          <div class="item"><!-- debut item meribel -->
            <a href="http://fr.wikipedia.org/wiki/Méribel">
              <img src="images/entete-meribel2.jpg" alt="meribel" />
            </a>
            <div class="carousel-caption">
              <p>Les Randonnées d'été</p>
              <p><a href="http://www.meribel.net/montagne-2012/footer/contact.html">Office du Tourisme de Meribel &raquo;</a></p>
            </div>
          </div> <!-- fin item meribel -->

          <div class="item"><!-- debut item menton -->
            <a href="http://fr.wikipedia.org/wiki/Menton_(Alpes-Maritimes)">
              <img src="images/entete-menton2.jpg" alt="menton" />
            </a>
            <div class="carousel-caption">
              <p>Menton: la Citadelle</p>
              <p><a href="http://www.tourisme-menton.fr">Office du Tourisme de Menton &raquo;</a></p>
            </div>
          </div> <!-- fin item menton -->

          <div class="item"><!-- debut item active cabourg -->
            <a href="http://fr.wikipedia.org/wiki/Cabourg">  <img src="images/entete-cabourg3.jpg" alt="cabourg" />
            </a>
            <div class="carousel-caption">
              <p>La côte Normande</p>
              <p><a href="http://www.cabourg.net">Office du Tourisme de Cabourg &raquo;</a></p>
            </div>
          </div> <!-- fin cabourg -->

          <div class="item"><!-- debut item meribel -->
            <a href="http://fr.wikipedia.org/wiki/Méribel">
              <img src="images/entete-meribel3.jpg" alt="meribel" />
            </a>
            <div class="carousel-caption">
              <p>Un immense domaine skiable!</p>
              <p><a href="http://www.meribel.net/montagne-2012/footer/contact.html">Office du Tourisme de Meribel &raquo;</a></p>
            </div>
          </div> <!-- fin item meribel -->

          <div class="item"><!-- debut item menton -->
            <a href="http://fr.wikipedia.org/wiki/Menton_(Alpes-Maritimes)">
              <img src="images/entete-menton3.jpg" alt="menton" />
            </a>
            <div class="carousel-caption">
              <p>Menton: la Plage</p>
              <p><a href="http://www.tourisme-menton.fr">Office du Tourisme de Menton &raquo;</a></p>
            </div>
          </div> <!-- fin item menton -->


        </div> <!-- .carousel-inner -->
        <!--  next and previous controls here
              href values must reference the id for this carousel -->
          <a class="carousel-control left" href="#this-carousel-id" data-slide="prev">&lsaquo;</a>
          <a class="carousel-control right" href="#this-carousel-id" data-slide="next">&rsaquo;</a>
      </div> <!-- .carousel -->
      <!-- end carousel -->
            <!-- Main hero unit for a primary marketing message or call to action -->
                <button type="button" class="btn btn-block btn-primary" data-toggle="collapse" data-target="#demo">

                    <h2>Bienvenue</h2>
                </button>

      <div id="demo" class="collapse">
            <div class="hero-unit">

                <p>sur le site de l'Association des Anciens de la SIRLO Vous trouverez toutes les disponibilités des appartements de Méribel, Menton et Cabourg mis à jour le plus souvent possible . Vous avez la possibilité de télécharger tous les documents necessaires à votre séjour dans l'un des appartements de l'association. Pour la période d'hiver (1er novembre-31mai), la réservation s'effectue jusqu'au 31 octobre pour les membres actifs de l'association Sirlo, à partir du 1er novembre pour les membres de l'association préretraités et retraités et à partir du 15 novembre pour le personnel extérieur à la Sirlo. Pour la période d'été (1er juin-31octobre), la réservation s'effectue jusqu'au 15 mars pour les membres actifs de l'association Sirlo, à partir du 1er avril pour les membres de l'association préretraités et retraités et à partir du 15 avril pour le personnel extérieur à la Sirlo. Après ces périodes, la réservation se fait au premier inscrit.</p>
                <!--<p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p> -->
            </div>
      </div>


            <!-- Example row of columns -->
         <div class="row">
              <div class="span4">
                    <h3>Menton</h3>
                    <img src="images/entete-menton.jpg" class="img-polaroid">

                    <p><br>L'appartement est situé dans la résidence "le Limbania" Au 4éme et dernier étage de l'immeuble, la mer est à 300 métres
                      .Votre adresse à Menton:
                    <address>
                      <strong>le Limbiana</strong>
                      <br>122 impasse du chemin de la maison Russe  Route de Gorbio
                      <br><strong>06 500 MENTON</strong>
                    </address><p> Appartement de type F2, chambre avec 1 lit 140 cm,1 couchage clic clac 2 personnes dans le salon.1 lit d'appoint pliable 80cm Grande terrasse extérieure avec salon de jardin.Vous devez apporter les draps ( 2 lits de 140 cm + lit d'appoint de 80 cm ) et le linge de maison Attention : La location se fait du samedi 12 h au samedi 12h
                    </p>
                          <section class="row-fluid">
                            <p><a data-toggle="modal" href="#menton" class="btn">Disponibilitées</a></p>
                            <div id="menton" class="modal hide fade in" style="display: none; ">
                            <div class="modal-header">
                            <a class="close" data-dismiss="modal">×</a>
                            <h3>Disponibilitées pour Menton</h3>
                            </div>
                            <div class="modal-body-dispo">
                            <iframe  name="calendrier" SRC="reserv/cal/menton_3mois.php" scrolling="no" height="390" width="188" FRAMEBORDER="yes"></iframe>
                            </div>
                            <div class="modal-footer-dispo">
                            <a href="#" class="btn" data-dismiss="modal">Fermer</a>
                            <a href="#" class="btn btn-success">Reserver</a>
                          </section>
                </div>
                <div class="span4">
                    <h3>Cabourg</h3>
                    <img src="images/entete-cabourg.jpg" class="img-polaroid">
                    <p><br>L'appartement n°16 est situé au 3 eme et dernier étage du batiment B de la résidence frégate, en plein centre de cabourg à deux pas du casino et des commerces.Votre adresse à cabourg:</p>
                   <address>
                      <strong>la Frégate</strong>
                      <br>8 avenue André Prempain
                      <br><strong>14 390 CABOURG</strong>
                   </address>
                    <p>Appartement de type F2, une chambre avec 1 lit 160 cm,1 couchage de 140 cm clic-clac 2 personnes dans le salon.1 lit d'appoint pliable 80cm Terrasse extérieure avec salon de jardin.Une machine a laver est à votre disposition dans la salle de bains Vous devez apporter les draps ( 1 lit de 160 cm et 1 lit de 140 cm + lit d'appoint de 80 cm ) et le linge de maison Attention : La location se fait du samedi 12h au samedi 12h
                    </p>
                            <section class="row-fluid">
                              <p><a data-toggle="modal" href="#cabourg" class="btn">Disponibilitées</a></p>
                              <div id="cabourg" class="modal hide fade in" style="display: none; ">
                              <div class="modal-header">
                              <a class="close" data-dismiss="modal">×</a>
                              <h3>Disponibilitées  pour Cabourg</h3>
                              </div>
                              <div class="modal-body-dispo">
                              <iframe  name="calendrier" SRC="reserv/cal/cabourg_3mois.php" scrolling="no" height="390" width="188" FRAMEBORDER="yes"></iframe>
                              </div>
                              <div class="modal-footer-dispo">
                              <a href="#" class="btn" data-dismiss="modal">Fermer</a>
                              <a href="#" class="btn btn-success">Reserver</a>
                            </section>
               </div>
                <div class="span4">
                    <h3>Meribel</h3>
                    <img src="images/entete-meribel.jpg" class="img-polaroid">
                    <p><br>L'appartement conçus pour 5 personnes est situé au 4 éme étage de la résidence Cristal, Appartement 37, ascenseur B, en plein centre de Méribel. Prendre direction la chaudanne, la résidence fait l'angle de rue à quelques 100 m après le Supermarché Casino.
                      Votre adresse à Méribel :
                      <address>
                      <strong>le Cristal</strong>
                      <br>route de Mussillon
                      <br><strong>73 550 MERIBEL</strong>
                      </address>
                      <p>Pour le départ du ski, une navette passe au pied de l'immeuble direction la Chaudanne, ou vers l'altiport. Le retour se fait pied au ski devant l'office du tourisme, situé à 100 métres de la résidence La résidence dispose d'une piscine extérieure, d'un sauna, et d'une laverie commune.
      </p>
   <section class="row-fluid">
           <p><a data-toggle="modal" href="#meribel" class="btn">Disponibilitées </a></p>
                        <div id="meribel" class="modal hide fade in" style="display: none; ">
                        <div class="modal-header">
                        <a class="close" data-dismiss="modal">×</a>
                        <h3>Disponibilitées  pour Meribel</h3>
                        </div>
                        <div class="modal-body-dispo">
                        <iframe  name="calendrier" SRC="reserv/cal/meribel_3mois.php" scrolling="no" height="390" width="188" FRAMEBORDER="yes"></iframe>
                        </div>
                        <div class="modal-footer-dispo">
                        <a href="#" class="btn" data-dismiss="modal">Fermer</a>
                        <a href="#" class="btn btn-success">Reserver</a>
                      </section>
  </div>
</div>

    <hr>
    <section class="row-fluid">
      <div class="span4 visible-desktop">Target Desktop.</div>
      <div class="span4 visible-tablet">Target Tablet.</div>
      <div class="span4 visible-phone">Target Phone.</div>
    </section>

    <footer>
        <p>&copy; AAS Sirlo 2013</p>
    </footer>

</div> <!-- /container -->

        <!-- Bootstrap jQuery plugins compiled and minified -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>

   <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
                  $(document).ready(function(){
             $('.carousel').carousel({
                        interval: 2200
              });
             $('.fixedVersion.modal').modal().on("shown",function()
              {$(".modal-backdroop").insertAfter($(this));});
    </script>
  </body>
</html>
