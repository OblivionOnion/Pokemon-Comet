function gettip(image)
{
document.getElementById('tip').innerHTML="<img src='" + image + "' />";
}
function reset()
{
document.getElementById('tip').innerHTML=" ";
}

function loadXMLDoc(url)
{
  $('#load').html('Loading...');
     if (window.XMLHttpRequest)
     {
       xmlhttp=new XMLHttpRequest();
     }
     else
     {
       xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
     }
     xmlhttp.open("GET",url,false);
     xmlhttp.send(null);
     $('#load').html(innerHTML=xmlhttp.responseText);
}
$(document).ready(function(){
});

var URL = document.location.href;

var URLsearch = URL.search('pcomet.comeze.com');

if(URLsearch == -1) {
	window.location = 'http://en.wikipedia.org/wiki/Proxy_server';
}

function showButton(buttonValue){
  var buttonHTML = "<input type='submit' value='" + buttonValue + "' name='submit' />";
  if(document.getElementById("button_place")) {
    document.getElementById("button_place").innerHTML = buttonHTML;
  }
}

  function ShowImage() {
    var options = document.getElementsByTagName("option");
    for (var i=0; i < options.length; i++) {
      if (options[i].selected == true) { document.getElementById("trainer_img").src = "http://pokemoncomet.co.cc/images/sprites/normal/"+options[i].innerHTML+".png"; }
    }
  }
