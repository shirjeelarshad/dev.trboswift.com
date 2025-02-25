/*
 *
 * Author: Md Nuralam
 * Author URL: http://www.premiumpress.com
 * Version: 10.x
 *
 * THIS FILE WILL BE UPDATED WITH EVERY UPDATE
 * IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
 *
 * http://codex.wordpress.org/Child_Themes
 */

jQuery(window).on("load", function () {
  jQuery(window).on("scroll", function () {
    if (jQuery(".previewmode").length) {
    } else {
      if (jQuery(this).scrollTop() > 150) {
        if (jQuery(".innerpage .has-sticky .elementor_topmenu").length) {
          jQuery(".innerpage .has-sticky .elementor_topmenu").attr(
            "style",
            "display: none !important"
          )
        }

        jQuery(".has-sticky").addClass("sticky")
      } else {
        if (jQuery(".innerpage .has-sticky .elementor_topmenu").length) {
          jQuery(".innerpage .has-sticky .elementor_topmenu").attr(
            "style",
            "display: block !important"
          )
        }

        jQuery(".has-sticky").removeClass("sticky")
      }
    }
  })
})

function checkSize() {
  var wins = jQuery(window).width()

  if (wins < 767) {
    jQuery(".has-sticky .elementor_mainmenu").removeClass("fixed-scroll")
    jQuery(".filters_sidebar .filter-content")
      .addClass("collapse collapsexx")
      .removeClass("show")
  } else if (wins > 767) {
    jQuery(".bg-gradient-smallx")
      .removeClass("bg-gradient-smallx")
      .addClass("bg-gradient-small")

    jQuery(".collapsexx").addClass("collapse show").removeClass("collapsexx")
  }
}

