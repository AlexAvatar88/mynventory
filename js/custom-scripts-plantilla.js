$(document).ready(function(){
    // Initialize collapse button
    $(".button-collapse").sideNav();

    // Initialize Modal
    $('.modal-trigger').leanModal();

    //Initialize Flip
    $(".flip").flip({
        axis: 'y',
        trigger: 'click',
        speed: 300
    });


    $('input:checkbox').each(function(){
        $(this).prop('checked', false);
    });

});

function checkboxToggle(checkbox){
    if ($(checkbox).prop('checked')){
        $(checkbox).prop('checked',false);
        console.log($(checkbox).prop('checked'));
    }
    else{
        $(checkbox).prop('checked',true);
        console.log($(checkbox).prop('checked'));
    }
}

/* DELETE FILE */
function confirmDelete(){
    var seleccionados=$("input:checkbox:checked").length;
    if ( seleccionados > 0){
        if(seleccionados == $("input:checkbox").length){
            Materialize.toast('No se pueden eliminar todos los campos.', 4000);
        }
        else{
            $('#modal_delete').openModal();
        }
    }
    else{
        Materialize.toast('No se ha seleccionado ninguna ficha.', 4000);
    }
}



$('#plantillaForm').submit(function(){
    var campos=[];
    var valid=true;
    $('input:text').each(function(){
        var nombre=$(this).val();
        if($.inArray(nombre, campos)==-1){
            campos.push(nombre);
        }else{
            Materialize.toast('El campo "'+nombre+'" esta duplicado, por favor cambie a uno de nombre..', 4000);
            valid=false;
        }
    });
    return valid;
});


function addFieldPlantilla(){
    $.get('./../aux-html/field-plantilla.html', function(data){
        $('#plantilla').append(data);
        var num=$('#plantilla').children('li').length;
        var last=$('#plantilla').children().last();
        last.children('div').eq(1).children('label').attr('for', 'field'+num).html('Campo '+num);
        last.children('div').eq(1).children('input').attr('id', 'field'+num).attr('name', 'field'+num);

        last.children('div').eq(2).children('label').attr('for', 'plantilla'+num);
        last.children('div').eq(2).children('input').attr('id', 'plantilla'+num);

        $('#fields').val(num);

        last.children('div').find('div.flip').click(function(){
            checkboxToggle('#plantilla'+num);
        });
        last.children('div').find('div.flip').flip({
            axis: 'y',
            trigger: 'click',
            speed: 300
        });
    });
}