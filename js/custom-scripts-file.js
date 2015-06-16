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

    $('#createFile').click(function(){
        createFile();
    });

    $('#deleteFile').click(function(){
        confirmDelete();
    });

    $('#seeFile').click(function(){
        seeFiles();
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

/* CREATE FILE (Creacion de plantilla) */
function createFile(){
    var wrapper=$('#file-wrapper');
    $('.material-tooltip').each(function(){
        $(this).remove();
    });
    $('#action-button-wrapper').html('');
    $('#return').remove();
    $('#editPlantilla').remove();
    wrapper.load('./../aux-html/createFile.html', function(){  });
}

function addFieldCreate(){
    var num=$('#createFileWrapper').children().length + 1;
    $.get('./../aux-html/field-required.html', function(data){
        $('#createFileWrapper').append(data);
        var last=$('#createFileWrapper').children().last();
        last.children('input').attr('id', 'field'+num).attr('name', 'field'+num);
        last.children('label').attr('for', 'field'+num).html('Campo '+num);
        $('#numFields').val(num);
    });
}
function removeFieldCreate(){
    var num=$('#createFileWrapper').children().length - 1;
    var last=$('#createFileWrapper').children().last();
    last.remove();
    $('#numFields').val(num);
}

/* ADD FILE */
function addFile(fileCreated, fields){
    if (fileCreated!=undefined){
        console.log(fileCreated)
        if (fileCreated===true){
            var wrapper=$('#file-wrapper');
            $('.material-tooltip').each(function(){
                $(this).remove();
            });
            $('#action-button-wrapper').html('');
            $('#return').remove();
            $('#editPlantilla').remove();
            wrapper.load('./../aux-html/addFile.html', function(){
                $('#numFields').val(fields.length);
                var i=1;
                addFieldAdd(i, fields);
            });
        }
        else{
            Materialize.toast('Aun no se ha creado una plantilla, cree una plantilla primero.', 4000);
        }
    }
}

function addFieldAdd(num, fields){
    if (num<fields.length){
        $.get('./../aux-html/field.html', function(data){
            $('#addFileWrapper').append(data);
            var last=$('#addFileWrapper').children().last();
            last.children('input').attr('id', 'value'+num).attr('name', 'value'+num);
            last.children('label').attr('for', 'value'+num).html(fields[num]);
            num++;
        }).done(function(){
            addFieldAdd(num, fields);
        });
    }
}


/* DELETE FILE */
function confirmDelete(){
    if ($("input:checkbox:checked").length > 0){
        $('#modal_delete').openModal();
    }
    else{
        Materialize.toast('No se ha seleccionado ninguna ficha.', 4000);
    }
}


/* EDIT FILE */
function editFile(fields){
    if ($("input:checkbox:checked").length == 1){
        var wrapper=$('#file-wrapper');
        $('.material-tooltip').each(function(){
            $(this).remove();
        });
        $('#action-button-wrapper').html('');
        $('#return').remove();
        $('#editPlantilla').remove();
        var values=[];
        var v=$("input:checkbox:checked").parent('div.secondary-content').siblings('p.field-value').length
        for(i=0; i<v; i++){
            values[i]=$("input:checkbox:checked").parent('div.secondary-content').siblings('p.field-value').eq(i).html()
        }
        var item=$("input:checkbox:checked").val();
        wrapper.load('./../aux-html/editFile.html', function(){
            $('#numFields').val(fields.length);
            $('#item_id').val(item);
            console.log($('#item_id').val());
            var i=1;
            addFieldEdit(i, fields, values);
        });

    }
    else if ($("input:checkbox:checked").length == 0){
        Materialize.toast('No se ha seleccionado ninguna ficha.', 4000);
    }
    else{
        Materialize.toast('Por favor seleccione solo UNA ficha para modificar.', 4000);
    }
}

function addFieldEdit(num, fields, values){
    if (num<fields.length){
        $.get('./../aux-html/field.html', function(data){
            $('#editFileWrapper').append(data);
            var last=$('#editFileWrapper').children().last();
            last.children('label').attr('for', 'value'+num).html(fields[num]).addClass('active');
            last.children('input').attr('id', 'value'+num).attr('name', 'value'+num).val(values[(num-1)]);
            num++;
        }).done(function(){
            addFieldEdit(num, fields, values);
        });
    }
}

/* SEE FILES */
function seeFiles(){
    var selected=$("input:checkbox:checked").length
    if (selected >= 1){
        var value='';
        var url='?files='+selected
        for(i=0; i<$("input:checkbox:checked").length; i++){
            value=$("input:checkbox:checked").eq(i).val();
            url=url+'&file'+i+'='+value
        }
        window.location = "./../pages/fichas.php"+url;
    }
    else if ($("input:checkbox:checked").length == 0){
        Materialize.toast('No se ha seleccionado ninguna ficha.', 4000);
    }
}












