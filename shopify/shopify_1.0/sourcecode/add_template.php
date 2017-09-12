<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'config.php';
require_once 'emarsys.php';
require_once 'database.php';

if(isset($_POST['submit'])){

    $query = "INSERT INTO `emarsys_email_templates` (`store_name`, `templateTitle`, `templateBody`) VALUES ";
    $query .= "('" . trim($_SESSION['shop']) . "', '" . $_POST['templateTitle'] . "', '" . $con->real_escape_string($_POST['templateBody']) . "')";
    $result = $con->query($query);
    if($result){
        header('Location: templates.php');
    }
}

$query = "SELECT * FROM `emarsys_fields`";

$placeholders = $con->query($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Emarsys - Admin</title>
        <style>
        .columns {
            background: #fff;
            padding: 20px;
            border: 1px solid #E7E7E7;
        }
        .columns:after {
            content: "";
            clear: both;
            display: block;
        }
        #contactList {
            list-style-type: none;
            margin: 0 !important;
            padding: 0;
        }
        #contactList li {
            background: #FAFAFA;
            margin-bottom: 1px;
            height: 56px;
            line-height: 56px;
            cursor: pointer;
        }
        #contactList li:nth-child(2n) {
            background: #F3F3F3;
        }
        #contactList li:hover {
            background: #FFFDE3;
            border-left: 5px solid #DCDAC1;
            margin-left: -5px;
        }
        .contact {
            padding: 0 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .contact .u-photo {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }
        #editor1 .h-card {
            background: #FFFDE3;
            padding: 3px 6px;
            border-bottom: 1px dashed #ccc;
        }
        #editor1 {
            border: 1px solid #E7E7E7;
            padding: 0 20px;
            background: #fff;
            position: relative;
        }
        #editor1 .h-card .p-tel {
            font-style: italic;
        }
        #editor1 .h-card .p-tel::before,
        #editor1 .h-card .p-tel::after {
            font-style: normal;
        }
        #editor1 .h-card .p-tel::before {
            content: "(☎ ";
        }
        #editor1 .h-card .p-tel::after {
            content: ")";
        }
        #editor1 h1 {
            text-align: center;
        }
        #editor1 hr {
            border-style: dotted;
            border-color: #DCDCDC;
            border-width: 1px 0 0;
        }
    </style>
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://cdn.ckeditor.com/4.7.1/standard-all/ckeditor.js"></script>
</head>

<body>
	<div id="wrapper">
		<?php require('nav.php'); ?> 
		<div id="page-wrapper">
			<div class="container-fluid">
	            <div class="row">
	                <div class="col-lg-12">
	                    <h1 class="page-header">Email Templates</h1>
                        <a href="templates.php" class="btn btn-default pull-right">Back</a>
	                </div><!-- /.col-lg-12 -->
	            </div><!-- /.row -->
	            <div class="row">
                    <div class="col-lg-9">
                        <form role="form" method="POST">
                            <div class="form-group">
                                <label>Template Title</label>
                                <input class="form-control" name="templateTitle">
                                <p class="help-block">Title for the Template</p>
                            </div>
                            <textarea name="templateBody" id="editor1" rows="50" cols="80" contenteditable="true">
                                
                            </textarea>
                            <hr>
                            <button type="submit" name="submit" class="btn btn-default">Submit</button>
                        </form><!--form end-->
                    </div>
                    <div class="col-lg-3">
                        <div class="contacts">
                            <h4>Placeholders</h4>
                            <?php if($placeholders->num_rows > 0): $i = 0; $raw = []?>
                            <ul id="contactList" style="max-height: 600px;
                    overflow-y:scroll;">
                                    <?php while($row = $placeholders->fetch_assoc()):?>
                                    <?php $raw[] = $row['fieldEmarsysName']; ?>
                                    <li>
                                        <div class="contact h-card" data-contact="<?= $i ?>" draggable="true" tabindex="0"><?= $row['fieldName']; ?></div>
                                    </li>
                                    <?php $i++; endwhile; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>
	            </div><!-- /.row -->
	        </div><!-- /.container-fluid -->
		</div><!-- /#page-wrapper -->
	</div><!-- /#wrapper -->

    <script>
        'use strict';
        var CONTACTS = [
            <?php foreach($raw as $val): ?>
            { string_id: '$<?= $val ?>$'},
            <?php endforeach; ?>
        ];
        CKEDITOR.disableAutoInline = true;

        // Implements a simple widget that represents contact details (see http://microformats.org/wiki/h-card).
        CKEDITOR.plugins.add( 'hcard', {
            requires: 'widget',

            init: function( editor ) {
                editor.widgets.add( 'hcard', {
                    allowedContent: 'span(!h-card); a[href](!u-email,!p-name); span(!p-tel)',
                    requiredContent: 'span(h-card)',
                    pathName: 'hcard',

                    upcast: function( el ) {
                        return el.name == 'span' && el.hasClass( 'h-card' );
                    }
                } );

                // This feature does not have a button, so it needs to be registered manually.
                editor.addFeature( editor.widgets.registered.hcard );

                // Handle dropping a contact by transforming the contact object into HTML.
                // Note: All pasted and dropped content is handled in one event - editor#paste.
                editor.on( 'paste', function( evt ) {
                    var contact = evt.data.dataTransfer.getData( 'contact' );
                    if ( !contact ) {
                        return;
                    }

                    evt.data.dataValue =
                        '' +
                            '' + contact.string_id + '' +
                        '';
                } );
            }
        } );

        CKEDITOR.on( 'instanceReady', function() {
            // When an item in the contact list is dragged, copy its data into the drag and drop data transfer.
            // This data is later read by the editor#paste listener in the hcard plugin defined above.
            CKEDITOR.document.getById( 'contactList' ).on( 'dragstart', function( evt ) {
                // The target may be some element inside the draggable div (e.g. the image), so get the div.h-card.
                var target = evt.data.getTarget().getAscendant( 'div', true );

                // Initialization of the CKEditor data transfer facade is a necessary step to extend and unify native
                // browser capabilities. For instance, Internet Explorer does not support any other data type than 'text' and 'URL'.
                // Note: evt is an instance of CKEDITOR.dom.event, not a native event.
                CKEDITOR.plugins.clipboard.initDragDataTransfer( evt );

                var dataTransfer = evt.data.dataTransfer;

                // Pass an object with contact details. Based on it, the editor#paste listener in the hcard plugin
                // will create the HTML code to be inserted into the editor. You could set 'text/html' here as well, but:
                // * It is a more elegant and logical solution that this logic is kept in the hcard plugin.
                // * You do not know now where the content will be dropped and the HTML to be inserted
                // might vary depending on the drop target.
                dataTransfer.setData( 'contact', CONTACTS[ target.data( 'contact' ) ] );

                // You need to set some normal data types to backup values for two reasons:
                // * In some browsers this is necessary to enable drag and drop into text in the editor.
                // * The content may be dropped in another place than the editor.
                dataTransfer.setData( 'text/html', target.getText() );
            } );
        } );

        // Initialize the editor with the hcard plugin.
        CKEDITOR.replace( 'editor1', {
            extraPlugins: 'hcard,sourcedialog,justify'
        } );
    </script>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
    <script src="data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>