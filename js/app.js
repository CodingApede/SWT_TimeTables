function getTimetableFromId(ID){
	$.get( "http://www.swtue.de/abfahrt.html?halt=23604", function( data ) {
		  $( ".result" ).html( data );
		  alert( "Load was performed." );
		});
}



$( document ).ready(function() {

	getTimetableFromId("23604");
});
