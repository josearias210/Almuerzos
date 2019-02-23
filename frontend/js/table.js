
function loadOrders(module) {

    let request = new XMLHttpRequest();

    if (module == "orders" || module == "kitchen") {
        request.open('GET', 'http://104.248.122.53:8181/api/orders', true);
    } else {
        return;
    }
    request.onload = function () {

        if (request.status >= 200 && request.status < 400) {

            let data = JSON.parse(this.response);
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
                    {
                        name: "food",
                        type: "text",
                        width: 100,
                        title: "Plato",
                        itemTemplate: function (value) {

                            if (value == null) {
                                return  "SIN ELEGIR";
                            } else {
                                return value.toUpperCase();
                                ;
                            }
                        }
                    },
                    {
                        type: "control",
                        itemTemplate: function (value, item) {
                            if (module == "orders") {
                                if (item.order_status != 'pendiente') {
                                    return '<input type="button" size="100" value="Receta" class=" btn btn-primary" data-food-id="' + item.food_id + '" data-food-name="' + item.food + '" onclick="recipe(this)" />';
                                }
                            } else if (module == "kitchen") {

                                let content = "";
                                if (item.order_status == 'pendiente') {
                                    content = '<input type="button" size="100" value="Elegir plato"  class=" btn btn-success" data-order="' + item.order_id + '" onclick="dispatch(this)" />';
                                } else {
                                    content = content + '&nbsp;<input type="button" size="100" value="Receta" class=" btn btn-dark" data-food-id="' + item.food_id + '" data-food-name="' + item.food + '" onclick="recipe(this)"  />';
                                }
                                if (item.order_status == 'preparando') {
                                    content = content + '&nbsp;<input type="button" size="100" value="Completar" class=" btn btn-primary" data-order-id="' + item.order_id + '"  onclick="completedOrder(this)" />';
                                }

                                return content;
                            }
                        }
                    }
                ]
            });
        } else {
            swal("Lo sentimos!", "No se pudo carga la información de relacionada con las ordenes");
        }
    };
    request.send();
}