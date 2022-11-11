class mainJS {
    constructor() {
        this.onDOM();
    }
    onDOM() {
        this.togglePreWrapper();
        this.carousel();
        this.accordion();
        this.dropdown();
        this.mobileMenu();
        this.tab();
        this.tooltip();
    }
    tooltip() {
        $('[data-toggle="tooltip"]').tooltip();

    }
    mobileMenu() {
        document.addEventListener("click", (e) => {
            if (
                e.target.matches(".show-mobile-menu") ||
                e.target.matches(".close-mobile-menu")
            ) {
                document.body.classList.toggle("mobile-menu-opened");
            }
        });
        document.querySelector("#mobile-menu").addEventListener("click", (e) => {
            if (e.target.matches("#mobile-menu")) {
                document.body.classList.toggle("mobile-menu-opened");
            }
        });
        document.querySelectorAll("#mobile-menu .item.has-submenu").forEach((item) => {
            item.addEventListener("click", (e) => {
                if (e.target.matches(".toggle-submenu")) {
                    e.preventDefault();
                    item.classList.toggle("expanded");
                }
            });
        });

    }

    dropdown() {
        document.addEventListener("click", (e) => {
            if (e.target.closest(".dropdown")) {
                if (e.target.classList.contains("dropdown-toggle"))
                    e.target.parentElement.classList.toggle("expanded");
            } else {
                document.querySelectorAll(".dropdown.expanded").forEach((item) => {
                    item.classList.remove("expanded");
                });
            }
        });
    }
    tab() {
        document.addEventListener("click", (e) => {
            if (e.target.matches(".menu-tab")) {
                let href = e.target.getAttribute("href");
                document.querySelectorAll(".content-tab.expanded").forEach((item) => {
                    item.classList.remove("expanded");
                });
                document.querySelector(href).classList.add("expanded");
            }
        });
    }
    togglePreWrapper() {
        document.addEventListener("click", (e) => {
            if (e.target.matches(".toggle-pre-wrapper")) {
                document.body.classList.toggle("pre-wrapper-opened");
            }
        });
    }
    accordion() {
        document.querySelectorAll(".accordion").forEach((item) => {
            item.addEventListener("click", (e) => {
                if (e.target.classList.contains("collapse"))
                    item.classList.toggle("expanded");
            });
        });
    }
    carousel() {
        document
            .querySelectorAll(".carousel > .carousel_items")
            .forEach((slider) => {
                tns({
                    mouseDrag: 1,
                    container: slider,
                    controlsContainer: typeof slider.getAttribute("data-controlsContainer") !== null ?
                        slider.getAttribute("data-controlsContainer") : 0,
                    items: slider.getAttribute("data-items") !== null ?
                        Number(slider.getAttribute("data-items")) : 1,
                    slideBy: "page",
                    loop: slider.getAttribute("data-loop") !== null ?
                        Number(slider.getAttribute("data-loop")) : 0,
                    controls: typeof slider.getAttribute("data-controls") !== null ?
                        Number(slider.getAttribute("data-controls")) : 0,
                    nav: slider.getAttribute("data-nav") !== null ?
                        Number(slider.getAttribute("data-nav")) : 0,
                    navPosition: "bottom",
                    autoplayResetOnVisibility: true,
                    responsive: {
                        576: slider.getAttribute("data-responsive-576") ?
                            JSON.parse(slider.getAttribute("data-responsive-576")) : { items: 2, gutter: 16 },
                        768: slider.getAttribute("data-responsive-768") ?
                            JSON.parse(slider.getAttribute("data-responsive-768")) : { items: 3, gutter: 16 },
                        1200: slider.getAttribute("data-responsive-1200") ?
                            JSON.parse(slider.getAttribute("data-responsive-1200")) : { items: 3, gutter: 24 },
                        1600: slider.getAttribute("data-responsive-1600") ?
                            JSON.parse(slider.getAttribute("data-responsive-1600")) : { items: 4, gutter: 32 },
                    },
                });
            });
    }
}
document.addEventListener(
    "DOMContentLoaded",
    () => {
        new mainJS();
    },
    false
);

// Input incrementer
$(".numbers-row").append('<div class="inc button_inc">+</div><div class="dec button_inc">-</div>');
$(".button_inc").on('click', function() {

    var $button = $(this);
    var oldValue = $button.parent().find("input[type=number]").val();

    if ($button.text() == "+") {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        // Don't allow decrementing below zero
        if (oldValue > 1) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 1;
        }
    }
    $button.parent().find("input[type=number]").val(newVal);
});

// Reserve Fixed on mobile
$('.btn_reserve_fixed a').on('click', function() {
    $(".box_order").show();
});
$(".close_panel_mobile").on('click', function(event) {
    event.stopPropagation();
    $(".box_order").hide();
});



$("a[href^='#']").click(function(e) {
    e.preventDefault();

    var position = $($(this).attr("href")).offset().top;

    $("body, html").animate({
        scrollTop: position
    });
});
// Scroll to top
var pxShow = 800; // height on which the button will show
var scrollSpeed = 500; // how slow / fast you want the button to scroll to top.
$(window).scroll(function() {
    if ($(window).scrollTop() >= pxShow) {
        $("#toTop").addClass('visible');
    } else {
        $("#toTop").removeClass('visible');
    }
});
$('#toTop').on('click', function() {
    $('html, body').animate({ scrollTop: 0 }, scrollSpeed);
    return false;
});

