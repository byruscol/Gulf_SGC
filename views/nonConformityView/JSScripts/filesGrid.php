<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once "../../../helpers/Grid.php";
require_once "../../class.buildView.php";
header('Content-type: text/javascript');
?>
    
jQuery('#uploadFiles')
  .submit( function( e ) {
    
    e.preventDefault();
    var rowid = jQuery("#nonConformity").jqGrid("getGridParam", "selrow");
    if(rowid){
        var form = new FormData( this );
        form.append("parentId", rowid);
        jQuery.ajax( {
            url: '<?php echo $pluginURL;?>edit.php?controller=files',
            type: 'POST',
            data: form,
            processData: false,
            contentType: false,
            beforeSend: function(jqXHR, settings){
                    jQuery("#loading").dialog('open');
                },
            success: function(response, textStatus, jqXHR){
                data = jQuery.parseJSON( response );
                if (data.msg != 'success')
                {
                    alert(data.error);
                }
                else
                {
                    jQuery("#files").jqGrid().trigger("reloadGrid");
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log("A JS error has occurred.");
            },
            complete: function(jqXHR, textStatus){
                jQuery("#uploadFiles")[0].reset();
                jQuery("#loading").dialog('close');
            }
        } );
    }
    else{
        jQuery("<div>"+jQuery.jgrid.nav.alerttext+"</div>").dialog({
            height: 100,
            width: 200,
            modal: true,
            closeOnEscape: true,
            title: jQuery.jgrid.nav.alertcap
          });
    }
    
    return false;
  } );
<?php
$params = array("numRows" => 10, "sortname" => "fileName", "postData" => array("method" => "getNonConformitiesFiles"));
$view = new buildView("files", $params, "files");
?>

