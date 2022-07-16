$(function() {
    // set input / select event when change value, remove text text - danger
    $('input[type="password"],input[type="text"]').bind(
        "keyup change input",
        function() {
            $(this).next().empty();
        }
    );
    // end
});
// Allow Edit profil
function allowEditProfil() {
    $("form input").prop("disabled", false);
    $("#Btn-editProfil").hide();
    $("#Btn-saveProfil").show(); //show button save
    $(".modal-title").text("Edit Profil"); // Set title to Bootstrap modal title

    $("#label-photo").text("Ganti Foto"); // label foto upload
}

// profil user
function profil_user(id) {
    $("#photo-preview div").empty();
    $("form input").prop("disabled", true);
    $("#Btn-editProfil").show();
    $("#Btn-saveProfil").hide();
    $("#profil_user_modal").modal("show");
    $("#form_profil_user")[0].reset();
    $(".text-danger").empty();
    $(".modal-title").text("Profil"); // Set title to Bootstrap modal title
    $.ajax({
        url: $("meta[name=app-url]").attr("content") +
            "admin/UserController/edit/" +
            id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $("#label-photo").text("Upload Foto"); // label foto upload

            $('[name="id_user"]').val(data.id_user);
            $('[name="nama"]').val(data.nama);
            $('[name="username"]').val(data.username);
            var photo =
                $("meta[name=app-url]").attr("content") + "upload/users/" + data.photo;
            if (data.photo) {
                $("#foto-user").html(
                    '<img src="' +
                    photo +
                    '" class="img-circle img-thumbnail" alt="profile-image">'
                );

                $("#photo-preview div").append(
                    '<input type="hidden" class="form-control" name="remove_photo" value="' +
                    data.photo +
                    '"/>'
                ); // remove photo
            } else {}
            reload_table();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal({
                title: "Gagal!",
                text: "Proses gagal!",
                type: "error",
                showConfirmButton: false,
                timer: 1500,
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

// Save Profil
function save_profil() {
    $("#Btn-saveProfil").text("Menyimpan..."); //change button text
    $("#Btn-saveProfil").attr("disabled", true); //set button disable
    // ajax adding data to database
    var formData = new FormData($("#form_profil_user")[0]);
    $.ajax({
        url: $("meta[name=app-url]").attr("content") +
            "admin/UserController/update/profil",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $("#profil_user_modal").modal("hide"); // hide bootstrap modal
                swal({
                    title: "Sukses!",
                    text: "Profil berhasil disimpan!",
                    type: "success",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(
                    function() {},
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    }
                );
                //if success close modal and reload ajax table
            } else {
                $.each(data.error, function(key, value) {
                    $('[name="' + key + '"]')
                        .next()
                        .text(value);
                });
            }
            $("#Btn-saveProfil").text("Simpan"); //change button text
            $("#Btn-saveProfil").attr("disabled", false); //set button enable
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal({
                title: "Gagal!",
                text: "Proses gagal!",
                type: "error",
                showConfirmButton: false,
                timer: 1500,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === "timer") {}
                }
            );
            $("#Btn-saveProfil").text("Simpan"); //change button text
            $("#Btn-saveProfil").attr("disabled", false); //set button enable
        },
    });
}

// ganti password
function ganti_pass() {
    $("#ganti_pass_modal").modal("show");
    $("#form_ganti_pass")[0].reset();
    $(".text-danger").empty();
    $(".modal-title").text("Ganti Password"); // Set title to Bootstrap modal title
    $("form input").prop("disabled", false);
}
// Save Pass
function save_pass() {
    $("#Btn-savePass").text("Menyimpan..."); //change button text
    $("#Btn-savePass").attr("disabled", true); //set button disable
    // ajax adding data to database
    $.ajax({
        url: $("meta[name=app-url]").attr("content") +
            "admin/UserController/update/password",
        type: "POST",
        data: $("#form_ganti_pass").serialize(),
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $("#ganti_pass_modal").modal("hide"); // hide bootstrap modal
                swal({
                    title: "Sukses!",
                    text: "Password berhasil disimpan!",
                    type: "success",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(
                    function() {},
                    // handling the promise rejection
                    function(dismiss) {
                        if (dismiss === "timer") {}
                    }
                );
                //if success close modal and reload ajax table
            } else {
                $.each(data.error, function(key, value) {
                    $('[name="' + key + '"]')
                        .next()
                        .text(value);
                });
            }
            $("#Btn-savePass").text("Simpan"); //change button text
            $("#Btn-savePass").attr("disabled", false); //set button enable
        },
        error: function(jqXHR, textStatus, errorThrown) {
            swal({
                title: "Gagal!",
                text: "Proses gagal!",
                type: "error",
                showConfirmButton: false,
                timer: 1500,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === "timer") {}
                }
            );
            $("#Btn-savePass").text("Simpan"); //change button text
            $("#Btn-savePass").attr("disabled", false); //set button enable
        },
    });
}

// logout
function logout() {
    swal({
        title: "Log Out?",
        text: "Anda yakin akan logout?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4fa7f3",
        cancelButtonColor: "#d57171",
        showCancelButton: true,
        confirmButtonText: "Logout",
        cancelButtonText: "Batal",
        confirmButtonClass: "btn btn-danger",
        cancelButtonClass: "btn btn-default m-l-10",
        buttonsStyling: false,
    }).then(
        function() {
            $.ajax({
                url: $("meta[name=app-url]").attr("content") +
                    "admin/AuthController/logout",
                type: "POST",
                success: function(data) {
                    swal({
                        title: "Sukses!",
                        text: "Log Out berhasil",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000,
                    }).then(
                        function(dismiss) {
                            if (dismiss === "timer") {}
                        },
                        function() {
                            window.location.href =
                                $("meta[name=app-url]").attr("content") + "login";
                        }
                    );
                },
                error: function(jqXHR, textStatus, errorThrown) {
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
        },
        function(dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === "cancel") {
                if (dismiss === "timer") {}
            }
        }
    );
}