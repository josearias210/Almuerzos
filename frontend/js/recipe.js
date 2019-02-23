function recipe(element) {

    let id = $(element).attr("data-food-id");
    let name = $(element).attr("data-food-name");

    let request = new XMLHttpRequest();
    request.open('GET', 'http://104.248.122.53:8181/api/foods/' + id + '/recipe', true);
    request.onload = function () {
        let data = JSON.parse(this.response);
        if (request.status >= 200 && request.status < 400) {
            showRecipe(name, data);
        } else {
            if (data.message != undefined) {
                swal("Lo sentimos!", data.message, "error");
            } else {
                swal("Lo sentimos!", 'No se pudo cargar la receta', "error");
            }
        }
    };
    request.send();
}


function showRecipe(name, ingredints) {
    $("#title-food").text(name);
    $("#list-ingredients").empty();
    $.each(ingredints, function (index, value) {
        $("#list-ingredients").append('<li><span>' + value["quantity"] + '</span>&nbsp;<span>' + value["name"] + '</span></li>');
    });
    $('#recipe-detail').modal('show');
}