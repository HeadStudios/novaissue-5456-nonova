</div>
      </div>
    </main>
  </div>
</div>
<script>



$( document ).ready(function() {
  const num = 2;
  
});

var elements = document.getElementsByClassName("checkboxer");

var myFunction = function() {
    var attribute = this.getAttribute("name");
    var groupid = this.getAttribute("aria-group");
    var trueorfalse;
    if(this.checked) { 
      trueorfalse = 1; 
      $("[aria-num="+attribute+"]").text("Complete");
      $("#row-"+this.name).appendTo("#tbody-"+groupid);
    } else { 
      trueorfalse = 0; 
      $("[aria-num="+attribute+"]").text("Doodoo");
      $("#row-"+this.name).prependTo("#tbody-"+groupid);
    }
    httpGet('{{ env('APP_URL') }}/api/check/'+attribute+'/' + trueorfalse);
    if ($('input[type="checkbox"]').not(':checked').length == 0) {
    $('#status').text("Completed");
    
  } else {  $('#status').text("Open");  
    
  }
  

  

};

for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', myFunction, false);
}

$( "#close" ).click(function() {
    $( "#dialog" ).hide();
});

$( "#close_c" ).click(function() {

  $( "#dialog" ).show();
});



/*$( "#close_c" ).click(function() {
  $( "#dialog" ).show();
});*/



function httpGet(theUrl)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
    return xmlHttp.responseText;
}
  </script>
</body>
</html>