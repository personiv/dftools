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

  createCircle("ovTotal1", "#5cb85c", "#5cb85c", 18, 21);
  createCircle("ovTotal2", "#f0ad4e", "#f0ad4e", 2, 21);
  createCircle("ovTotal3", "#5bc0de", "#5bc0de", 1, 21);