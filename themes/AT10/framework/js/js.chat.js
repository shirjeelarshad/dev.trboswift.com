!function(t) {
    "use strict";
    t.fn.pptChat = function(o) {
        var p, e = t.extend(!0, {}, {
            button: {
                position: "right",
                style: 1,
                src: '',
                effect: 1,
                color: "#26c281",
                notificationNumber: "1",
                speechBubble: "",
                pulseEffect: !0,
                text: {
                    title: "", //Need help? Chat with us
                    description: "",
                    status: "",
                    offlineText: ""
                },
                link: {
                    desktop: !1,
                    mobile: !1
                },
                day: {
                    sunday: !1,
                    monday: !1,
                    tuesday: !1,
                    wednesday: !1,
                    thursday: !1,
                    friday: !1,
                    saturday: !1
                },
                delay: !0
            },
            popup: {
                automaticOpen: !1,
                outsideClickClosePopup: !0,
                effect: 1,
                color: "#26c281",
                header: {
                    title: "",
                    description: ""
                },
                persons: [],
                personsSettings: {
                    avatar: {
                        src: '',
                        color: "#26c281"
                    },
                    text: {
                        title: "",
                        description: "",
                        status: "",
						count: 0,
                        offlineText: ""
                    },
                    link: {
                        desktop: !1,
                        mobile: !1
                    },
                    day: {
                        sunday: !1,
                        monday: !1,
                        tuesday: !1,
                        wednesday: !1,
                        thursday: !1,
                        friday: !1,
                        saturday: !1
                    }
                }
            },
            sound: "",
            changeBrowserTitle: "",
            cookie: !1,
            timezone: !1,
            onLoad: function() {},
            onClick: function() {},
            onPopupOpen: function() {},
            onPopupClose: function() {}
        }, o);
		
        return window.moment && (p = !1 !== e.timezone ? moment().tz(e.timezone) : moment().tz(moment.tz.guess())), 
		
        this.each(function() {
            var o = this;
            1 ==2 && (e.button.pulseEffect = !1, 
            e.button.notificationNumber = !1, e.button.speechBubble = !1, e.button.delay = !1, 
            e.sound = !1), e.onLoad && "function" == typeof e.onLoad && e.onLoad.call(this), 
            "right" !== e.button.position && "left" !== e.button.position && (e.button.speechBubble = !1), 
            t(o).addClass("czm-chat-support czm-chat-support-" + e.button.style).prepend('<div class="czm-button"></div>'), 
            "right" == e.button.position || "left" == e.button.position ? (t(o).addClass("czm-fixed"), 
            "right" == e.button.position ? t(o).addClass("czm-right") : "left" == e.button.position && t(o).addClass("czm-left"), 
            !1 !== e.button.delay ? (2 != e.button.effect && 4 != e.button.effect && 5 != e.button.effect && 7 != e.button.effect || ("right" == e.button.position ? e.button.effect = e.button.effect + "__1" : "left" == e.button.position && (e.button.effect = e.button.effect + "__2")), 
            t(o).addClass("czm-chat-support-show"), t(".czm-button", o).addClass("animate__animated animate__" + e.button.effect), 
            setInterval(function() {
                t(".czm-button", o).removeClass("animate__animated animate__" + e.button.effect);
            }, 1e3)) : t(o).addClass("czm-chat-support-show")) : t(o).addClass("czm-chat-support-show");
            var n, s = !0;
            if (!1 !== e.button.link.desktop || !1 !== e.button.link.mobile ? window.moment && (0 == e.button.day[p.format("dddd").toLowerCase()] || null == e.button.day[p.format("dddd").toLowerCase()] ? s = !1 : 0 == moment(p.format("HH:mm:ss"), "HH:mm:ss").isBetween(moment(e.button.day[p.format("dddd").toLowerCase()].split("-")[0] + ":00", "HH:mm:ss"), moment(e.button.day[p.format("dddd").toLowerCase()].split("-")[1] + ":59", "HH:mm:ss")) && (s = !1)) : 0 == e.popup.persons.length && (s = !1), 
            t(".czm-button", o).css("background-color", e.button.color), t(".czm-button", o).append('<div class="czm-button-person-avatar"></div>'), 
            -1 != e.button.src.search("<") ? t(".czm-button-person-avatar", o).append(e.button.src) : t(".czm-button-person-avatar", o).addClass("czm-button-person-avatar-border").append('<img src="' + e.button.src + '" alt="">'), 
            6 != e.button.style && 7 != e.button.style || t(".czm-button-person-avatar", o).css("background-color", e.button.color), 
            3 == e.button.style || 5 == e.button.style ? t(".czm-button", o).append('<div class="czm-button-content"><div class="czm-button-content-title">' + e.button.text.title + "</div></div>") : 2 != e.button.style && 4 != e.button.style && 6 != e.button.style && 7 != e.button.style || (t(".czm-button", o).append('<div class="czm-button-content"><div class="czm-button-content-title">' + e.button.text.title + "</div></div>"), 
            (!1 !== e.button.text.description && "" !== e.button.text.description && void 0 !== e.button.text.description || !1 !== e.button.text.status && "" !== e.button.text.status && void 0 !== e.button.text.status || !1 !== e.button.text.offlineText && "" !== e.button.text.offlineText && void 0 !== e.button.text.offlineText) && (!1 !== e.button.text.description && "" !== e.button.text.description && void 0 !== e.button.text.description && t(".czm-button-content", o).append('<div class="czm-button-content-description">' + e.button.text.description + "</div>"), 
            1 == s ? !1 !== e.button.text.status && "" !== e.button.text.status && void 0 !== e.button.text.status && t(".czm-button-content", o).append('<div class="czm-button-content-status">' + e.button.text.status + "</div>") : !1 !== e.button.text.offlineText && "" !== e.button.text.offlineText && void 0 !== e.button.text.offlineText && t(".czm-button-content", o).append('<div class="czm-button-content-status">' + e.button.text.offlineText + "</div>"))), 
            0 == s && t(".czm-button", o).addClass("czm-button-offline"), !1 === e.button.link.desktop && !1 === e.button.link.mobile || 1 != s || t(".czm-button", o).click(function() {
                n = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && !1 !== e.button.link.mobile ? e.button.link.mobile : e.button.link.desktop, 
                window.open(n, "_blank"), y(), e.onClick && "function" == typeof e.onClick && e.onClick.call(this);
            }), 1 == e.button.pulseEffect && 1 == s && 1 == e.button.style && (t(".czm-button", o).append('<div class="czm-pulse"></div><div class="czm-pulse"></div>'), 
            t(".czm-pulse", o).css("background-color", e.button.color)), !1 !== e.button.notificationNumber && 1 == s && (t(".czm-button", o).append('<div class="czm-notify"><div class="czm-notify-circle"></div></div>'), 
            setTimeout(function() {
                t(".czm-notify-circle", o).addClass("czm-notify-circle-show czm-bounce").html(e.button.notificationNumber), 
                setInterval(function() {
                    t(".czm-notify-circle", o).toggleClass("czm-bounce");
                }, 2e3);
            }, 4e3)), !1 !== e.button.speechBubble && 1 == s && (t(o).prepend('<div class="czm-speech-bubble"><span class="czm-speech-bubble-close"></span><div class="czm-speech-bubble-text"></div></div>'), 
            setTimeout(function() {
                setTimeout(function() {
                    t(".czm-speech-bubble", o).addClass("czm-speech-bubble-show");
                }, 1), t(".czm-speech-bubble-text", o).html('<div class="czm-speech-bubble-typing"><div></div><div></div><div></div></div>'), 
                setTimeout(function() {
                    t(".czm-speech-bubble-close", o).addClass("czm-speech-bubble-close-show"), t(".czm-speech-bubble-text", o).html(e.button.speechBubble);
                }, 3e3);
            }, 1e3), t(".czm-speech-bubble-close", o).click(function() {
                t(".czm-speech-bubble", o).removeClass("czm-speech-bubble-show");
            })), !1 !== e.sound && 1 == s && (t("#czmSound").length > 0 && t("#czmSound").remove(), 
            setTimeout(function() {
                if (t(o).append('<audio id="czmSound" src="' + e.sound + '" muted></audio>'), t("#czmSound").length > 0) {
                    var p = document.getElementById("czmSound");
                    void 0 !== p && (p.play(), p.muted = !1);
                }
            }, 4e3)), !1 !== e.changeBrowserTitle && 1 == s) {
                var u = !0, i = null, a = t("title").text(), c = t('link[rel="shortcut icon"]').attr("href"), r = e.changeBrowserTitle, d = "../plugin/assets/img/browser-title-number.png";
                t(window).blur(function() {
                    t("title").text(r), t('link[rel="shortcut icon"]').attr("href", d), i = setInterval(function() {
                        document.title = u ? a : r, document.querySelector('link[rel="shortcut icon"]').href = u ? c : d, 
                        u = !u;
                    }, 700);
                }), t(window).focus(function() {
                    clearInterval(i), t('link[rel="shortcut icon"]').attr("href", c), t("title").text(a);
                });
            }
            if (0 == e.button.link.desktop && 0 == e.button.link.mobile && e.popup.persons.length > 0 && ("right" == e.button.position || "left" == e.button.position)) {
                var l;
                if (1 == e.popup.outsideClickClosePopup && (t(document).click(function() {
                    t(o).hasClass("czm-popup-show") && (v(), e.onPopupClose && "function" == typeof e.onPopupClose && e.onPopupClose.call(this));
                }), t(o).click(function(t) {
                    return t.stopPropagation(), !1;
                })), t(".czm-button", o).click(function() {
                    v(), t(o).hasClass("czm-popup-show") ? e.onPopupOpen && "function" == typeof e.onPopupOpen && e.onPopupOpen.call(this) : e.onPopupClose && "function" == typeof e.onPopupClose && e.onPopupClose.call(this);
                }), 2 != e.popup.effect && 10 != e.popup.effect && 12 != e.popup.effect || ("right" == e.button.position ? e.popup.effect = e.popup.effect + "__1" : "left" == e.button.position && (e.popup.effect = e.popup.effect + "__2")), 
                t(o).prepend('<div class="czm-popup animate__popup__' + e.popup.effect + '"></div>'), 
                1 == e.popup.automaticOpen) l = 1 == e.button.delay ? 900 : 200, setTimeout(function() {
                    v(), e.onPopupOpen && "function" == typeof e.onPopupOpen && e.onPopupOpen.call(this);
                }, l);
                t(".czm-popup", o).prepend(''),  //<div class="czm-popup-header"><span class="czm-popup-close"></span></div>
                t(".czm-popup-close", o).click(function() {
                    v(), e.onPopupClose && "function" == typeof e.onPopupClose && e.onPopupClose.call(this);
                }), t(".czm-popup-header", o).css("background-color", e.popup.color), 0 == e.popup.header.title || "" == e.popup.header.title || null == e.popup.header.title ? t(".czm-popup-header", o).append('<div class="czm-popup-header-title">Need Help? Chat with us</div>') : t(".czm-popup-header", o).append('<div class="czm-popup-header-title">' + e.popup.header.title + "</div>"), 
                !1 !== e.popup.header.description && "" !== e.popup.header.description && void 0 !== e.popup.header.description && t(".czm-popup-header", o).append('<div class="czm-popup-header-description">' + e.popup.header.description + "</div>"), 
                e.popup.persons.length > 5 ? t(".czm-popup", o).append('<div class="czm-popup-area czm-popup-area-small"><div class="czm-popup-persons"></div></div>') : t(".czm-popup", o).append('<div class="czm-popup-area"><div class="czm-popup-persons"></div><hr><div class="text-center"><a href="'+e.accountLink+'"><i class="fal fa-envelope mr-2"></i>'+e.accountText+'</a></div></div>');
                for (var m = 0, b = 0; b < e.popup.persons.length; b++) {
                    var f;
                    m = b + 1;
                    var h = !0;
                    null == e.popup.persons[b].link ? e.popup.persons[b].link = e.popup.personsSettings.link : (null == e.popup.persons[b].link.desktop && (e.popup.persons[b].link.desktop = e.popup.personsSettings.link.desktop), 
                    null == e.popup.persons[b].link.mobile && (e.popup.persons[b].link.mobile = e.popup.personsSettings.link.mobile)), 
                    null == e.popup.persons[b].avatar ? e.popup.persons[b].avatar = e.popup.personsSettings.avatar : (null == e.popup.persons[b].avatar.src && (e.popup.persons[b].avatar.src = e.popup.personsSettings.avatar.src), 
                    null == e.popup.persons[b].avatar.color && (e.popup.persons[b].avatar.color = e.popup.personsSettings.avatar.color)), 
                    null == e.popup.persons[b].text ? e.popup.persons[b].text = e.popup.personsSettings.text : (null == e.popup.persons[b].text.title && (e.popup.persons[b].text.title = e.popup.personsSettings.text.title), 
                    null == e.popup.persons[b].text.description && (e.popup.persons[b].text.description = e.popup.personsSettings.text.description), 
                    null == e.popup.persons[b].text.status && (e.popup.persons[b].text.status = e.popup.personsSettings.text.status), 
                    null == e.popup.persons[b].text.offlineText && (e.popup.persons[b].text.offlineText = e.popup.personsSettings.text.offlineText)), 
                    null == e.popup.persons[b].day ? e.popup.persons[b].day = e.popup.personsSettings.day : (null == e.popup.persons[b].day.sunday && (e.popup.persons[b].day.sunday = e.popup.personsSettings.day.sunday), 
                    null == e.popup.persons[b].day.monday && (e.popup.persons[b].day.monday = e.popup.personsSettings.day.monday), 
                    null == e.popup.persons[b].day.tuesday && (e.popup.persons[b].day.tuesday = e.popup.personsSettings.day.tuesday), 
                    null == e.popup.persons[b].day.wednesday && (e.popup.persons[b].day.wednesday = e.popup.personsSettings.day.wednesday), 
                    null == e.popup.persons[b].day.thursday && (e.popup.persons[b].day.thursday = e.popup.personsSettings.day.thursday), 
                    null == e.popup.persons[b].day.friday && (e.popup.persons[b].day.friday = e.popup.personsSettings.day.friday), 
                    null == e.popup.persons[b].day.saturday && (e.popup.persons[b].day.saturday = e.popup.personsSettings.day.saturday)), 
                    window.moment && (0 == e.popup.persons[b].day[p.format("dddd").toLowerCase()] ? h = !1 : 0 == moment(p.format("HH:mm:ss"), "HH:mm:ss").isBetween(moment(e.popup.persons[b].day[p.format("dddd").toLowerCase()].split("-")[0] + ":00", "HH:mm:ss"), moment(e.popup.persons[b].day[p.format("dddd").toLowerCase()].split("-")[1] + ":59", "HH:mm:ss")) && (h = !1)), 
                    t(".czm-popup-persons", o).append('<div class="czm-popup-person" data-id="' + b + '"><div class="czm-popup-person-content"></div></div>');
                    var z = t(".czm-popup-person:nth-child(" + m + ")", o);
                    !1 === e.popup.persons[b].link.desktop && !1 === e.popup.persons[b].link.mobile || z.click(function(t) {
																														
                        f = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && !1 !== e.popup.persons[t.currentTarget.dataset.id].link.mobile ? e.popup.persons[t.currentTarget.dataset.id].link.mobile : e.popup.persons[t.currentTarget.dataset.id].link.desktop, 
						
						
						processMessage(f);
						
						 return;
                        //window.open(f, "_blank");
						
						
                    }), z.prepend('<div class="czm-popup-person-avatar"></div>'), -1 != e.popup.persons[b].avatar.src.search("<") ? t(".czm-popup-person:nth-child(" + m + ") .czm-popup-person-avatar", o).prepend(e.popup.persons[b].avatar.src) : t(".czm-popup-person:nth-child(" + m + ") .czm-popup-person-avatar", o).prepend('<img src="' + e.popup.persons[b].avatar.src + '" alt="">'), 
                    //t(".czm-popup-person:nth-child(" + m + ") .czm-popup-person-avatar", o).css("background-color", e.popup.persons[b].avatar.color), 
                    0 != e.popup.persons[b].text.title && "" != e.popup.persons[b].text.title && null != e.popup.persons[b].text.title || (e.popup.persons[b].text.title = "Unknown User"), 
                    t(".czm-popup-person:nth-child(" + m + ") .czm-popup-person-content", o).append('<div class="czm-popup-person-title">' + e.popup.persons[b].text.title + '<div class="czm-notify1 innernotify ntf-'+e.popup.persons[b].text.count+'"><div class="czm-notify-inner-circle czm-notify-circle-show">'+e.popup.persons[b].text.count+'</div></div>' + "</div>"), 
                    !1 !== e.popup.persons[b].text.description && "" !== e.popup.persons[b].text.description && void 0 !== e.popup.persons[b].text.description && t(".czm-popup-person:nth-child(" + m + ") .czm-popup-person-content", o).append('<div class="czm-popup-person-description">' + e.popup.persons[b].text.description + "</div>"), 
                    1 == h ? !1 !== e.popup.persons[b].text.status && "" !== e.popup.persons[b].text.status && void 0 !== e.popup.persons[b].text.status && t(".czm-popup-person:nth-child(" + m + ") .czm-popup-person-content", o).append('<div class="czm-popup-person-status">' + e.popup.persons[b].text.status + "</div>") : (z.addClass("czm-popup-person-offline"), 
                    !1 !== e.popup.persons[b].text.offlineText && "" !== e.popup.persons[b].text.offlineText && void 0 !== e.popup.persons[b].text.offlineText && t(".czm-popup-person:nth-child(" + m + ") .czm-popup-person-content", o).append('<div class="czm-popup-person-status">' + e.popup.persons[b].text.offlineText + "</div>")); 
					
                }
            }
            function v() {
                t(o).toggleClass("czm-popup-show"), y();
            }
            function y() {
                !1 !== e.cookie && (t(".czm-notify", o).addClass("czm-notify-hide"), t(".czm-speech-bubble", o).removeClass("czm-speech-bubble-show"), 
                t(".czm-pulse", o).addClass("czm-pulse-hide"), window.$.cookie && "true" !== t.cookie("pptChat") && t.cookie("pptChat", "true", {
                    expires: new Date(new Date().getTime() + 60 * e.cookie * 60 * 1e3),
                    path: "/"
                }));
            }
        });
    };
}(jQuery);