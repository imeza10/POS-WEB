$(document).ready(function() {


    $("#btmenos").click(function(e) {

        var cantidad = parseInt($("#amount").val());
        if (cantidad != 1)
            cantidad -= 1;
        else
            cantidad = 1;

        $("#amount").val(cantidad);
        price(cantidad);

    });

    $("#btmas").click(function(e) {
        var cantidad = parseInt($("#amount").val());
        cantidad += 1;
        $("#amount").val(cantidad);
        price(cantidad);

        var prod_name = $("#product_name").html();
        var subtotal = $("#subtotal-" + prod_name).html();
        console.log("Product Name: " + prod_name);
        console.log("Subtotal: " + subtotal);

    });

    //FUNCION PARA UTILIZAR EN LA VISTA DETALLE.PHP
    function price(cantidad) {
        var precio = parseFloat($("#price").html().replace('$', '').replace(',', '').replace('.', ''));


        $("#total").html("Total: $" + parseFloat(precio * cantidad).toLocaleString(window.document.documentElement.lang));


        //$("#total").html("Total: $"+parseFloat(total).toLocaleString(window.document.documentElement.lang));

    }

    $('#agregar').on('click', function() {
        agregar();
    });

    function agregar() {
        console.log("Agregado");

        var product_id = $("#product_id").html();
        var instructions = $("#instructions").val();
        var product_amount = parseInt($("#amount").val());
        var total = $("#total").html().replace('Total: $', '').replace('.', '').replace(',', '');
        var session_id = $("#session_id").html();
        console.log("Post var" + product_id + " - " + instructions + " - " + product_amount + " - " + total + " - " + session_id);

        $.ajax({
            url: "../controller/add_car.php",
            data: { product_id: product_id, instructions: instructions, product_amount: product_amount, total: total, session_id: session_id },
            type: "POST",
            dataType: "json",
            success: function(datos) {

                console.log(datos);

                switch (datos.success) {
                    case "0":
                        toastr.error(datos.message);
                        break;
                    case "1":
                        toastr.success(datos.message);
                        $("#cantidad_carshop").html(Number($('#cantidad_carshop').html()) + 1).change();
                        break;
                    case "2":
                        toastr.warning(datos.message);
                        break;
                    case "3":
                        toastr.warning(datos.message);
                        break;
                }
            }
        });


    };

    /**METODOS PARA SALES */

    $("#new-address").click(function(e) {

        $(".new-address-form").show('1000');
        $(".vlr-domicilio").show('1000');

        $(".address-new").hide('1000');

    });

    /**FIN METODOS SALES */


});

//**INICIO DE FUNCIONES ***/

function btmas(product_id, item, session_id) {
    console.log("Id elemento: " + product_id + ", item: " + item);

    console.log("Cantidad: " + $("#amount-" + item).val().toLocaleString().trim());

    var cantidad = parseInt($("#amount-" + item).val());
    cantidad += 1;
    $("#amount-" + item).val(cantidad);
    price(cantidad, item, session_id);

    //console.log("Cantidad elementos car: " + $("#cantidad_carshop").html());

    //console.log("Cantidad elementos car: " + (parseInt($("#cantidad_carshop").html()) + 1) );

}

function btmenos(product_id, item, session_id) {
    console.log("Id elemento: " + product_id + ", item: " + item);

    var cantidad = parseInt($("#amount-" + item).val());
    if (cantidad != 1)
        cantidad -= 1;
    else
        cantidad = 1;

    $("#amount-" + item).val(cantidad);
    price(cantidad, item, session_id);
}

//FUNCION PARA UTILIZAR EN LA VISTA CARSHOP.PHP
function price(cantidad, item, session_id) {
    var precio = parseFloat($("#price-" + item).html().replace('$&nbsp;', '').replace(',', '').replace('.', ''));
    var total = 0,
        subtotal = 0;

    subtotal = precio * cantidad;
    $("#subtotal-" + item).html("Subtotal $" + parseFloat(subtotal).toLocaleString(window.document.documentElement.lang));

    $(".item-product-price-detail").each(function() {
        console.log("Elemento: " + $(this).html() + ", valor: " + parseFloat($(this).html().replace('Subtotal $', '').replace(',', '').replace('.', '')));
        total += parseFloat($(this).html().replace('Subtotal $', '').replace(',', '').replace('.', ''));
    });

    $("#total").html("Total: $" + parseFloat(total).toLocaleString(window.document.documentElement.lang));

    update_car(cantidad, $("#instructions-" + item).val(), subtotal, item, session_id)

}

