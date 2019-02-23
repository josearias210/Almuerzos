
function createMassive() {


    let quantity = document.getElementById("quantity").value;
    document.getElementById("quantity").value = 1;
    if (parseInt(quantity) > 1000) {
        swal("Lo sentimos!", "El màximo de ordenes permitida es de 1000", "error");
        return;
    }

    $('#order-mssive').modal('hide');
    createOrders(quantity);


}


function createOrders(quantity) {

    let formData = new FormData();
    formData.append("quantity", quantity);

    let request = new XMLHttpRequest();
    request.open('POST', 'http://104.248.122.53:8181/api/orders', true);
    request.onload = function () {
        if (request.status >= 200 && request.status < 400) {
            loadOrders('orders');
            swal("Orden registrada!", "Ahora la cocina debe elegir el plato", "success");

        } else {
            swal("Lo sentimos!", "Ha ocurrido un error al generar la orden", "error");
        }
    };

    request.send(formData);
}
