var times="";

function sortTable(){
	  var rows = $('#mytable tbody  tr').get();

	  rows.sort(function(a, b) {

	  var A = parseInt($(a).children('td').eq(3).text());
	  var B = parseInt($(b).children('td').eq(3).text());
	  
	  if(A=="NaN"){
		  A=0;
	  }
	  if(B=="NaN"){
		  B=0;
	  }
	  //console.log("compare: "+A+" vs "+B);
	  if(A < B) {
	    return -1;
	  }

	  if(A > B) {
	    return 1;
	  }

	  return 0;

	  });

	  $.each(rows, function(index, row) {
	    $('#mytable').children('tbody').append(row);
	  });
	}

function getTimes(){
	$.ajax({
		   url:'lib/getTimes.php',
		   type:'GET',
		   success: function(data){
			  var times= jQuery.parseJSON(data);
		      //console.log('Data: '+times);
		      result="<table name='mytable' id='mytable' class='tablesorter'><thead><tr><th>Haltestelle</th><th>Linie</th><th>Richtung</th><th>Zeit (min)</th></tr></thead><tbody>"
		      for(i=1;i<times.length;i++){
		    	  if(i%11!=0){
		    		  result+="<tr><td>"+times[i][3]+"</td><td>"+times[i][0]+"</td><td>"+times[i][1]+"</td><td>"+times[i][2]+"</td></tr>";  
		    	  }
		    	  
		      }
		      //$('#times').html('Data: '+times[1][0]+' '+times[1][1]+' '+times[1][2]+' '+times[1][3]);
		      result+="</tbody></table>";
		      $('#times').html(result);
		      sortTable();
		   }
		});
}


$( document ).ready(function() {
	getTimes();
	window.setInterval(function(){
		  /// call your function here
		getTimes();
		}, 5000);
	
	
	
	$('#timetable').click(function(){
		console.log("click timetable");
		$('#config').fadeOut('', function(){
			$('#times').fadeIn();
			$('#second').removeClass('active');
			$('#first').addClass('active');
	    });
		getTimes();
	});
	
	$('#settings').click(function(){
		console.log("click settings");
		$('#times').fadeOut('', function(){
	        $('#config').fadeIn();
	        $('#first').removeClass('active');
			$('#second').addClass('active');
	    });
	});
	
});
