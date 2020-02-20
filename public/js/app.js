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
      if (value === 0) {
        circle.setText('');
      } else {
        circle.setText(value);
      }
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

  total.value = (days.value * goal.value);
  average.value = (productivity.value / days.value);
  document.querySelector("#sim-deficit").value = (total.value - productivity.value);
  document.querySelector("#sim-progress").value = ((average.value / goal.value) * 100) + '%';
}