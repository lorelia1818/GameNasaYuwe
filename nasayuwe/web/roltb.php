<?php
    include_once "menu.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/rol.php";
    $oRol = new Roles();
?>
<style>
.fontawesomeicon::before {
    display: inline-block;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
 }

.File-Csv::before {
   font: var(--fa-font-solid);
    content: ' \f6dd';
 }

.btn {
		line-height: 40px;
		display: inline-block;
		padding: 0 25px;
		cursor: pointer;
		color: #fff;
		font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
		-webkit-transition: all 0.4s ease;
		-o-transition: all 0.4s ease;
		-moz-transition: all 0.4s ease;
		transition: all 0.4s ease;
		font-size: 14px;
		font-weight: 700;
	}


	.btn--blue {
		background: #3d6bbd;
	}

	.p-t-30 {
  		padding-top: 30px;
	}

.demo{ font-family: 'Noto Sans', sans-serif; }

button.dt-button, div.dt-button, a.dt-button {
  padding: 0.2em 0.5em !important;
}
div.dt-buttons {
  margin-left: 15px !important;
}

</style>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Roles</title>
    <!-- Bootstrap core JavaScript -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <script type="text/javascript" src="/nasayuwe/js/jquery_3.3.1_jquery.min.js"></script>
    <script type="text/javascript" src="/nasayuwe/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/nasayuwe/js/cdn.datatables.net_buttons_1.5.6_js_dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="/nasayuwe/js/cdnjs.cloudflare.com_ajax_libs_jszip_3.1.3_jszip.min.js"></script>
    <script type="text/javascript" src="/nasayuwe/js/cdnjs.cloudflare.com_ajax_libs_pdfmake_0.1.53_pdfmake.min.js"></script>
    <script type="text/javascript" src="/nasayuwe/js/cdn.datatables.net_buttons_1.5.6_js_buttons.html5.min.js"></script>
    <link href="/nasayuwe/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="/nasayuwe/css/cdn.datatables.net_buttons_1.5.6_css_buttons.dataTables.min.css" />
    <script type="text/javascript" src="/nasayuwe/js/cdn.datatables.net_buttons_1.5.6_js_buttons.flash.min.js"></script>
  </head>
  <body>
    <!-- Navigation -->
    <section class="showcase">
    <div class="container" style="width:40%;">
        <div style="background:#ffffff;" >
          <span style="font-size:40px;color:#3d6bbd;font-weight:bold">Roles</span>
        </div>
        <div style="background:#3d6bbd;" class="row">
          <div style="padding-top: 0px;">
          </div>
          <br>
          <div class="col-lg-12">
            <div class="panel-body table-responsive">
              <table id="render-data" class="display" style="width:100%">
                <thead bgcolor="#eeeeee" align="center">
                  <tr>
                    <th style="font-weight:bold;font-family: Calibri;font-size=16px;width:15%">Roles</th>
                    <th style="font-weight:bold;font-family: Calibri;font-size=16px;width:1%">Acciones</th>
                  </tr>
                </thead>
                <thead bgcolor="#eeeeee">
                  <tr> 
                    <td style="font-weight:bold;font-family: Calibri;font-size=16px;"><input style='margin-left:-10px;width:390px;' type='text' id='searchByRol' placeholder='Search Rol'></td>
                    <td style="font-weight:bold;font-family: Calibri;font-size=16px;">&nbsp;</td>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script type="text/javascript">
      $(document).ready(function() {
        var table = $('#render-data').DataTable({
          rowReorder: {
              selector: 'td:nth-child(1)'
          },
          responsive: true,
            "language": {
              "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },
            "paging": true,
            "scrollX": true,
            "scrolly": true,
            "processing": true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
            'url':'/nasayuwe/php/roldb.php',
            error: function(jqXHR, ajaxOptions, thrownError) {
              alert(thrownError + "\r\n" + jqXHR.statusText + "\r\n" + jqXHR.responseText + "\r\n" + ajaxOptions.responseText);
            },
            'data': function(data){
              // Read values
              var rol = $('#searchByRol').val();

              // Append to data
              data.searchByRol = rol;
            }
          },
            'columns': [
              { data: 'user_ro_description', render: function (p_rol) {
                  return '<font style="font-family:Calibri; font-size:12pt">'+p_rol+ '</font>';
                        }},
              { className: 'dt-center', data: 'user_ro_id',
                          render: function (p_idRol) {
                          return '<a href="rol.php?user_ro_id='+p_idRol+'" data-tip="Modificar"><i class="fa fa-edit" style="font-size:24px"></i></a>';
                        },
                        defaultContent: "No image",
                        title: "Acciones"
                    }
            ],
            dom: 'lBtp',
            buttons: [
                'excel',  'pdf',
                {
                  className: "addNewRol",
                  text: '<i style="font-weight:bold;font-size:28px; color:#CB1100;" class="fa fa-plus-circle fa-x5"></i>',
                  action: function ( e, dt, node, config ) {
                    window.location = 'rol.php';
                  }
                },
                {
                  className: "addNewPrincipal",
                  text: '<i style="font-weight:bold;font-size:28px; color:#000;" class="fa fa-home fa-x5"></i>',
                  action: function ( e, dt, node, config ) {
                    window.location = 'principal.php';
                  }
                }
            ],

            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        } );

        $('#searchByRol').keyup(function(){
          table.draw();
        });
      } );
    </script>
  </body>
</html>