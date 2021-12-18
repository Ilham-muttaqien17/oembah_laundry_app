console.log("ads");
$(document).ready(function () {
    $("#keyword").on("keyup", function () {
        $("#container").load("../laundry.php?keyword=" + $("#keyword").val());
        console.log("asd");
    });
});
