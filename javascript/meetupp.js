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
  
    // Scrolleiste einblenden
    if (numpages > 1)
    {
      var scrollbuttons = "";
      for (var i=0; i < numpages; i++)
      {
        if (activepage == i)
        {
          scrollbuttons += "<span><a class='internal' href='javascript:page("+i+")'>&#9676;</a></span>";
        }
        else
        {
          scrollbuttons += "<span><a class='internal' href='javascript:page("+i+")'>&#9675;</a></span>";
        }        
      }      
      $("#window").append("<div id=\"scroll\">" + scrollbuttons + "</div>");
      $("#scroll").width(windowwidth + "px");
    }

    // Mit Seite 1 initialisieren
    page(0);

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

  $(".deleteicon b").on("click", function(e) {
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

    $("#window").scrollTop(0);
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

  $("#eventbutton_members_prev").on("click", function()
  {   
    pagePrev();
    $("#window").scrollTop($("ul #eventlocations > li.selected").offset().top - 100);
  });
  
  $("#eventbutton_location_prev").on("click", function()
  {   
    pagePrev();
    $("#window").scrollTop(0);
  });

  /**
   * Basisdaten updaten
   */
  $("#eventbutton_basedata_next").on("click", function()
  {   
    var eventid = $("#eventid").attr("eventid");
    var title = $("#eventname").val();

    var from_hour = $("select#from_hour").val();
    var from_minute = $("select#from_minute").val();
    var from_day = $("select#from_day").val();
    var from_month = $("select#from_month").val();
    var from_year = $("select#from_year").val();
    var to_hour = $("select#to_hour").val();
    var to_minute = $("select#to_minute").val();
    var to_day = $("select#to_day").val();
    var to_month = $("select#to_month").val();
    var to_year = $("select#to_year").val();
        
    $.post("../event/update/basedata", 
    {
      eventid: eventid,
      title: title,
      from_hour: from_hour,
      from_minute: from_minute,
      from_day: from_day,
      from_month: from_month,
      from_year: from_year,
      to_hour: to_hour,
      to_minute: to_minute,
      to_day: to_day,
      to_month: to_month,
      to_year: to_year
    }, function(data) {
      if (data == "okay")
      {
        pageNext();     
        if ($("ul #eventlocations > li.selected").offset() != null)
        {
          $("#window").scrollTop($("ul #eventlocations > li.selected").offset().top - 100);      
        }
      }
      else
      {
        $("#checkresult").html(data); 
      }
      console.log(data);  
    });
  });

 
  /**
   * An Event teilnehmen
   */
  $(".acceptevent").on("click", function()
  {
    var item = $(this).parent("li").removeClass("invited");    
    console.log(item);
    
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
    }, 
    function(data) {
      console.log(data);
    });        

  });
  
  /**
   * Event absagen
   */
  $(".declineevent").on("click", function()
  {
    var eventid = $(this).attr("eventid");
    var memberid = $("div#userid").attr("userid");
    var tr = $(this).parent("li");
    tr.fadeOut();

    $.post("../event/update/member", 
    {
      eventid: eventid,
      memberid: memberid,
      status: "none"
    });
  });

});
