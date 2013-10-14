            /* French initialisation for the jQuery UI date picker plugin. */
/* Written by Keith Wood (kbwood{at}iinet.com.au) and Stéphane Nahmani (sholby@sholby.net). */
jQuery(function($){
	$.datepicker.regional['fr'] = {
            closeText: 'Fermer',
            prevText: '&#x3c;Préc',
            nextText: 'Suiv&#x3e;',
            currentText: 'Courant',
            monthNames: ['Janvier','F�vrier','Mars','Avril','Mai','Juin',
		'Juillet','Ao�t','Septembre','Octobre','Novembre','D�cembre'],
            monthNamesShort: ['Jan','F�v','Mar','Avr','Mai','Jun',
		'Jul','Ao��','Sep','Oct','Nov','D�c'],
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
            
//            s�lectionne la valeur date d�s qu'elle est chang� dans un des deux champs
            onSelect: function(date){
                var option = this.id == 'date_deb' ? 'minDate' : 'maxDate';
                datepickers.not('#'+this.id).datepicker('option',option,date);
            }
            
        })
              
    });
      