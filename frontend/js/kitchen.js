function dispatch(element) {

    var id = $(element).attr("data-order");

    let request = new XMLHttpRequest();
    request.open('POST', 'http://104.248.122.53:8181/api/orders/' + id + '/dispatches', true);
    request.onload = function () {

        if (request.status >= 200 && request.status < 400) {
            loadOrders('kitchen');
            swal("Orden procesada!", "El plato fue elegido y se envio la solicitud a la bodega", "success");
        } else {
            let data = JSON.parse(this.response);
            if (data.message != undefined) {
                swal("Lo sentimos!", data.message, "error");
            } else {
                swal("Lo sentimos!", 'No se pudo despachar la orden', "error");
            }
        }
    };

    request.send();
}


function completedOrder(element) {
    
    var id = $(element).attr("data-order-id");

    let request = new XMLHttpRequest();
    request.open('POST', 'http://104.248.122.53:8181/api/orders/' + id + '/completed', true);
    request.onload = function () {

        if (request.status >= 200 && request.status < 400) {
            loadOrders('kitchen');
            swal("Orden completada!", "El plato esta listo, ya puede ser servidor", "success");
        } else {
            let data = JSON.parse(this.response);
            if (data.message != undefined) {
                swal("Lo sentimos!", data.message, "error");
            } else {
                swal("Lo sentimos!", 'No se pudo completar la orden', "error");
            }
        }
    };

    request.send();
}

