var SessionTimeout = function () {
    var e = function () {
      $.sessionTimeout({
        title: "Session Timeout Notification",
        message: "Your session is about to expire.",
        keepAliveUrl: "",
        redirUrl: "../lockscreen.php",
        logoutUrl: "logout.php",
        warnAfter: 200,
        redirAfter: 21e3,
        ignoreUserActivity: false,
        countdownMessage: "Redirecting in {timer}.",
        countdownBar: true
      });
    };
    return {
      init: function () {
        e();
      }
    };
  }();
  jQuery(document).ready(function () {
    SessionTimeout.init();
  });