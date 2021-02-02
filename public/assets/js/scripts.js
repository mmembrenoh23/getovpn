(function(window, undefined) {
  'use strict';

  $("#servers .card").on("click",function(e){
    e.preventDefault();

    window.location=window.location.href.replace("servers","server");
  });
  /*
  NOTE:
  ------
  PLACE HERE YOUR OWN JAVASCRIPT CODE IF NEEDED
  WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR JAVASCRIPT CODE PLEASE CONSIDER WRITING YOUR SCRIPT HERE.  */

})(window);