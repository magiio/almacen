@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE ARTICULOS
    </div>
        <div class="boton_titulo">
        <a id="nuevo" class="btn btn-success" href="#">
        <i class="fa fa-plus"></i> Nuevo articulo</a>
    </div>
@stop

@section('main-content')
        <div class="box tabla-articulos">
            <div class="box-body no-padding"> 

                <table class="table table-striped table-bordered accionstyle"  cellspacing="0" width="100%" id="articulos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Articulo</th>
                            <th>Unidad</th>
                            <th>Usuario</th>
                            <th>Rubro</th>
                            <th>Subrubro</th>
                            <th>Subrubro</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID </th>
                            <th>Articulo</th>
                            <th>Unidad</th>
                            <th>Usuario</th>
                            <th>Rubro</th>
                            <th>Subrubro</th>
                            <th>Subrubro</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @include('configuraciones.modalsArticulos.create')

        <script>
            $(document).ready(function(){
                $('#articulos').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/articulos/tabla",
                    "error": function () {
                        alert( 'Custom error' );
                      },
                    "columns":[
                        {data: 'id_articulo'},
                        {data: 'descripcion'},
                        {data: 'unidad'},
                        {data: 'usuario'},
                        {data: 'id_rubro'},
                        {data: 'id_subrubro'},
                        {data: 
                            function(data) {
                            return '<a href="#edit-' + data.id_articulo + '" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i></a><a href="#edit-' + data.id_articulo + '" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a>';
                            }, "orderable": false, "searchable": false,
                        },
                    ],

                    "language":{
                        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                    }
                });
                //SELECT2 FAMILIA-SUBFAMILIA-------------------------------------------
                $(".unidades").select2({
                    language: "es",
                });
                 $.getJSON("/rubros", function (json) {
                      $(".rubros").select2({
                            data: json,
                            language: "es",
                      });
                 });
                 $(".subrubros").select2();
                 $(".subrubros").prop("disabled", true);
                 $('.rubros').on("select2:select", function(e) { 
                    id = $(".rubros").val();
                    $(".subrubros").select2().empty()
                    $(".subrubros").prop("disabled", false);
                    $.getJSON("/subrubros/id=" + id, function (json) {
                      $(".subrubros").select2({
                            data: json,
                            language: "es",

                        });
                    });
                });
                //FIN SELECT2 FAMILIA-SUBFAMILIA
            });
        </script>
         <script>
            $(function(){
                $('#nuevo').click(function() {
                    $('#myModal').modal();
                });
                $('.close').click(function() {
                    $('#myModal').modal('hide');
                });
                 
                $(document).on('submit', '#formRegister', function(e) {  
                    e.preventDefault();
                     
                    $('input+small').text('');
                    $('input').parent().removeClass('has-error');
                     
                    $.ajax({
                        method: $(this).attr('method'),
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: "json"
                    })
                    .done(function(data) {
                        $('.alert-success').removeClass('hidden');
                        $('#myModal').modal('hide');
                    })
                    .fail(function(data) {
                        $.each(data.responseJSON, function (key, value) {
                            var input = '#formRegister input[name=' + key + ']';
                            $(input + '+small').text(value);
                            $(input).parent().addClass('has-error');
                        });
                    });
                });
            })
    </script>


    @endsection