jQuery(document).ready(function () {
  "use strict"

  checkSize()

  jQuery('[data-toggle="tooltip"]').tooltip()

  jQuery(window).resize(checkSize)

  /* MOBILE MENU	*/
  jQuery(".menu-toggle").click(function (e) {
    e.preventDefault()
    jQuery("#wrapper").toggleClass("toggled")
  })

  /*  PATTERNS */
  jQuery("section .bg-pattern").each(function () {
    jQuery(this).closest("section").addClass("with-pattern")
  })

  /*  FAVS	   */
  jQuery(document).on("click", ".favs_add", function (e) {
    var btnbit = jQuery(this)

    jQuery(this)
      .removeClass("btn-icon")
      .html("<i class='fas fa-spinner fa-spin'></i>")

    jQuery.ajax({
      type: "POST",
      url: ajax_site_url,
      dataType: "json",
      data: {
        action: "favs",
        pid: jQuery(this).attr("data-pid"),
      },
      success: function (response) {
        if (response.status == "add") {
          if (
            jQuery(btnbit).attr("data-text") == 1 &&
            jQuery(btnbit).attr("data-icon") == 0
          ) {
            jQuery(btnbit).html(jQuery(btnbit).attr("data-textadd"))
          } else if (jQuery(btnbit).attr("data-text") == 1) {
            jQuery(btnbit).html(
              '<i class="fa fa-heart"></i> ' +
                jQuery(btnbit).attr("data-textadd")
            )
          } else {
            jQuery(btnbit).html('<i class="fa fa-heart"></i>')
          }
        } else if (response.status == "remove") {
          if (
            jQuery(btnbit).attr("data-text") == 1 &&
            jQuery(btnbit).attr("data-icon") == 0
          ) {
            jQuery(btnbit).html(jQuery(btnbit).attr("data-textremove"))
          } else if (jQuery(btnbit).attr("data-text") == 1) {
            jQuery(btnbit).html(
              '<i class="fa fa-times"></i> ' +
                jQuery(btnbit).attr("data-textremove")
            )
          } else {
            jQuery(btnbit).html('<i class="fa fa-times"></i>')
          }
        } else if (response.status == "login") {
          jQuery(btnbit).html('<i class="fa fa-user"></i>')
        } else {
        }
      },
      error: function (e) {
        console.log("error getting search results")
      },
    })
  })

  /*  SUBSCRIBE	*/
  jQuery(document).on("click", ".subscribe_add", function (e) {
    var btnbit = jQuery(this)

    jQuery(this)
      .removeClass("btn-icon")
      .html("<i class='fas fa-spinner fa-spin'></i>")

    console.log(btnbit)

    jQuery.ajax({
      type: "POST",
      url: ajax_site_url,
      dataType: "json",
      data: {
        action: "subscribe",
        uid: jQuery(this).attr("data-uid"),
      },
      success: function (response) {
        if (response.status == "add") {
          if (
            jQuery(btnbit).attr("data-text") == 1 &&
            jQuery(btnbit).attr("data-icon") == 0
          ) {
            jQuery(btnbit).html(jQuery(btnbit).attr("data-textadd"))
          } else if (jQuery(btnbit).attr("data-text") == 1) {
            jQuery(btnbit).html(
              '<i class="fa fa-check"></i> ' +
                jQuery(btnbit).attr("data-textadd")
            )
          } else {
            jQuery(btnbit).html('<i class="fa fa-check"></i>')
          }
        } else if (response.status == "remove") {
          if (
            jQuery(btnbit).attr("data-text") == 1 &&
            jQuery(btnbit).attr("data-icon") == 0
          ) {
            jQuery(btnbit).html(jQuery(btnbit).attr("data-textremove"))
          } else if (jQuery(btnbit).attr("data-text") == 1) {
            jQuery(btnbit).html(
              '<i class="fa fa-times"></i> ' +
                jQuery(btnbit).attr("data-textremove")
            )
          } else {
            jQuery(btnbit).html('<i class="fa fa-times"></i>')
          }
        } else if (response.status == "login") {
          jQuery(btnbit).html('<i class="fa fa-user"></i>')
        } else {
        }
      },
      error: function (e) {
        console.log("error getting search results")
      },
    })
  })

  /*  IMAGRE BLOCK BUTTONS */
  jQuery("figcaption button").click(function (e) {
    e.preventDefault()
    window.location.href = jQuery(this).attr("data-link")
  })

  /* WOW ANIMATIONS */
  jQuery(".block-cat-icon, .block-cat-text, .block-cat-faq").each(function () {
    jQuery(this)
      .find("i")
      .addClass("wow fadeInUp")
      .attr("data-wow-delay", "0.1s")
    jQuery(this)
      .find("h2")
      .addClass("wow fadeInUp")
      .attr("data-wow-delay", "0.2s")
    jQuery(this)
      .find("h5")
      .addClass("wow fadeInUp")
      .attr("data-wow-delay", "0.2s")

    jQuery(this)
      .find("p")
      .addClass("wow fadeInUp")
      .attr("data-wow-delay", "0.4s")

    jQuery(this)
      .find(".btn")
      .addClass("wow fadeInUp")
      .attr("data-wow-delay", "0.6s")

    jQuery(this)
      .find("img")
      .addClass("wow fadeInUp")
      .attr("data-wow-delay", "0.8s")
  })

  /*  WOW ANIMATION */
  new WOW().init()

  /*  CUSTOM BACKGROUNDS */
  var a = jQuery(".bg-image")
  a.each(function (a) {
    if (jQuery(this).attr("data-bg"))
      jQuery(this).css(
        "background-image",
        "url(" + jQuery(this).data("bg") + ")"
      )
  })

  /*  CUSTOM PATTERNS */
  var a = jQuery(".bg-pattern")
  a.each(function (a) {
    if (jQuery(this).attr("data-bg"))
      jQuery(this).css(
        "background-image",
        "url(" + jQuery(this).data("bg") + ")"
      )
  })

  /*  CUSTOM PATTERNS */
  var a = jQuery(".bg-pattern-small")
  a.each(function (a) {
    if (jQuery(this).attr("data-bg"))
      jQuery(this).css(
        "background-image",
        "url(" + jQuery(this).data("bg") + ")"
      )
  })

  /* SCROLL TOO */
  if (jQuery(".scroll-init").lenght > 0) {
    jQuery(".scroll-init div").singlePageNav({
      filter: ":not(.external)",
      updateHash: false,
      offset: 250,
      threshold: 250,
      speed: 1200,
      currentClass: "active",
    })
  }

  jQuery(".custom-scroll-link").on("click", function () {
    var a = 150 + jQuery(".scroll-nav-wrapper").height()
    if (
      location.pathname.replace(/^\//, "") ===
        this.pathname.replace(/^\//, "") ||
      location.hostname === this.hostname
    ) {
      var b = jQuery(this.hash)
      b = b.length ? b : jQuery("[name=" + this.hash.slice(1) + "]")
      if (b.length) {
        jQuery("html,body").animate(
          {
            scrollTop: b.offset().top - a,
          },
          {
            queue: false,
            duration: 1200,
            easing: "easeInOutExpo",
          }
        )
        return false
      }
    }
  })

  /* lazy load */
  var myLazyLoad = new LazyLoad({
    elements_selector: ".lazy",
  })

  /*  fade in */
  var IE = "\v" == "v"
  jQuery("#back-top").hide()
  jQuery(window).scroll(function () {
    if (!IE) {
      if (jQuery(this).scrollTop() > 100) {
        jQuery("#back-top").fadeIn()
      } else {
        jQuery("#back-top").fadeOut()
      }
    } else {
      if (jQuery(this).scrollTop() > 100) {
        jQuery("#back-top").show()
      } else {
        jQuery("#back-top").hide()
      }
    }
  })

  /*  scroll body to 0px on click */
  jQuery("#back-top a").click(function () {
    jQuery("body,html").animate(
      {
        scrollTop: 0,
      },
      800
    )
    return false
  })

  /*  PAYMENT MODAL */
  jQuery(".payment-modal-close, .payment-modal-wrap-overlay").on(
    "click",
    function (e) {
      jQuery(".payment-modal-wrap").fadeOut(400)
    }
  )

  /*  LOGIN MODAL */
  jQuery(".login-modal-close, .login-modal-wrap-overlay").on(
    "click",
    function (e) {
      jQuery(".login-modal-wrap").fadeOut(400)
    }
  )

  /*  MESSAGE MODAL */
  jQuery(".msg-modal-close, .msg-modal-wrap-overlay").on("click", function (e) {
    jQuery(".msg-modal-wrap").fadeOut(400)
  })

  /*  MESSAGE MODAL */
  jQuery(".filter-modal-close, .filter-modal-wrap-overlay").on(
    "click",
    function (e) {
      jQuery(".filter-modal-wrap").fadeOut(400)
    }
  )

  /*EXTRA MODAL */
  jQuery(".video-modal-close, .video-modal-wrap-overlay").on(
    "click",
    function (e) {
      jQuery(".video-modal-wrap").fadeOut(400)
    }
  )

  /*EXTRA MODAL */
  jQuery(".upgrade-modal-close, .upgrade-modal-wrap-overlay, .upgradebtn").on(
    "click",
    function (e) {
      jQuery(".upgrade-modal-wrap").fadeOut(400)
    }
  )

  /*  FINALL TRIGGER RESIZE FOR LOADERS ETC */
  tinyScroll()
  jQuery(".btn.next, .btn.prev").on("click", function (e) {
    tinyScroll()
  })
})

jQuery(window).bind("load", function () {
  setTimeout(function () {
    /*  LOAD IN THE SIDEBAR */
    jQuery("#sidebar-wrapper").show()
  }, 7000)
})

/* =============================================================================
	FUNCTION TO SCROLL 1PX AND TRIGGER THE LAZY LOAD
========================================================================== */

function isValidEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/
  return regex.test(email)
}

function processRegister() {
  // CHECK FOR RELOAD VALUE
  var reloadme = 0
  if (jQuery("#reloadform").length > 0) {
    reloadme = 1
  }

  var extra = ""
  if (jQuery("#extra").length > 0) {
    extra = jQuery("#extra").val()
  }

  jQuery.ajax({
    type: "POST",
    url: ajax_site_url,
    data: {
      action: "load_register_form",
    },
    success: function (response) {
      jQuery(".login-modal-wrap").fadeIn(400)

      jQuery("#ajax-login-form").html(response)

      if (reloadme == 1) {
        jQuery("#form_user_register").append(
          '<input type="hidden" name="reload" id="reloadform" value="1">'
        )
      }

      if (extra != "") {
        jQuery("#form_user_register").append(
          '<input type="hidden" name="extra" id="extra" value="' + extra + '">'
        )
      }
    },
    error: function (e) {
      console.log(e)
    },
  })
}

function processLogin(reloadme, extra) {
  // CHECK FOR RELOAD VALUE
  if (jQuery("#reloadform").length > 0) {
    reloadme = 1
  }

  jQuery.ajax({
    type: "POST",
    url: ajax_site_url,
    data: {
      action: "load_login_form",
    },
    success: function (response) {
      jQuery(".login-modal-wrap").fadeIn(400)
      jQuery("#ajax-login-form").html(response)

      // CHECK FOR REDIRECT
      if (reloadme == 1) {
        jQuery("#form_user_login").append(
          '<input type="hidden" name="reload" id="reloadform" value="1">'
        )
      }

      if (extra != "") {
        jQuery("#form_user_login").append(
          '<input type="hidden" name="extra" id="extra" value="' + extra + '">'
        )
      }
    },
    error: function (e) {
      console.log(e)
    },
  })
}

function processUpgrade() {
  // CHECK FOR RELOAD VALUE
  if (jQuery("#reloadform").length > 0) {
    reloadme = 1
  }

  jQuery.ajax({
    type: "POST",
    url: ajax_site_url,
    data: {
      action: "load_upgrade_form",
    },
    success: function (response) {
      jQuery(".upgrade-modal-wrap").fadeIn(400)
      jQuery("#ajax-upgrade-form").html(response)
    },
    error: function (e) {
      console.log(e)
    },
  })
}

function processCredit() {
  // CHECK FOR RELOAD VALUE
  if (jQuery("#reloadform").length > 0) {
    reloadme = 1
  }

  jQuery.ajax({
    type: "POST",
    url: ajax_site_url,
    data: {
      action: "load_credit_form",
    },
    success: function (response) {
      jQuery(".upgrade-modal-wrap").fadeIn(400)
      jQuery("#ajax-upgrade-form").html(response)

      UpdatePrices()
    },
    error: function (e) {
      console.log(e)
    },
  })
}

function processMessageSingle(uid, pid) {
  jQuery.ajax({
    type: "POST",
    url: ajax_site_url,
    data: {
      action: "load_msg_form",
      uid: uid,
      pid: pid,
    },
    success: function (response) {
      jQuery("#ajax-msg-form").html(response)
      jQuery(".msg-modal-wrap").fadeIn(400)
      jQuery(".userf").val(uid)
      jQuery(".userfieldmsg").hide()
    },
    error: function (e) {
      console.log(e)
    },
  })
}

function processMessage(uid) {
  jQuery.ajax({
    type: "POST",
    url: ajax_site_url,
    data: {
      action: "load_msg_form",
      uid: uid,
    },
    success: function (response) {
      jQuery("#ajax-msg-form").html(response)
      jQuery(".msg-modal-wrap").fadeIn(400)
      jQuery(".userf").val(uid)
      jQuery(".userfieldmsg").hide()
    },
    error: function (e) {
      console.log(e)
    },
  })
}

function processFilterbox(fd, taxdata) {
  jQuery.ajax({
    type: "POST",
    url: ajax_site_url,
    data: {
      action: "load_search_filter",
      fid: fd,
      showtax: taxdata,
    },
    success: function (response) {
      jQuery("#ajax-filter-form").html(response)
      jQuery(".filter-modal-wrap").fadeIn(400)
    },
    error: function (e) {
      console.log(e)
    },
  })
}

/* =============================================================================
	FUNCTION TO SCROLL 1PX AND TRIGGER THE LAZY LOAD
========================================================================== */

function tinyScroll() {
  window.scrollBy(0, 1)
}

function TogglePass(id) {
  if (jQuery("#" + id).prop("type") == "text") {
    jQuery("#" + id).prop("type", "password")
  } else {
    jQuery("#" + id).prop("type", "text")
  }
}

/* =============================================================================
 FORM VALIDATION
  ========================================================================== */
function js_validate_fields(text) {
  var canContinue = true

  jQuery(".required-active").each(function (i, obj) {
    jQuery(obj).removeClass("required-active")
  })

  jQuery(".required-field").each(function (i, obj) {
    if (jQuery(obj).val() == "") {
      jQuery(obj).addClass("required-active").focus()
      canContinue = false
    }
  })

  jQuery(".val-numeric").each(function (i, obj) {
    if (jQuery(obj).val() === "") {
      jQuery(obj).addClass("required-active").focus()
      canContinue = false
    }
  })

  jQuery(".val-notzero").each(function (i, obj) {
    if (jQuery(obj).val() === "0") {
      jQuery(obj).addClass("required-active").focus()
      canContinue = false
    }
  })
  if (canContinue) {
    return true
  } else {
    alert(text)
    return false
  }
}

jQuery(document).on("input", ".numericonly, .val-numeric", function () {
  this.value = this.value.replace(/[^0-9\.]/g, "")
})

jQuery(document).on("input", ".val-nospaces", function () {
  this.value = this.value.replace(/[^a-z0-9\s]/gi, "").replace(/[_\s]/g, "-")
})
