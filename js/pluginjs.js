function responsive_jqgrid(jqgrid) {
    jqgrid.find(".ui-jqgrid").addClass("clear-margin span12").css("width", "");
    jqgrid.find(".ui-jqgrid-view").addClass("clear-margin span12").css("width", "");
    jqgrid.find(".ui-jqgrid-view > div").eq(1).addClass("clear-margin span12").css("width", "").css("min-height", "0");
    jqgrid.find(".ui-jqgrid-view > div").eq(2).addClass("clear-margin span12").css("width", "").css("min-height", "0");
    jqgrid.find(".ui-jqgrid-sdiv").addClass("clear-margin span12").css("width", "");
    jqgrid.find(".ui-jqgrid-pager").addClass("clear-margin span12").css("width", "");
}

function setTextAreaForm(form, id){
    
    $tr = form.find("#"+id), 
    $label = $tr.children("td.CaptionTD"),
    $data = $tr.children("td.DataTD");
    $data.attr("colspan", "3");
    $data.children("textarea").css("width", "100%");
    var textAreaId = $data.children("textarea").attr('id')
    tinymce.editors = new Array();
    jQuery('#'+textAreaId).tinymce({
        mode : "none",
        theme : "modern",
        plugins: "table code",
        tools: "inserttable"
    });
}

function noHTMLTags(string){return string.replace(/(<([^>]+)>)/ig,'');}

function imageExist(url) 
{
   var img = new Image();
   img.src = url;
   return (img.height != 0)? true : false;
}
function ajaxFileUpload(id, url, elementId, oper, parentRelationShip, gridId) 
{
    if(jQuery('#'+elementId).val() != ""){
        jQuery("#loading")
        .ajaxStart(function () {
            jQuery(this).show();
        })
        .ajaxComplete(function () {
            jQuery(this).hide();
        });

        jQuery.ajaxFileUpload
        (
            {
                url: url,
                secureuri: false,
                fileElementId: elementId,
                dataType: 'json',
                data: { parentId: id, oper: oper, parentRelationShip: parentRelationShip },
                success: function (data, status) {

                    if (typeof (data.msg) != 'undefined') {
                        if (data.msg == "success") {
                            return;
                        } else {
                            alert(data.error);
                        }
                    }
                    else {
                        return alert('Failed to upload file!');
                    }
                },
                complete: function(response){
                    jQuery('#'+gridId).jqGrid().trigger('reloadGrid');
                },
                error: function (data, status, e) {
                    return alert('Failed to upload file!');
                }
            }
        ) 
    }
 }
