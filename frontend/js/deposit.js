
function delivered(element) {

    $('#detail-dispatch').modal('hide');
    let id = $("#btn-delivered").attr("data-dispatch-id");

    let request = new XMLHttpRequest();
    request.open('POST', 'http://104.248.122.53:8181/api/dispatches/' + id + '/delivered', true);
    request.onload = function () {

        if (request.status >= 200 && request.status < 400) {
            loadDispatches();
            swal("Despacho completado!", "La cocina puede iniciar la preparación", "success");
        } else {
            var data = JSON.parse(this.response);
            if (data.message != undefined) {
                swal("Lo sentimos!", data.message, "error");
            } else {
                swal("Lo sentimos!", 'No se pudo completar el despacho', "error");
            }
        }
    };

    request.send();
}


function purchase(element) {

    let id = $(element).attr("data-ingredient-id");

    let request = new XMLHttpRequest();
    request.open('POST', 'http://104.248.122.53:8181/api/ingredients/' + id + '/purchase', true);
    request.onload = function () {

        if (request.status >= 200 && request.status < 400) {
            loadDetailsForId($("#btn-delivered").attr("data-dispatch-id"));
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


function loadDispatches() {

    var request = new XMLHttpRequest();

    request.open('GET', 'http://104.248.122.53:8181/api/dispatches', true);
    request.onload = function () {

        if (request.status >= 200 && request.status < 400) {

            var data = JSON.parse(this.response);
            $("#jsGrid").jsGrid({
                width: "100%",
                inserting: false,
                editing: false,
                sorting: true,
                paging: true,
                autoload: true,
                pageSize: 10,
                pageButtonCount: 5,
                data: data,
                fields: [
                    {name: "order_id", type: "number", width: 10, title: "#"},
                    {name: "order_status", type: "text", width: 50, title: "Orden Estatus",
                        itemTemplate: function (value, item) {
                            value = value.toUpperCase();
                            if (item.order_status == 'pendiente') {
                                value = 'ENVIADA A COCINA';
                            } else if (item.order_status == 'bodega') {
                                value = 'ESPERANDO INGREDIENTES';
                            }
                            return value;
                        }
                    },
                    {name: "food", type: "text", width: 100, title: "Plato",
                        itemTemplate: function (value) {
                            return value.toUpperCase();
                        }
                    },
                    {type: "control",
                        itemTemplate: function (value, item) {
                            if (item.order_status == 'bodega') {
                                return '<input type="button" size="100" value="Ver Detalle" class=" btn btn-primary" data-dispatch-id="' + item.dispatch_id + '"  onclick="loadDetails(this)" />';

                            }
                        }
                    }
                ]
            });
        } else {
            swal("Lo sentimos!", 'No se pudo completar la carga de los despachos', "error");
        }
    };

    request.send();
}

function loadDetails(element) {
    let id = $(element).attr("data-dispatch-id");
    loadDetailsForId(id);
}

function  loadDetailsForId(id) {

    $("#btn-delivered").show();
    $("#btn-delivered").attr("data-dispatch-id", id);

    let request = new XMLHttpRequest();

    request.open('GET', 'http://104.248.122.53:8181/api/dispatches/' + id + '/detail', true);
    request.onload = function () {

        if (request.status >= 200 && request.status < 400) {

            let data = JSON.parse(this.response);
            $("#details-dispatches").jsGrid({
                width: "100%",
                inserting: false,
                editing: false,
                sorting: true,
                paging: false,
                autoload: true,
                data: data,
                fields: [
                    {name: "ingredient_name", type: "text", width: 80, title: "Ingrediente",
                        itemTemplate: function (value) {
                            return value.toUpperCase();
                        }
                    },
                    {name: "quantity", type: "number", width: 45, title: "Requerida"},
                    {name: "stock", type: "number", width: 45, title: "Inventario"},

                    {type: "control",
                        itemTemplate: function (value, item) {

                            if (item.quantity > item.stock) {
                                $("#btn-delivered").hide();
                                return '<input type="button" size="100" value="Comprar"  class=" btn btn-danger" data-ingredient-id="' + item.ingredient_id + '" onclick="purchase(this)" />';
                            }
                        }
                    }
                ]
            });
            $('#detail-dispatch').modal('show');
        } else {
            swal("Lo sentimos!", 'No se pudo cargar la informacion relacionada con el despacho', "error");
        }
    };

    request.send();
}

loadDispatches();