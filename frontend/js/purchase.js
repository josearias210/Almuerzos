
function  loadPurchases() {

    let request = new XMLHttpRequest();
    request.open('GET', 'http://104.248.122.53:8181/api/purchases', true);
    request.onload = function () {
        if (request.status >= 200 && request.status < 400) {

            let data = JSON.parse(this.response);
            $("#jsGrid").jsGrid({
                width: "100%",
                inserting: false,
                editing: false,
                sorting: true,
                paging: false,
                autoload: true,
                data: data,
                fields: [
                    {name: "created_at", type: "text", width: 5, title: "Fecha"},
                    {name: "ingredient_name", type: "text", width: 70, title: "Ingrediente",
                        itemTemplate: function (value) {
                            return value.toUpperCase();
                        }
                    },
                    {name: "quantity", type: "number", width: 5, title: "Cantidad"}
                ]
            });
        } else {
            swal("Lo sentimos!", 'No se pudo carga la información de relacionada con las compras"', "error");
        }
    };

    request.send();
}

loadPurchases();
