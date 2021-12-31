$(document).ready(() => {
    $("#open-menu").on("click", function () {
        if ($(".nav-link").hasClass("hidden")) {
            $("#navbar").addClass("w-[180px]");
            $("#navbar").removeClass("w-[60px]");
            $(".nav-link").addClass("flex");
            $(".nav-link").removeClass("hidden");
            $("#overlay").removeClass("hidden");
            $("#overlay").addClass("block");
        } else {
            $("#navbar").addClass("w-[60px]");
            $("#navbar").removeClass("w-[180px]");
            $(".nav-link").removeClass("flex");
            $(".nav-link").addClass("hidden");
            $("#overlay").addClass("hidden");
            $("#overlay").removeClass("block");
        }
    });

    $("#overlay").on("click", function () {
        $("#navbar").addClass("w-[60px]");
        $("#navbar").removeClass("w-[180px]");
        $(".nav-link").removeClass("flex");
        $(".nav-link").addClass("hidden");
        $("#overlay").addClass("hidden");
        $("#overlay").removeClass("block");
    });
});
