

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Sliding Panels Sample</title>
<link href="SlidingPanelsSample_fichiers/SprySlidingPanels.css" rel="stylesheet" type="text/css">
<link href="SlidingPanelsSample_fichiers/samples.css" rel="stylesheet" type="text/css">
<style type="text/css">



hr, .clearAll {
	clear: both;
}

.SlidingPanels {
  width: 188px;
  height: 375px;
  margin-top: -15px;
  margin-bottom: 5px;

}
.SlidingPanelsContent {
  width: 188px;
  height: 375px;
  margin-bottom: 5px;

}

.p1 {

}
.p2 {

}
.p3 {

}




#link {
	font-size: 0.8em;
	color: #333333;
	text-align: left;
	margin-left: 5px;

}

#link a {
	color: #333333;
	border: 1px solid #cccccc;
	padding: 2;
}

</style>
<script type="text/javascript" src="SlidingPanelsSample_fichiers/SprySlidingPanels.js"></script>

</head>
<body>
<div style="overflow: hidden;" id="example2" class="SlidingPanels" tabindex="0">
	<div style="left: -1200px; top: 0px;" class="SlidingPanelsContentGroup">
		<div id="ex2_p1" class="SlidingPanelsContent p1"><iframe name="calendrier" SRC="mois1.php?ID_location=1&&an=2013?TB_iframe=" scrolling="no" height="490" width="188" FRAMEBORDER="no"></iframe></div>
		<div id="ex2_p2" class="SlidingPanelsContent p2"><iframe name="calendrier" SRC="mois2.php?ID_location=1&&an=2013?TB_iframe=" scrolling="no" height="490" width="188" FRAMEBORDER="no"></iframe></div>
		<div id="ex2_p3" class="SlidingPanelsContent p3"><iframe name="calendrier" SRC="mois3.php?ID_location=1&&an=2013?TB_iframe=" scrolling="no" height="490" width="188" FRAMEBORDER="no"></iframe></div>
		<div id="ex2_p4" class="SlidingPanelsContent p4"><iframe name="calendrier" SRC="mois4.php?ID_location=1&&an=2013?TB_iframe=" scrolling="no" height="490" width="188" FRAMEBORDER="no"></iframe></div>


  </div>
</div>
<div id="link">
&nbsp;&nbsp;<a href="#" title="Back" onclick="sp2.showPreviousPanel(); return false;">< Préc.</a>
<a href="#" title="Home" onclick="sp2.showFirstPanel(); return false;">&nbsp; 1 &nbsp;</a>

<a href="#" title="Next" onclick="sp2.showNextPanel(); return false;">Suiv. &gt; </a>
<script type="text/javascript">
var sp2 = new Spry.Widget.SlidingPanels('example2');
</script>
</div>

</body></html>

