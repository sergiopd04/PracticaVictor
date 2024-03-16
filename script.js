document.addEventListener("DOMContentLoaded", function () {
    cargarPacientes();
});

function cargarPacientes() {
    var valorElement = document.getElementById("valor");
    if (valorElement) {
        var valor = valorElement.value;
        var data = {
            filters: { nombre: valor },
            action: "get"
        };
    fetch("sw_medico.php", {
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        method: 'POST',
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                $("table tbody").empty();
                for(let i = 0; i < response.data.length; i++) {
                    $("table tbody").append("<tr><td>" + response.data[i].id + "</td><td>" + response.data[i].sip + "</td></tr>" + response.data[i].dni + "</td><td>" + response.data[i].nombre + "</td></td>" + "</td><td>" + response.data[i].apellido1 + "</td></tr>");
                }
            }
        })
        .catch(err => {
            console.log(err);
            alert("Sin resultados.");
        });

    console.log("Fin Ajax");
    }
}
