$(window).scroll(function () {
    if ($(window).scrollTop() > 10) {
        $("#navbar-landing").addClass("bg-hero filter drop-shadow-lg");
        $("#navbar").addClass("filter drop-shadow-lg");
    } else {
        $("#navbar").removeClass("filter drop-shadow-lg");
        $("#navbar-landing").removeClass("bg-hero filter drop-shadow-lg");
    }
});

$(document).ready(function () {
    $("#toggle-menu").on("click", function () {
        $("#item-menu-mobile").slideDown(300);

        if ($("#item-menu-mobile").hasClass("hidden")) {
            $("#item-menu-mobile").addClass("block");
            $("#item-menu-mobile").removeClass("hidden");
        } else {
            $("#item-menu-mobile").removeClass("block");
            $("#item-menu-mobile").addClass("hidden");
            $("#item-menu-mobile").slideUp(300);
        }
    });
    var alterClass = () => {
        var body = document.body.clientWidth;
        if (body > 1024) {
            $("#item-menu-mobile").removeAttr("style");
            $("#item-menu-mobile").removeClass("block");
        }
    };
    $(window).resize(() => {
        alterClass();
    });

    alterClass();
});

$(document).ready(function () {
    $("#result").hide();
    $("#keyword").on("keyup", function () {
        var keyword = $("#keyword").val();
        if (keyword.length > 2) {
            $("#result").load("./laundry.php?keyword=" + $("#keyword").val());
            $("#result").show();
        } else {
            $("#result").hide();
        }
    });
});

$(document).ready(function () {
    $("#shoes").hide();
    $("#helmet").hide();
    $("#hotel").hide();
    $("#clothes").show();

    $("#btn-clothes").on("click", () => {
        $("#shoes").hide();
        $("#helmet").hide();
        $("#hotel").hide();
        $("#clothes").show();

        $("#btn-clothes").addClass("shadow-lg");
        $("#btn-shoes").removeClass("shadow-lg");
        $("#btn-helmet").removeClass("shadow-lg");
        $("#btn-hotel").removeClass("shadow-lg");
    });
    $("#btn-shoes").on("click", () => {
        $("#clothes").hide();
        $("#helmet").hide();
        $("#hotel").hide();
        $("#shoes").show();

        $("#btn-clothes").removeClass("shadow-lg");
        $("#btn-shoes").addClass("shadow-lg");
        $("#btn-helmet").removeClass("shadow-lg");
        $("#btn-hotel").removeClass("shadow-lg");
    });
    $("#btn-helmet").on("click", () => {
        $("#shoes").hide();
        $("#clothes").hide();
        $("#hotel").hide();
        $("#helmet").show();

        $("#btn-clothes").removeClass("shadow-lg");
        $("#btn-shoes").removeClass("shadow-lg");
        $("#btn-helmet").addClass("shadow-lg");
        $("#btn-hotel").removeClass("shadow-lg");
    });
    $("#btn-hotel").on("click", () => {
        $("#shoes").hide();
        $("#helmet").hide();
        $("#clothes").hide();
        $("#hotel").show();

        $("#btn-clothes").removeClass("shadow-lg");
        $("#btn-shoes").removeClass("shadow-lg");
        $("#btn-helmet").removeClass("shadow-lg");
        $("#btn-hotel").addClass("shadow-lg");
    });
});

$(document).ready(() => {
    $("#btn-open-modal").on("click", () => {
        $("#overlay").addClass("flex");
        $("#overlay").removeClass("hidden");
    });
    $("#btn-close-modal").on("click", () => {
        $("#overlay").addClass("hidden");
        $("#overlay").removeClass("flex");
    });
});

