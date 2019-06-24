$(document).ready(function(){
  if ($('#photo').length == 1){
      $('#photo').change(function(e){
        let reader = new FileReader();
        reader.onload = function(e){ 
          if($('img').length==1){
            $("img").attr('src',e.target.result);
          }
          else{
            $('#photo').prev('label').before('<img src="' + e.target.result + '" class="thumbnail img-fluid">');
          }
        }
        if (e.target.files.length > 0 )
        reader.readAsDataURL(e.target.files[0]);
      });
  }
});