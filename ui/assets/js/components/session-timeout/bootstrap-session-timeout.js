!function (a) {
    "use strict";
  
    a.sessionTimeout = function (b) {
      function c() {
        if (!n) {
          a.ajax({
            type: i.ajaxType,
            url: i.keepAliveUrl,
            data: i.ajaxData
          });
          n = true;
          setTimeout(function () {
            n = false;
          }, i.keepAliveInterval);
        }
      }
      function d() {
        clearTimeout(g);
        if (i.countdownMessage || i.countdownBar) {
          f("session", true);
        }
        if ("function" == typeof i.onStart) {
          i.onStart(i);
        }
        if (i.keepAlive) {
          c();
        }
        g = setTimeout(function () {
          if ("function" != typeof i.onWarn) {
            a("#session-timeout-dialog").modal("show");
          } else {
            i.onWarn(i);
          }
          e();
        }, i.warnAfter);
      }
      function e() {
        clearTimeout(g);
        if (!(a("#session-timeout-dialog").hasClass("in") || !i.countdownMessage && !i.countdownBar)) {
          f("dialog", true);
        }
        g = setTimeout(function () {
          if ("function" != typeof i.onRedir) {
            window.location = i.redirUrl;
          } else {
            i.onRedir(i);
          }
        }, i.redirAfter - i.warnAfter);
      }
      function f(b, c) {
        clearTimeout(j.timer);
        if ("dialog" === b && c) {
          j.timeLeft = Math.floor((i.redirAfter - i.warnAfter) / 1e3);
        } else if ("session" === b && c) {
          j.timeLeft = Math.floor(i.redirAfter / 1e3);
        }
        if (i.countdownBar && "dialog" === b) {
          j.percentLeft = Math.floor(j.timeLeft / ((i.redirAfter - i.warnAfter) / 1e3) * 100);
        } else if (i.countdownBar && "session" === b) {
          j.percentLeft = Math.floor(j.timeLeft / (i.redirAfter / 1e3) * 100);
        }
        var d = a(".countdown-holder");
        var e = j.timeLeft >= 0 ? j.timeLeft : 0;
        if (i.countdownSmart) {
          var g = Math.floor(e / 60);
          var h = e % 60;
          var k = g > 0 ? g + "m" : "";
          if (k.length > 0) {
            k += " ";
          }
          k += h + "s";
          d.text(k);
        } else {
          d.text(e + "s");
        }
        if (i.countdownBar) {
          a(".countdown-bar").css("width", j.percentLeft + "%");
        }
        j.timeLeft = j.timeLeft - 1;
        j.timer = setTimeout(function () {
          f(b);
        }, 1e3);
      }
      var g;
      var h = {
        title: "Your Session is About to Expire!",
        message: "Your session is about to expire.",
        logoutButton: "Logout",
        keepAliveButton: "Stay",
        keepAliveUrl: "/keep-alive",
        ajaxType: "POST",
        ajaxData: "",
        redirUrl: "/timed-out",
        logoutUrl: "/log-out",
        warnAfter: 9e5,
        redirAfter: 12e5,
        keepAliveInterval: 5e3,
        keepAlive: true,
        ignoreUserActivity: false,
        onStart: false,
        onWarn: false,
        onRedir: false,
        countdownMessage: false,
        countdownBar: false,
        countdownSmart: false
      };
      var i = h;
      var j = {};
      if (b) {
        i = a.extend(h, b);
      }
      if (i.warnAfter >= i.redirAfter) {
        console.error("Bootstrap-session-timeout plugin is miss-configured. Option \"redirAfter\" must be equal or greater than \"warnAfter\".");
        return false;
      }
      if ("function" != typeof i.onWarn) {
        var k = i.countdownMessage ? "<p>" + i.countdownMessage.replace(/{timer}/g, "<span class=\"countdown-holder\"></span>") + "</p>" : "";
        var l = i.countdownBar ? "<div class=\"progress mb-3 mt-4\">                   <div class=\"progress-bar bg-secondary countdown-bar active  progress-bar-striped progress-bar-animated\" role=\"progressbar\" style=\"min-width: 15px; width: 100%;\">                                        </div>                 </div>" : "";
        a("body").append("<div class=\"modal fade\" id=\"session-timeout-dialog\">               <div class=\"modal-dialog  modal-dialog-centered\">                 <div class=\"modal-content\">                                   <div class=\"modal-body\">                     <p>" + i.message + "</p>                     " + k + "                     " + l + "                   </div>                   <div class=\"modal-footer justify-content-center\">                     <button id=\"session-timeout-dialog-logout\" type=\"button\" class=\"btn btn-dark mb-0 mt-0\">" + i.logoutButton + "</button>                     <button id=\"session-timeout-dialog-keepalive\" type=\"button\" class=\"btn btn-primary mb-0 mt-0\" data-dismiss=\"modal\">" + i.keepAliveButton + "</button>                   </div>                 </div>               </div>              </div>");
        a("#session-timeout-dialog-logout").on("click", function () {
          window.location = i.logoutUrl;
        });
        a("#session-timeout-dialog").on("hide.bs.modal", function () {
          d();
        });
      }
      if (!i.ignoreUserActivity) {
        var m = [-1, -1];
        a(document).on("keyup mouseup mousemove touchend touchmove", function (b) {
          if ("mousemove" === b.type) {
            if (b.clientX === m[0] && b.clientY === m[1]) {
              return;
            }
            m[0] = b.clientX;
            m[1] = b.clientY;
          }
          d();
          if (a("#session-timeout-dialog").length > 0 && a("#session-timeout-dialog").data("bs.modal") && a("#session-timeout-dialog").data("bs.modal").isShown) {
            a("#session-timeout-dialog").modal("hide");
            a("body").removeClass("modal-open");
            a("div.modal-backdrop").remove();
          }
        });
      }
      var n = false;
      d();
    };
  }(jQuery);