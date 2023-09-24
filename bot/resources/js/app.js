import './bootstrap';

    var val =document.getElementById('countries-select');
    val.addEventListener("change", function(){
      var  id=val.value;
      const url='http://localhost:8000/update/'
        document.location.href=url+id;
    })


