function login() {
    $("#btnLogin").text("Memproses..."); //change button text
    $("#btnLogin").attr("disabled", true); //set button disable
    // ajax adding data to database
    $.ajax({
        url: $("meta[name=app-url]").attr("content") + "admin/AuthController/check",
        type: "POST",
        data: $("#form_login").serialize(),
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                swal({
                    title: "Sukses!",
                    text: "Login berhasil!",
                    type: "success",
                    showConfirmButton: false,
                    timer: 1000,
                }).then(
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    },
                    function() {
                        window.location.href =
                            $("meta[name=app-url]").attr("content") + "admin/dashboard";
                    }
                );
            } else if (data.error) {
                $.each(data.error, function(key, value) {
                    $('[name="' + key + '"]')
                        .next()
                        .text(value);
                });
            } else {
                swal({
                    title: "Gagal!",
                    text: data.msg,
                    type: "error",
                    showConfirmButton: false,
                    timer: 1000,
                }).then(
                    function() {},
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    }
                );
            }
            $("#btnLogin").text("Login"); //change button text
            $("#btnLogin").attr("disabled", false); //set button enable
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#btnLogin").text("Login"); //change button text
            $("#btnLogin").attr("disabled", false);
            swal({
                title: "Gagal!",
                text: "Proses gagal!",
                type: "error",
                showConfirmButton: false,
                timer: 1000,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === "timer") {}
                }
            );
        },
    });
}
$(document).ready(function() {
    $("input").keyup(function() {
        $(this).next().empty();
    });
});