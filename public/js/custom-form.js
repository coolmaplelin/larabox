var totalFormFields = 0;
var FormFields = [];

$().ready(function() {
    var $formFieldInput = $('.customformme');
        
    if ($formFieldInput.val() != '') {
        FormFields = $.parseJSON($formFieldInput.val());
        totalFormFields = FormFields.length;
        for (var i = 0; i < FormFields.length; i++) {
            addFormElement(i);
        }
    }

    $("#formElementEditor .btn-save").click(function(){
        updateFormElementContainer();
        $("#formElementEditor").modal('toggle');
    });

    $("#nav-container").sortable({
        stop: function(event, ui){saveFormFields();}
    });  
});

function FormFieldObj(title, type, options, help, manda, active) {
    this.title = title;
    this.type = type;
    this.options = options;
    this.help = help;
    this.manda = manda;
    this.active = active;
}

function printFormField(id)
{
    var FormFieldItem = FormFields[id];

    var title = FormFieldItem.title;
    var type = FormFieldItem.type;
    var options = FormFieldItem.options;
    var help = FormFieldItem.help;
    var manda = FormFieldItem.manda;
    var active = FormFieldItem.active;
    
    var writeString = "<div class='form-group'>";
    
    if(title != "")
                    writeString += "<label " +  (manda == "1" ? "class='required'" : "") + ">" + title +  "</label>";
            else
                    writeString += "[No Label Supplied]";

    switch(type)
    {
        case "text":
        case "email": 
                writeString += "<input type='text' class='form-control' />";
                break;
        case "textbox": writeString += "<textarea type='text' class='form-control' ></textarea>";
                break;
        case "select":
                var fullArray = options.split("\n");
                writeString += "<select class='form-control'>";
                for(var i = 0; i < fullArray.length; i++)
                {
                    if(fullArray[i] != "")
                        writeString += "<option>" + fullArray[i] + "</option>";
                }
                writeString += "</select>";
                break;
        case "radio":
                var fullArray = options.split("\n");
                for(var i = 0; i < fullArray.length; i++)
                {
                    if(fullArray[i] != "")
                        writeString += "<div class='radio'><label><input type='radio' /> " + fullArray[i] + "</label></div>";
                }
                break;
        case "checkbox":
                var fullArray = options.split("\n");
                for(var i = 0; i < fullArray.length; i++)
                {
                    if(fullArray[i] != "")
                        writeString += "<div class='checkbox'><label><input type='checkbox' /> " + fullArray[i] + "</label></div>";
                }
                break;
        case "image":
                writeString += '<br/><label class="btn btn-default btn-file">Browse <input type="file" hidden> </label>';
                break;
    }

    writeString += "<p class='help-block'>" + help + "</p>";

    writeString += "</div>";

    return writeString;
}
    
function addFormElement(id)
{
    console.log(FormFields);
    var FormFieldItem = FormFields[id];
    var data_id = id;
    var active = FormFieldItem.active;

    var fullID = 'nav-' + data_id;

    var newLine = '<li id="' + fullID + '" class="nav-item ' + (active == 1 ? '' :'inactive') + '" data-id="' + data_id + '">';
    
    var buttons = '<button type="button" class="btn btn-default btn-edit btn-xs">'
                  + '   <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
                  + '</button>'
                  + '<button type="button" class="btn btn-default btn-delete btn-xs">'
                  + '   <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'
                  + '</button>';

    newLine += '<div class="controls">' + buttons + '</div>';
    newLine += '<div class="fielddemo">' + printFormField(id) + '</div>';
    newLine += '</li>';

    $("#nav-container").append(newLine);

    $('#' + fullID + ' .btn-edit').click(function(){
        openFormFieldEditor(fullID);
        return false;
    });

    $('#' + fullID + ' .btn-delete').click(function(){
        deleteFormField(fullID); 
        return false;
    });

}        
      

function openFormFieldEditor(nav_id = '')
{
    if (nav_id == '') {

        //New form element
        $("#formElementEditor .modal-title").html('New Form Element');
        $("#formElementEditor input[type='hidden']").val('');
        $("#formElementEditor input[type='text']").val('');
        $("#formElementEditor textarea").val('');
        $("#formElementEditor select.type").val("text");
        $("#formElementEditor select.manda").val("1");
        $("#formElementEditor select.active").val("1");
    }else {

        //Edit form element
        var data_id = $("#" + nav_id).data('id');
        var FormFieldItem = FormFields[data_id];

        $("#formElementEditor .modal-title").html('Edit Form Element');
        $("#formElementEditor .nav_id").val(nav_id);
        $("#formElementEditor .title").val(FormFieldItem.title);
        $("#formElementEditor .type").val(FormFieldItem.type);
        $("#formElementEditor .options").val(FormFieldItem.options);
        $("#formElementEditor .help").val(FormFieldItem.help);
        $("#formElementEditor .manda").val(FormFieldItem.manda);
        $("#formElementEditor .active").val(FormFieldItem.active);
    }     

    $("#formElementEditor").modal('show');
}


function updateFormElementContainer()
{
    var nav_id = $("#formElementEditor .nav_id").val();
    var title = $("#formElementEditor .title").val();
    var type = $("#formElementEditor .type").val();
    var options = $("#formElementEditor .options").val();
    var help = $("#formElementEditor .help").val();
    var manda = $("#formElementEditor .manda").val();
    var active = $("#formElementEditor .active").val();

    if (nav_id == '') {
        //New form element
        var FormFieldItem = new FormFieldObj(title, type, options, help, manda, active, '');
        FormFields.push(FormFieldItem);

        totalFormFields = FormFields.length;
        var data_id = totalFormFields - 1;
        addFormElement(data_id);

    }else{
        //Update form element
        var data_id = $("#" + nav_id).data('id');
        var FormFieldItem = FormFields[data_id];

        FormFieldItem.title = title;
        FormFieldItem.type = type;
        FormFieldItem.options = options;
        FormFieldItem.help = help;
        FormFieldItem.manda = manda;
        FormFieldItem.active = active;

        $("#" + nav_id + " .fielddemo").html(printFormField(data_id));

        if (active == "1" && $("#" + nav_id).hasClass('inactive') || active == "0" && !$("#" + nav_id).hasClass('inactive')) {
            $("#" + nav_id).toggleClass('inactive');
        }
    }

    saveFormFields();
}

function deleteFormField(nav_id)
{

    if(confirm("Are you sure you want to remove this item?"))
    {
        var data_id = $("#" + nav_id).data('id');
        FormFields.splice(data_id, 1);
        $("#" + nav_id).remove();

        if(data_id < (totalFormFields - 1)){
            $("#nav-container li.nav-item").each(function(){
                var data_id = $(this).attr('data-id');
                if(data_id > id){
                    $(this).attr('data-id', data_id - 1);
                }

            })
        }
        totalFormFields--;

        saveFormFields();
    }
}        

function saveFormFields()
{
    var myFormFields = [];
    $("#nav-container li.nav-item").each(function(){
        var id = $(this).attr('data-id');
        if(id != undefined){
            var FormFieldItem = new FormFieldObj(FormFields[id].title, FormFields[id].type, FormFields[id].options, FormFields[id].help, FormFields[id].manda, FormFields[id].active);
            myFormFields.push(FormFieldItem);
        }
    })

    var myJSONText = JSON.stringify(myFormFields);

    $(".customformme").val(myJSONText);
}
