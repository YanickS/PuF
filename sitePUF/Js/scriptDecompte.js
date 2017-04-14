$(function(){
	
	var note = $('#note'),ts = new Date(2014, 11, 15);
	
	if(((new Date()) < ts)){
		$('#countdown').countdown({
			timestamp	: ts,
			callback	: function(days, hours, minutes, seconds){
			
				var message = "";
			
				message += days + " jour" + ( days==1 ? '':'s' ) + ", ";
				message += hours + " heure" + ( hours==1 ? '':'s' ) + ", ";
				message += minutes + " minute" + ( minutes==1 ? '':'s' ) + " et ";
				message += seconds + " seconde" + ( seconds==1 ? '':'s' ) + " <br />";
			
				note.html(message);
			}
		});
	} else {
		$('#countdown').countdown({
			timestamp	: ts
		});
		note.html("Ouverture imminente");
	}	
});