function openNav() {
    document.body.classList.toggle("mobile-menu-opened");
}

$("[data-toggle=popover]").popover();
$(function() {
    $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
});
/*
 Sticky-kit v1.1.3 | MIT | Leaf Corcoran 2015 | http://leafo.net
*/
(function() {
    var c, f;
    c = window.jQuery;
    f = c(window);
    c.fn.stick_in_parent = function(b) {
        var A, w, J, n, B, K, p, q, L, k, E, t;
        null == b && (b = {});
        t = b.sticky_class;
        B = b.inner_scrolling;
        E = b.recalc_every;
        k = b.parent;
        q = b.offset_top;
        p = b.spacer;
        w = b.bottoming;
        null == q && (q = 0);
        null == k && (k = void 0);
        null == B && (B = !0);
        null == t && (t = "is_stuck");
        A = c(document);
        null == w && (w = !0);
        L = function(a) {
            var b;
            return window.getComputedStyle ? (a = window.getComputedStyle(a[0]), b = parseFloat(a.getPropertyValue("width")) + parseFloat(a.getPropertyValue("margin-left")) +
                parseFloat(a.getPropertyValue("margin-right")), "border-box" !== a.getPropertyValue("box-sizing") && (b += parseFloat(a.getPropertyValue("border-left-width")) + parseFloat(a.getPropertyValue("border-right-width")) + parseFloat(a.getPropertyValue("padding-left")) + parseFloat(a.getPropertyValue("padding-right"))), b) : a.outerWidth(!0)
        };
        J = function(a, b, n, C, F, u, r, G) {
            var v, H, m, D, I, d, g, x, y, z, h, l;
            if (!a.data("sticky_kit")) {
                a.data("sticky_kit", !0);
                I = A.height();
                g = a.parent();
                null != k && (g = g.closest(k));
                if (!g.length) throw "failed to find stick parent";
                v = m = !1;
                (h = null != p ? p && a.closest(p) : c("<div />")) && h.css("position", a.css("position"));
                x = function() {
                    var d, f, e;
                    if (!G && (I = A.height(), d = parseInt(g.css("border-top-width"), 10), f = parseInt(g.css("padding-top"), 10), b = parseInt(g.css("padding-bottom"), 10), n = g.offset().top + d + f, C = g.height(), m && (v = m = !1, null == p && (a.insertAfter(h), h.detach()), a.css({ position: "", top: "", width: "", bottom: "" }).removeClass(t), e = !0), F = a.offset().top - (parseInt(a.css("margin-top"), 10) || 0) - q, u = a.outerHeight(!0), r = a.css("float"), h && h.css({
                            width: L(a),
                            height: u,
                            display: a.css("display"),
                            "vertical-align": a.css("vertical-align"),
                            "float": r
                        }), e)) return l()
                };
                x();
                if (u !== C) return D = void 0, d = q, z = E, l = function() {
                        var c, l, e, k;
                        if (!G && (e = !1, null != z && (--z, 0 >= z && (z = E, x(), e = !0)), e || A.height() === I || x(), e = f.scrollTop(), null != D && (l = e - D), D = e, m ? (w && (k = e + u + d > C + n, v && !k && (v = !1, a.css({ position: "fixed", bottom: "", top: d }).trigger("sticky_kit:unbottom"))), e < F && (m = !1, d = q, null == p && ("left" !== r && "right" !== r || a.insertAfter(h), h.detach()), c = { position: "", width: "", top: "" }, a.css(c).removeClass(t).trigger("sticky_kit:unstick")),
                                B && (c = f.height(), u + q > c && !v && (d -= l, d = Math.max(c - u, d), d = Math.min(q, d), m && a.css({ top: d + "px" })))) : e > F && (m = !0, c = { position: "fixed", top: d }, c.width = "border-box" === a.css("box-sizing") ? a.outerWidth() + "px" : a.width() + "px", a.css(c).addClass(t), null == p && (a.after(h), "left" !== r && "right" !== r || h.append(a)), a.trigger("sticky_kit:stick")), m && w && (null == k && (k = e + u + d > C + n), !v && k))) return v = !0, "static" === g.css("position") && g.css({ position: "relative" }), a.css({ position: "absolute", bottom: b, top: "auto" }).trigger("sticky_kit:bottom")
                    },
                    y = function() { x(); return l() }, H = function() {
                        G = !0;
                        f.off("touchmove", l);
                        f.off("scroll", l);
                        f.off("resize", y);
                        c(document.body).off("sticky_kit:recalc", y);
                        a.off("sticky_kit:detach", H);
                        a.removeData("sticky_kit");
                        a.css({ position: "", bottom: "", top: "", width: "" });
                        g.position("position", "");
                        if (m) return null == p && ("left" !== r && "right" !== r || a.insertAfter(h), h.remove()), a.removeClass(t)
                    }, f.on("touchmove", l), f.on("scroll", l), f.on("resize", y), c(document.body).on("sticky_kit:recalc", y), a.on("sticky_kit:detach", H), setTimeout(l,
                        0)
            }
        };
        n = 0;
        for (K = this.length; n < K; n++) b = this[n], J(c(b));
        return this
    }
}).call(this);
$('.sticky_horizontal').stick_in_parent({
    offset_top: 0
});