$(document).ready(() => {
    $("#btn-all").on("click", () => {
        $("#btn-all").addClass("bg-dark-blue text-white");
        $("#btn-all").removeClass("bg-white text-dark-blue");
        $("#btn-kiloan").removeClass("bg-dark-blue text-white");
        $("#btn-sepatu").removeClass("bg-dark-blue text-white");
        $("#btn-helm").removeClass("bg-dark-blue text-white");
        $("#btn-hotel").removeClass("bg-dark-blue text-white");

        $("#all-result").addClass("grid");
        $("#all-result").removeClass("hidden");
        $("#kiloan-result").removeClass("grid");
        $("#kiloan-result").addClass("hidden");
        $("#sepatu-result").removeClass("grid");
        $("#sepatu-result").addClass("hidden");
        $("#helm-result").removeClass("grid");
        $("#helm-result").addClass("hidden");
        $("#hotel-result").removeClass("grid");
        $("#hotel-result").addClass("hidden");
    });
    $("#btn-kiloan").on("click", () => {
        $("#btn-kiloan").addClass("bg-dark-blue text-white");
        $("#btn-kiloan").removeClass("bg-white text-dark-blue");
        $("#btn-all").removeClass("bg-dark-blue text-white");
        $("#btn-sepatu").removeClass("bg-dark-blue text-white");
        $("#btn-helm").removeClass("bg-dark-blue text-white");
        $("#btn-hotel").removeClass("bg-dark-blue text-white");

        $("#kiloan-result").addClass("grid");
        $("#kiloan-result").removeClass("hidden");
        $("#all-result").removeClass("grid");
        $("#all-result").addClass("hidden");
        $("#sepatu-result").removeClass("grid");
        $("#sepatu-result").addClass("hidden");
        $("#helm-result").removeClass("grid");
        $("#helm-result").addClass("hidden");
        $("#hotel-result").removeClass("grid");
        $("#hotel-result").addClass("hidden");
    });
    $("#btn-sepatu").on("click", () => {
        $("#btn-sepatu").addClass("bg-dark-blue text-white");
        $("#btn-sepatu").removeClass("bg-white text-dark-blue");
        $("#btn-all").removeClass("bg-dark-blue text-white");
        $("#btn-kiloan").removeClass("bg-dark-blue text-white");
        $("#btn-helm").removeClass("bg-dark-blue text-white");
        $("#btn-hotel").removeClass("bg-dark-blue text-white");

        $("#sepatu-result").addClass("grid");
        $("#sepatu-result").removeClass("hidden");
        $("#all-result").removeClass("grid");
        $("#all-result").addClass("hidden");
        $("#kiloan-result").removeClass("grid");
        $("#kiloan-result").addClass("hidden");
        $("#helm-result").removeClass("grid");
        $("#helm-result").addClass("hidden");
        $("#hotel-result").removeClass("grid");
        $("#hotel-result").addClass("hidden");
    });
    $("#btn-helm").on("click", () => {
        $("#btn-helm").addClass("bg-dark-blue text-white");
        $("#btn-helm").removeClass("bg-white text-dark-blue");
        $("#btn-all").removeClass("bg-dark-blue text-white");
        $("#btn-kiloan").removeClass("bg-dark-blue text-white");
        $("#btn-sepatu").removeClass("bg-dark-blue text-white");
        $("#btn-hotel").removeClass("bg-dark-blue text-white");

        $("#helm-result").addClass("grid");
        $("#helm-result").removeClass("hidden");
        $("#all-result").removeClass("grid");
        $("#all-result").addClass("hidden");
        $("#kiloan-result").removeClass("grid");
        $("#kiloan-result").addClass("hidden");
        $("#sepatu-result").removeClass("grid");
        $("#sepatu-result").addClass("hidden");
        $("#hotel-result").removeClass("grid");
        $("#hotel-result").addClass("hidden");
    });
    $("#btn-hotel").on("click", () => {
        $("#btn-hotel").addClass("bg-dark-blue text-white");
        $("#btn-hotel").removeClass("bg-white text-dark-blue");
        $("#btn-all").removeClass("bg-dark-blue text-white");
        $("#btn-kiloan").removeClass("bg-dark-blue text-white");
        $("#btn-sepatu").removeClass("bg-dark-blue text-white");
        $("#btn-helm").removeClass("bg-dark-blue text-white");

        $("#hotel-result").addClass("grid");
        $("#hotel-result").removeClass("hidden");
        $("#all-result").removeClass("grid");
        $("#all-result").addClass("hidden");
        $("#kiloan-result").removeClass("grid");
        $("#kiloan-result").addClass("hidden");
        $("#sepatu-result").removeClass("grid");
        $("#sepatu-result").addClass("hidden");
        $("#helm-result").removeClass("grid");
        $("#helm-result").addClass("hidden");
    });
});
