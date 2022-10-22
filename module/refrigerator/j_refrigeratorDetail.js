$(".ref_detail_more").click(function(){
 var id = $(this).attr('data');
window.location.replace("index.php?page=ref_detail_more&rid="+id);  
 });
 
  $(".ref_detail_user").click(function(){
 var id = $(this).attr('data');
window.location.replace("index.php?page=ref_detail_user&rid="+id);  
 });