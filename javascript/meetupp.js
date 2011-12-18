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

  /**
   * Nachricht senden und an die Nachrichtenleiste anhängen
   */
  $("#sendmessage").on("click", function() {
    var receiver = $("#receiver").val();
    var messagebody = $("#messagebox").val();
    
    $.post("../../mail/send",
    {
      "receiver": receiver,
      "message": messagebody
    },
    function (data) {
      if (data == "okay")
      {
        var Monat = new Array("Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
        var now = new Date();
        var sendtime = now.getDate() + ". " + Monat[now.getMonth()];
        var sender = $("#sendername").val();
        var senderimage = $("#senderimage").val();
        messagebody = messagebody.replace(/\n/g, '<br />');
        messagebody = messagebody.replace(/\r/g, '<br />');
        $("#messages").append(
          "<tr><td width='64'></td><td class='sent'><b>" + sender + "</b> am " + sendtime + "<br/><p>" + messagebody + "</p></td><td width='64px'><img width='64' src='" + senderimage + "'/></td></tr>" + 
          "<tr><td colspan='3'><hr class='messageseparator'></td></tr>"
        ); 
      }
    });
  });

  /**
   * Sendet eine Nachricht vom Posteingang aus
   */
  $("#sendmessage_inbox").on("click", function() {
    var receiver = $("#receiver").val();
    var messagebody = $("#messagebox").val();
    
    $.post("../../mail/send",
    {
      "receiver": receiver,
      "message": messagebody
    },
    function (data) {
      if (data == "okay")
      {
        $("#messagestatus").html("<b>Nachricht gesendet</b>");
        $("#messagebox").val("");
      }
    });
  });

  $(".deleteicon a").on("click", function(e) {
    e.preventDefault();
    
    var row = $(this).parents("tr");
    
    $.post($(this).attr("href"),
    function (data) {
      if (data == "okay")
      {
        row.fadeOut();
        row.next().fadeOut();
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
