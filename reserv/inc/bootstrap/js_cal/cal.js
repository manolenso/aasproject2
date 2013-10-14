            /* French initialisation for the jQuery UI date picker plugin. */
/* Written by Keith Wood (kbwood{at}iinet.com.au) and StÃ©phane Nahmani (sholby@sholby.net). */
jQuery(function($){
	$.datepicker.regional['fr'] = {
            closeText: 'Fermer',
            prevText: '&#x3c;PrÃ©c',
            nextText: 'Suiv&#x3e;',
            currentText: 'Courant',
            monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
		'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
            monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
		'Jul','Aoû»','Sep','Oct','Nov','Déc'],
            dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
            dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
            dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
            weekHeader: 'Sm',
            
            isRTL: false,
            showMonthAfterYear: false,
            
            
            
            dateFormat: 'dd-mm-yy',
            minDate:0,
            firstDay: 6,

            
            yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
        
        

       var datepickers = $('.datepicker').datepicker({
            minDate:0,
            
//            sélectionne la valeur date dès qu'elle est changé dans un des deux champs
            onSelect: function(date){
                var option = this.id == 'date_deb' ? 'minDate' : 'maxDate';
                datepickers.not('#'+this.id).datepicker('option',option,date);
            }
            
        })
              
    });
      