<script type="text/javascript">
  (function ($) {
    jQuery.expr[':'].Contains = function(a,i,m){
      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
    };
   
    function listFilter(header, list) {
    var form = $("<form>").attr({"class":"filterform","action":"#"}),
      input = $("<input>").attr({"class":"filterinput","type":"text"});
    $(form).append(input).appendTo(header);
   
    $(input)
      .change( function () {
      var filter = $(this).val();
      if(filter) {
        $(list).find("a:not(:Contains(" + filter + "))").parent().slideUp();
        $(list).find("a:Contains(" + filter + ")").parent().slideDown();
      } else {
        $(list).find("li").slideDown();
      }
      return false;
      })
    .keyup( function () {
      $(this).change();
    });
    }
  
    $(function () {
    listFilter($("#header"), $("#list"));
    });
  }(jQuery));
</script> 