function bteliminar(product_id, session_id) {

    console.log("Id elemento: " + product_id + ", session_id: " + session_id);

    $.ajax({
        url: "../controller/del_car.php",
        data: { product_id: product_id, session_id: session_id },
        type: "POST",
        dataType: "json",
        success: function(datos) {

            console.log(datos);

            if (datos.success == "1") {
                toastr.success(datos.message);

                $("div").remove("#product-" + product_id);

                //console.log($("#cantidad_carshop").val());

                $("#cantidad_carshop").html((parseInt($("#cantidad_carshop").html()) - 1));

                var total = 0;
                $(".item-product-price-detail").each(function() {
                    console.log("Elemento: " + $(this).html() + ", valor: " + parseFloat($(this).html().replace('Subtotal $', '').replace(',', '').replace('.', '')));
                    total += parseFloat($(this).html().replace('Subtotal $', '').replace(',', '').replace('.', ''));
                });

                $("#total").html("Total: $" + parseFloat(total).toLocaleString(window.document.documentElement.lang));
            }

            if (datos.success == "0") {
                toastr.error(datos.message);
            }

            if (datos.success == "2") {
                toastr.warning(datos.message);
            }
        }
    });

}

function update_car(carshop_product_amount, carshop_instructions, carshop_total, product_id, session_id) {

    console.log("Datos: " + carshop_product_amount + ", " + carshop_instructions + ", " + carshop_total + ", " + product_id + ", " + session_id);

    $.ajax({
        url: "../controller/update_car.php",
        data: { carshop_product_amount: carshop_product_amount, carshop_instructions: carshop_instructions, carshop_total: carshop_total, product_id: product_id, session_id: session_id },
        type: "POST",
        dataType: "json",
        success: function(datos) {

            console.log(datos);

            if (datos.success == "1") {
                //toastr.success(datos.message);
                console.log(datos.message);
            }

            if (datos.success == "0") {
                toastr.error(datos.message);
            }

            if (datos.success == "2") {
                toastr.warning(datos.message);
            }
        }
    });

}

function pagar(session_id) {
    console.log("Datos: " + session_id);





}

/**FIN METODOS CARSHOP */

/**INICIO METODOS SALES */

function domicilio(total) {

    $(".address-new").show('1000');
    $(".vlr-domi").show('1000');
    $(".new-address-form").hide('1000');

    var domicilio = $("#domicilio").html().replace('Domicilio: $', '').replace(',', '').replace('.', '');


    $("#total").html("Total: $" + (parseFloat(total) + parseFloat(domicilio)).toLocaleString(window.document.documentElement.lang));

    $.ajax({
        url: "../controller/get_address.php",
        data: { session_id: session_id },
        type: "POST",
        dataType: "json",
        success: function(datos) {

            console.log(datos);

            if (datos.success == "1") {
                //toastr.success(datos.message);
                console.log(datos.message);
            }

            if (datos.success == "0") {
                toastr.error(datos.message);
            }

            if (datos.success == "2") {
                toastr.warning(datos.message);
            }
        }
    });

}

function sitio(total) {

    $(".new-address-form").hide('1000');
    $(".address-new").hide('1000');
    $(".vlr-domi").hide('1000');

    $(".new-address-form").hide('1000');
    $(".vlr-domicilio").hide('1000');

    $("#total").html("Total: $" + parseFloat(total).toLocaleString(window.document.documentElement.lang));

}

function guardar_address() {

    $.ajax({
        url: "../controller/add_cliente.php",
        data: { session_id: session_id },
        type: "POST",
        dataType: "json",
        success: function(datos) {

            console.log(datos);

            if (datos.success == "1") {
                //toastr.success(datos.message);
                console.log(datos.message);
            }

            if (datos.success == "0") {
                toastr.error(datos.message);
            }

            if (datos.success == "2") {
                toastr.warning(datos.message);
            }
        }
    });
}


/**FIN METODOS SALES */