$(function() {
    $("#table-dashboard").DataTable({
        processing: true, //Feature control the processing indicator.
        order: [], //Initial no order.
        autoWidth: false,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: $("meta[name=app-url]").attr("content") +
                "admin/dashboardcontroller/drainase_kelurahan",
            type: "GET",
        },
    });
});

$.ajax({
    type: "GET",
    url: $("meta[name=app-url]").attr("content") +
        "jsoncontroller/data/drainase/line",
    dataType: "JSON",
    success: function(data) {
        let melimpah = 0;
        let tidak_melimpah = 0;
        for (let i = 0; i < data.length; i++) {
            $.each(data[i].features, function(k, v) {
                let status = v.properties["status_genangan"];

                if (status == "Melimpah") {
                    ++melimpah;
                }
                if (status == "Tidak Melimpah") {
                    ++tidak_melimpah;
                }
            });
        }

        let array = [];
        array[0] = { status_genangan: "Melimpah", total: melimpah };
        array[1] = { status_genangan: "Tidak Melimpah", total: tidak_melimpah };

        let status_genangan = [];
        let total = [];
        for (let i = 0; i < array.length; i++) {
            status_genangan.push(array[i].status_genangan);
            total.push(array[i].total);
        }

        const data2 = {
            labels: status_genangan,
            datasets: [{
                label: "My First Dataset",
                data: total,
                backgroundColor: [
                    "rgb(255, 99, 132)",
                    "rgb(54, 162, 235)",
                    "rgb(255, 205, 86)",
                ],
                hoverOffset: 4,
            }, ],
        };
        const config = {
            type: "pie",
            data: data2,
        };
        const myChart = new Chart(document.getElementById("myChart"), config);
    },
});