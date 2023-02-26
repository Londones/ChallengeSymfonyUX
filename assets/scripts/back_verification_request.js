$(document).ready(function() {
let modal = document.getElementById("image-modal");
modal.addEventListener("show.te.modal", function(event) {
    // call Ajax
    let id = event.relatedTarget.getAttribute("data-id");
    let url = id + "/proof";
    $.ajax({
        url: url,
        type: "GET",
        success: function(data) {
            $("#modal-body").html(data);
        }
    });
});
});





   

