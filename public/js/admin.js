
$(document).ready(function () {
      
  $('#ordenes_entrega').change(function(){
      precio= parseFloat( $('#ordenes_precio').val());
  $('#ordenes_saldo').val( precio - parseInt($(this).val()));
   
});
$('#ordenes_precio').change(function(){
      entrega= parseFloat( $('#ordenes_precio').val());
  $('#ordenes_saldo').val(   parseInt($(this).val()) - entrega);
   
});





});

function cambiarestado(id){
    
    var classes = $('#estado_'+id).attr('class');
    //e.preventDefault();
   // alert(id);
    //var $link = $(e.currentTarget);
    $.ajax({
        method: 'POST',
        url: '/admin/orden/cambiarestado/'+id,
    }).done(function(data){
        
        $('#estado_'+id).html(data.estado);
        $('#estado_'+id).removeClass(classes);
        $('#estado_'+id).addClass( 'float-left estado-trabajo '+data.estado.toLowerCase());
       // location.reload();
        
    });
    
};
function registrarpago(id){
    
    //var classes = $('#estado_'+id).attr('class');
    //e.preventDefault();
   // alert(id);
    //var $link = $(e.currentTarget);
    $.ajax({
        method: 'POST',
        url: '/admin/orden/registrarpago/'+id,
    }).done(function(data){
        
        location.reload();
        
    });
    
};