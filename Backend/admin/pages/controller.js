function getContent(id){
    $(document).ready(function(){
        var mod_id = id;
        $.ajax({
          url:"getContent.php",
          method: "POST",
          data: "mod_id="+mod_id,
          success: function(data){
            $('#edycja').html(data);
            $('#modify').modal("show");
          },
          error: function(data){
            console.log("Error");
          }
        });
    });
}
function deleteProduct(id){
  $(document).ready(function(){
    var id_pr = id;
    $.ajax({
      url: "getContent.php",
      method: "POST",
      data: "id_pr="+id_pr,
      success: function(data){
        $('#usuwanie').html(data);
        $('#usun').modal("show");
      },
      error: function(data){
        console.log("Error");
      }
    });
  });
}
function addToCartAdmin(id){
  $(document).ready(function(){
    var id_adm = id;
    $.ajax({
      url: "addToCartAdm.php",
      method: "POST",
      data: "id_adm="+id_adm,
      success: function(data){
        $('#resultt').html(data);
        console.log("Success");
      },
      error: function(){
        console.log("Error2");
      }
    });
  });
}