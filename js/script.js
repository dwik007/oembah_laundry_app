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
    $("#keyword").on("keyup", function () {
        $("#container").load("../laundry.php?keyword=" + $("#keyword").val());
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
