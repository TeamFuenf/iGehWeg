/* --- Scrollfunktion für Unterseiten ------------------------------------------------------------------------------ */

  var numpages;
  var windowwidth;
  var activepage = 0;
  
  // Scrollfunktion
  function page(nr)
  {
    $("#scroll span:nth-child("+(activepage+1)+") a").html("&#9675;");
    $("#scroll span:nth-child("+(nr+1)+") a").html("&#9679;");
    activepage = nr;
    var offset = -nr*windowwidth;
    $("#pages").animate({"left" : offset+"px"}, 1000);      
  }

  function pagePrev()
  {
    if (activepage > 0)
    {
      page(activepage-1);
    }
  }
  
  function pageNext()
  {
    if (activepage < (numpages-1))
    {
      page(activepage+1);
    }
  }

  $(document).ready(function() {
    numpages = $("#pages > li").size();
    windowwidth = $("#window").width();
    
    // Seitenbreiten anpassen     
    $("#pages > li").width(windowwidth + "px"); 
    $("#pages").width(numpages*windowwidth+100 + "px"); 
  
    // Scolleiste einblenden
    if (numpages > 1)
    {
      var scrollbuttons = "";
      for (var i=0; i < numpages; i++)
      {
        if (activepage == i)
        {
          scrollbuttons += "<span><a href='javascript:page("+i+")'>&#9676;</a></span>";
        }
        else
        {
          scrollbuttons += "<span><a href='javascript:page("+i+")'>&#9675;</a></span>";
        }        
      }      
      $("#window").append("<div id=\"scroll\">" + scrollbuttons + "</div>");
      $("#scroll").width(windowwidth + "px");
    }

    // Mit Seite 1 initialisieren
    page(0);
    
    $("html").keyup(function(event)
    {
      if (event.which == 39)
      {
        pageNext();
      }
      if (event.which == 37)
      {
        pagePrev();
      }
    });
    
});
