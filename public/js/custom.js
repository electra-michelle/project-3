!(function (e) {
    "use strict";
    e(window).on("load", function () {
        e("#preloader").delay(350).fadeOut("slow"), e("body").delay(350).css({ overflow: "visible" });
    });
    let a = e(".sticky-header"),
        s = e(window);
    s.on("scroll", function () {
        s.scrollTop() < 1 ? a.removeClass("scroll-on") : a.addClass("scroll-on");
    });
    let t = e(".home-slide-2");
    t.owlCarousel({ items: 1, nav: !1, loop: !0, dots: !1, smartSpeed: 450, autoplay: !0, animateOut: "fadeOut", navText: ["<i class='flaticon-left-arrow'></i>", "<i class='flaticon-next'></i>"] }),
        t.on("translate.owl.carousel", function (a) {
            e(".banner-title").removeClass("animated fadeInLeft").css("opacity", "0"),
                e(".slide-txt p, .slide-txt span").removeClass("animated fadeInLeft").css("opacity", "0"),
                e(".slide-txt .custom-btn").removeClass("animated fadeInDown").css("opacity", "0"),
                e(".slide-img").removeClass("animated fadeInUp").css("opacity", "0"),
                e(".slide-bg.sb-1").removeClass("animated fadeInLeft").css("opacity", "0"),
                e(".slide-bg.sb-2").removeClass("animated fadeInRight").css("opacity", "0");
        }),
        t.on("translated.owl.carousel", function (a) {
            e(".banner-title").addClass("animated fadeInLeft").css("opacity", "1"),
                e(".slide-txt p, .slide-txt span").addClass("animated fadeInLeft").css("opacity", "1"),
                e(".slide-txt .custom-btn").addClass("animated fadeInDown").css("opacity", "1"),
                e(".slide-img").addClass("animated fadeInUp").css("opacity", "0"),
                e(".slide-bg.sb-1").addClass("animated fadeInLeft").css("opacity", "1"),
                e(".slide-bg.sb-2").addClass("animated fadeInRight").css("opacity", "1");
        });
    let i = e(".banner-slide");
    i.owlCarousel({ items: 1, nav: !0, loop: !0, dots: !1, autoplay: !0, smartSpeed: 450, animateOut: "fadeOut", navText: ["<i class='flaticon-left-arrow'></i>", "<i class='flaticon-next'></i>"] }),
        i.on("translate.owl.carousel", function (a) {
            e(".banner-title").removeClass("animated fadeInUp").css("opacity", "0"),
                e(".slide-txt p,.slide-txt span").removeClass("animated fadeInLeft").css("opacity", "0"),
                e(".slide-txt .custom-btn").removeClass("animated fadeInDown").css("opacity", "0"),
                e(".slide-img").removeClass("animated fadeInUp").css("opacity", "0");
        }),
        i.on("translated.owl.carousel", function (a) {
            e(".banner-title").addClass("animated fadeInUp").css("opacity", "1"),
                e(".slide-txt p,.slide-txt span").addClass("animated fadeInLeft").css("opacity", "1"),
                e(".slide-txt .custom-btn").addClass("animated fadeInDown").css("opacity", "1"),
                e(".slide-img").addClass("animated fadeInUp").css("opacity", "0");
        }),
        e(".trusted-brands").owlCarousel({
            margin: 10,
            responsiveClass: !0,
            nav: !1,
            dots: !1,
            loop: !0,
            slideTransition: "linear",
            autoplayTimeout: 4500,
            autoplayHoverPause: !0,
            autoplaySpeed: 4500,
            autoplay: !0,
            stagePadding: 10,
            responsive: { 0: { items: 1, nav: !0, navText: ["<i class='flaticon-right'></i>", "<i class='flaticon-right'></i>"] }, 600: { items: 3 }, 1e3: { items: 4 } },
        }),
        e(".team-wrap").owlCarousel({ nav: !1, dots: !1, loop: !0, responsiveClass: !0, responsive: { 0: { items: 1, nav: !0 }, 600: { items: 2 }, 1e3: { items: 3 } } }),
        e(".quote-slider").owlCarousel({ nav: !1, dots: !0, loop: !0, autoplay: !0, center: !0, responsiveClass: !0, responsive: { 0: { items: 1 }, 600: { items: 3 }, 1e3: { items: 3 } } }),
        e(".quote-slider2").owlCarousel({
            items: 2,
            nav: !0,
            navText: ["<i class='flaticon-next-1'></i>", "<i class='flaticon-previous'></i>"],
            loop: !0,
            margin: 40,
            dots: !1,
            responsiveClass: !0,
            responsive: { 0: { items: 1 }, 800: { items: 2 }, 1e3: { items: 2 } },
        }),
        new WOW({ offset: 100, animateClass: "animated", mobile: !0 }).init(),
        e(".counter").counterUp({ delay: 10, time: 1e3 }),
        e(".video").venobox({ share: ["facebook", "twitter", "download"] }),
        e(".service-video").venobox({ share: ["facebook", "twitter", "download"] }),
        e(".faq-popup").venobox(),
        e(".bn-video").venobox({ share: ["facebook", "twitter", "download"] });
    let o = e(".grid").isotope({ itemSelector: ".grid-item", percentPosition: !0 });
    e(".portfolio-menu").on("click", ".button", function () {
        let a = e(this).attr("data-filter");
        o.isotope({ filter: a });
    }),
        e(".portfolio-menu").each(function (a, s) {
            let t = e(s);
            t.on("click", "button", function () {
                t.find(".active").removeClass("active"), e(this).addClass("active");
            });
        });
    let n = e(".masson-grid").isotope({ itemSelector: ".item", percentPosition: !0, masonry: { columnWidth: ".grid-sizer" } });
    e(".portfolio-menu.massionary-menu").on("click", ".button", function () {
        let a = e(this).attr("data-filter");
        n.isotope({ filter: a });
    }),
        e.scrollUp({ scrollName: "scrollUp", topSpeed: 300, animation: "fade", animationInSpeed: 200, animationOutSpeed: 200, scrollText: "" });
    var l = e(".pro-qty");
    l.append('<div class="inc qty-btn">+</div>'),
        l.append('<div class= "dec qty-btn">-</div>'),
        e(".qty-btn").on("click", function (a) {
            a.preventDefault();
            var s = e(this),
                t = s.parent().find("input").val();
            if (s.hasClass("inc")) var i = parseFloat(t) + 1;
            else if (t > 1) i = parseFloat(t) - 1;
            else i = 1;
            s.parent().find("input").val(i);
        }),
        // e("#slider-range").slider({
        //     range: !0,
        //     min: 0,
        //     max: 500,
        //     values: [25, 500],
        //     slide: function (a, s) {
        //         e("#amount").val("$" + s.values[0] + " - $" + s.values[1]);
        //     },
        // }),
        // e("#amount").val("$" + e("#slider-range").slider("values", 0) + " - $" + e("#slider-range").slider("values", 1)),
        e("#billform-dirrentswitch").on("change", function () {
            e(this).is(":checked") ? e(".checkout-differentform").slideDown() : e(".checkout-differentform").slideUp();
        }),
        e('.checkout-payment input[type="radio"]').each(function () {
            e(this).is(":checked") && e(this).siblings(".pay-option-content").slideDown(),
                e(this)
                    .siblings("label")
                    .on("click", function () {
                        e('.checkout-payment input[type="radio"]').prop("checked", !1).siblings(".pay-option-content").slideUp(), e(this).prop("checked", !0).siblings(".pay-option-content").slideDown();
                    });
        });
    let d = e(".mailchimp-sform");
    d.length > 0 &&
    d.ajaxChimp({
        language: "es",
        callback: function (a) {
            "success" === a.result
                ? (e(".subscription-success")
                    .html('<i class="fa fa-check"></i><br/>' + a.msg)
                    .fadeIn(1500),
                    e(".subscription-error").fadeOut(500))
                : "error" === a.result &&
                e(".subscription-error")
                    .html('<i class="fa fa-times"></i><br/>' + a.msg)
                    .fadeIn(1500);
        },
        url: "https://facebook.us17.list-manage.com/subscribe/post?u=e8c07b57e07350179b0d6325b&amp;id=437442d4eb",
    }),
        (e.ajaxChimp.translations.es = {
            submit: "Submitting...",
            0: "We have sent you a confirmation email",
            1: "Please enter a value",
            2: "An email address must contain a single @",
            3: "The domain portion of the email address is invalid (the portion after the @: )",
            4: "The username portion of the email address is invalid (the portion before the @: )",
            5: "This email address looks fake or invalid. Please enter a real email address",
        });
})(jQuery);
//# sourceMappingURL=custom.js.map
