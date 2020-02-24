// Hambuger script
// animated menu / hamburger 
$(document).ready(function () {
    $('.first-button').on('click', function() {
        $('.animated-icon1').toggleClass('open');
    });
    if (getCookie("toggled") == "NaN") document.cookie = "toggled=1";
    if (isToggled() < 0) {
        $("#wrapper").toggleClass("toggled");
        $('.animated-icon1').toggleClass('open');
    }
}); // end


// AJAX function 
function request(action, postData, success) {
    var r = new XMLHttpRequest();
    r.open("POST", action);
    r.setRequestHeader("Content-Type", "application/json");
    r.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
    r.onreadystatechange = success;
    requestObject = r;
    r.send(postData);
} // end

// Polling callback
function Poll(getPollUrl, dequeuePollUrl, pollReceiver) {
  request(getPollUrl, JSON.stringify({ receiver: pollReceiver }), function() {
    if (this.readyState == 4 && this.status == 200) {
      var template = document.querySelector("#toast-template");
      var polls = JSON.parse(this.responseText);

      for (let i = 0; i < polls.length; i++) {
        const poll = polls[i];
        
        // If the toast id exists, continue to next poll
        if (document.querySelector("#toast-" + poll["poll_id"]) != null) continue;

        var toast = template.cloneNode(true);
        $(toast).insertAfter(template);
        toast.id = "toast-" + poll["poll_id"];
        $('#' + toast.id + " .toast-title").html(poll["poll_sender"]);
        updateTimeSince(toast.id, poll["poll_time"]);
        $('#' + toast.id + " .toast-body").html(poll["poll_message"]);
        $('#' + toast.id + " .close").on("click", function() {
          request(dequeuePollUrl, JSON.stringify({ id: poll["poll_id"] }), function() {
            if (this.readyState == 4 && this.status == 200) $("#toast-" + poll["poll_id"]).remove();
          });
        });
        $('#' + toast.id).toast('show');
      }
    }
  });
  // Refresh every 5sec
  setTimeout(function() { Poll(getPollUrl, dequeuePollUrl, pollReceiver) }, 5000);
}

function updateTimeSince(elementId, pollTime) {
  if ($('#' + elementId) == null) return;
  $('#' + elementId + " .toast-time").html(timeSince(pollTime));
  // Update every 30sec
  setTimeout(function() { updateTimeSince(elementId, pollTime) }, 30000);
}

// Menu Toggle Script
// collapse menu / sidebar
$("#menu-toggle").click(function(e) {
    var currentToggle = isToggled();
    document.cookie = "toggled=" + (currentToggle * -1).toString();
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function isToggled() {
    return parseInt(getCookie("toggled"));
} // end


// Progress bar in dashboard
// progressbar.js
function createCircle(elementId, trailColor, strokeColor, value, max) {
  var bar = new ProgressBar.Circle(document.getElementById(elementId), {
    color: trailColor,

    // This has to be the same size as the maximum width to
    // prevent clipping
    strokeWidth: 4,
    trailWidth: 1,
    easing: 'easeInOut',
    duration: 1400,
    text: {
      autoStyleContainer: false
    },
    from: { color: trailColor, width: 1 },
    to: { color: strokeColor, width: 4 },

    // Set default step function for all animate calls
    step: function(state, circle) {
      circle.path.setAttribute('stroke', state.color);
      circle.path.setAttribute('stroke-width', state.width);

      var value = Math.round(circle.value() * max);
      circle.setText(value);
    }
  });
  bar.text.style.fontFamily = '"Open sans", Helvetica, sans-serif';
  bar.text.style.fontSize = '2rem';

  bar.animate(value / max);  // Number from 0.0 to 1.0
  // end
}

// Lazy fill progress bar in top resource card
function lazyFill(selector, width) {
  var className = "";
  if (width < 80) {
    className = "pb-color-f";
  } else if (width >= 80 && width < 90) {
    className = "pb-color-sp";
  } else {
    className = "pb-color-p";
  }
  $(selector).waypoint(function(direction) { document.querySelector(selector).style.width = width + '%'; }, { offset: '100%' });
  $(selector).addClass(className);
}

function lazyFillBonus(selector) {
  var className = "pb-color-bonus";
  $(selector).waypoint(function(direction) { document.querySelector(selector).style.width = '100%'; }, { offset: '100%' });
  $(selector).addClass(className);
}

// Datepicker for history page
$('#history-wrapper .input-daterange').datepicker({
  clearBtn: true,
  autoclose: true,
  todayHighlight: true
});

function recalculateProductivity() {
  var productivity = document.querySelector("#sim-productivity");
  var days = document.querySelector("#sim-days");
  var goal = document.querySelector("#sim-goal");
  var total = document.querySelector("#sim-total");
  var average = document.querySelector("#sim-average");
  var progress = document.querySelector("#sim-progress");

  total.value = parseFloat(days.value * goal.value).toFixed(2);
  average.value = parseFloat(productivity.value / days.value).toFixed(2);
  document.querySelector("#sim-deficit").value = parseFloat(total.value - productivity.value).toFixed(2);
  var progressValue = parseFloat((average.value / goal.value) * 100).toFixed(2);
  progress.value = progressValue + '%';

  progress.classList.remove("prog-f");
  progress.classList.remove("prog-sp");
  progress.classList.remove("prog-p");
  if (progressValue < 80) {
    progress.classList.add("prog-f");
  } else if (progressValue >= 80 && progressValue < 90) {
    progress.classList.add("prog-sp");
  } else {
    progress.classList.add("prog-p");
  }
}

// Toast real time (time) 
function timeSince(date) {

  var seconds = Math.floor((new Date() - date) / 1000);

  var interval = Math.floor(seconds / 31536000);

  if (interval > 1) {
    return interval + " years ago";
  } else if (interval == 1) {
    return interval + " year ago";
  }
  interval = Math.floor(seconds / 2592000);
  if (interval > 1) {
    return interval + " months ago";
  } else if (interval == 1) {
    return interval + " month ago";
  }
  interval = Math.floor(seconds / 86400);
  if (interval > 1) {
    return interval + " days ago";
  } else if (interval == 1) {
    return interval + " day ago";
  }
  interval = Math.floor(seconds / 3600);
  if (interval > 1) {
    return interval + " hours ago";
  } else if (interval == 1) {
    return interval + " hour ago";
  }
  interval = Math.floor(seconds / 60);
  if (interval > 1) {
    return interval + " minutes ago";
  } else if (interval == 1) {
    return interval + " minute ago";
  }
  return Math.floor(seconds) + " seconds ago";
}