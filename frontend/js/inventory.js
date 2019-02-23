function purchase(element) {

    let id = $(element).attr("data-ingredient-id");

    let request = new XMLHttpRequest();
    request.open('POST', 'http://104.248.122.53:8181/api/ingredients/' + id + '/purchase', true);
    request.onload = function () {

        if (request.status >= 200 && request.status < 400) {
            loadinventory();
            swal("Compra completada!", "Se actualizo stock del inventario", "success");
        } else {
            var data = JSON.parse(this.response);
            if (data.message != undefined) {
                swal("Lo sentimos!", data.message, "error");
            } else {
                swal("Lo sentimos!", 'No se pudo completar la compra', "error");
            }
        }
    };

    request.send();
}

function  loadinventory() {
    let request = new XMLHttpRequest();

    request.open('GET', 'http://104.248.122.53:8181/api/ingredients', true);
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
                    {name: "name", type: "text", width: 70, title: "Ingrediente",
                        itemTemplate: function (value) {
                            return value.toUpperCase();
                        }
                    },
                    {name: "quantity", type: "number", width: 5, title: "Cantidad"},
                    {type: "control", width: 10,
                        itemTemplate: function (value, item) {
                            return '<input type="button" size="100" value="Comprar"  class=" btn btn-danger" data-ingredient-id="' + item.ingredient_id + '" onclick="purchase(this)" />';
                        }
                    }
                ]
            });

        } else {
            swal("Lo sentimos!", 'No se pudo carga la información de relacionada con el inventario"', "error");
        }
    };

    request.send();
}

loadinventory();
