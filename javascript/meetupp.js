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
   
/*    
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
*/

});
    
/* --- Nachrichtensystem ------------------------------------------------------------------------------------------- */

$(document).ready(function() {

  $("form button[name=sendmail]").on("click", function() {
    var mailstatus = $("form div#mailstatus");
    var button = $(this);
    var receiver = $("form select[name=receiver]");
    var messagebox = $("form textarea[name=messagetext]");

    $.post("../mail/send", 
    {
      to: receiver.val(),
      message: messagebox.val()
    }, 
    function(data) {
      if (data == "okay")
      {
        mailstatus.html("Nachricht wurde gesendet");        
        messagebox.val("");
        receiver.removeAttr('selected').find('option:first').attr('selected', 'selected');
      }
    });
    
  });

});

/* --- Eventsystem ------------------------------------------------------------------------------------------------- */

$(document).ready(function()
{

  /**
   * Location updaten
   */
  $("#eventlocations li").on("click", function()
  {
    var eventid = $("#eventid").attr("eventid");
    var locationid = $(this).attr("locationid");
    $("#eventlocations li").removeClass("selected");
    $(this).addClass("selected");
    $.post("../event/update/location", 
    {
      eventid: eventid,
      locationid: locationid
    });
    pageNext();
  });

  /**
   * Teilnehmerstatus updaten
   */
  $("#eventmembers button").on("click", function()
  {   
    var eventid = $("#eventid").attr("eventid");
    var memberid = $(this).attr("memberid");    
    var status = "";
    if ($(this).attr("status") == "none")
    {
      status = "invited";
      $(this).attr("status", "invited");
      $(this).html("Einladung gesendet");
    }
    else
    {
      status = "none";     
      $(this).attr("status", "none");
      $(this).html("einladen");
    }    

    $.post("../event/update/member", 
    {
      eventid: eventid,
      memberid: memberid,
      status: status
    });
  });

  /**
   * Basisdaten updaten
   */
  $("#eventbutton_basedata_next").on("click", function()
  {   
    var eventid = $("#eventid").attr("eventid");
    var title = $("#eventname").val();
    var from_date = $("#eventfromdate").val();
    var from_time = $("#eventfromtime").val();
    var to_date = $("#eventtodate").val();
    var to_time = $("#eventtotime").val();
    
    $.post("../event/update/basedata", 
    {
      eventid: eventid,
      title: title,
      from_date: from_date,
      from_time: from_time,
      to_date: to_date,
      to_time: to_time,
    });
    pageNext();
  });
 
  /**
   * An Event teilnehmen
   */
  $("button.acceptevent").on("click", function()
  {
    var eventid = $(this).attr("eventid");
    var memberid = $("div#userid").attr("userid");
    var button_accept = $(this);
    var button_decline = $(this).siblings("button.declineevent");
    button_accept.remove();
    button_decline.html("nicht mehr teilnehmen");

    $.post("../event/update/member", 
    {
      eventid: eventid,
      memberid: memberid,
      status: "attending"
    });
  });
  
  /**
   * Event absagen
   */
  $("button.declineevent").on("click", function()
  {
    var eventid = $(this).attr("eventid");
    var memberid = $("div#userid").attr("userid");
    var tr = $(this).parents("tr");
    tr.fadeOut();

    $.post("../event/update/member", 
    {
      eventid: eventid,
      memberid: memberid,
      status: "none"
    });
  });

});
