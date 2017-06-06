$(document).ready(function(){
    var window = {
      width: $(document).width()
    };
    jQuery("a.colorbox").colorbox({
        width: window.width - window.width/3,
    });
});