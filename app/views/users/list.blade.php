@extends ('layouts.admin')

<!-- Contenido -->
@section ('content')
<div id="page-content">
    <!-- Inbox Header -->
    <div class="content-header">
        <div class="header-section">
            <h1><i class="gi gi-notes_2"></i>Clientes<br><small>Listado y modificacion</small></h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Panel de control</li>
        <li>Clientes</li>
    </ul>
    <!-- END Inbox Header -->

    <!-- Inbox Content -->
    <div class="row">

        <!-- Messages List -->
        <div class="col-md-12">
            <!-- Messages List Block -->
            <div class="block">
                <!-- Messages List Title -->
                <div class="block-title">
                    <h2>Clientes</h2>
                </div>
                <!-- END Messages List Title -->

                <!-- Messages List Content -->
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped table-condensed table-customers-report">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Ciudad</th>
                                <th>Estado</th>
                                <th>Direccion</th>
                                <th>Telfono</th>
                                <th>Interes</th>
                                <th>Tipo</th>
                                <th>Estatus</th>
                                <th width="40"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- END Messages List Content -->
            </div>
            <!-- END Messages List Block -->
        </div>
        <!-- END Messages List -->
    </div>
    <!-- END Inbox Content -->

</div>
@stop
<!-- /Contenido -->

<!-- Dialogos -->
@section ('dialogs')
    <!-- User Settings, modal which opens from Settings link (found in top right user menu) and the Cog link (found in sidebar user info) -->
    <div id="modal-user-detail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Informacion de usuario</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <ul data-toggle="tabs" class="nav nav-tabs push">
                        <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                        <li class=""><a href="#facturacion" data-toggle="tab">Facturacion</a></li>
                        <li class=""><a href="#envio" data-toggle="tab">Envio</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="general" class="tab-pane active">
                            <form action="#" method="post" id="form-user-general-info" name="form-user-general-info" class="form-horizontal form-bordered">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="col-md-3">Nombre</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="name" id="name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-md-3">Password</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="password" id="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="col-md-3">Telefono</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="phone" id="phone">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="birthday" class="col-md-3">Nacimiento</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="birthday" id="birthday">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="col" class="col-md-3">Colonia</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="col" id="col">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="cp" class="col-md-3">C.P.</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="cp" id="cp">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country" class="col-md-3">Pais</label>
                                            <div class="col-md-9">
                                                <select size="1" class="form-control" name="country" id="country">
                                                    <option value="0">Seleccionar</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="type" class="col-md-3">Tipo</label>
                                            <div class="col-md-9">
                                                <select size="1" class="form-control" name="type" id="type">
                                                    <option value="0">Seleccionar</option>
                                                    <option value="1">Publico</option>
                                                    <option value="2">Medio mayorista</option>
                                                    <option value="3">Mayorista</option>
                                                    <option value="4">Distribuidor</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="col-md-3">Email</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="email" id="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lada" class="col-md-3">Lada</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="lada" id="lada">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender" class="col-md-3">Genero</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="gender" id="gender">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-md-3">Direccion</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="address" id="address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="city" class="col-md-3">Ciudad</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="city" id="city">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="state" class="col-md-3">Estado</label>
                                            <div class="col-md-9">
                                                <select size="1" class="form-control" name="state" id="state">
                                                    <option value="0">Seleccionar</option>
                                                    @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="interest" class="col-md-3">Interes</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="interest" id="interest">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status" class="col-md-3">Estatus</label>
                                            <div class="col-md-9">
                                                <select size="1" class="form-control" name="status" id="status">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="facturacion" class="tab-pane">
                            <form action="#" method="post" id="form-user-facturacion-info" name="form-user-facturacion-info" class="form-horizontal form-bordered">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="razon_social" class="col-md-3">Razon social</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="razon_social" id="razon_social">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tipo" class="col-md-3">Tipo</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="tipo" id="tipo">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="cp" class="col-md-3">C.P.</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="cp" id="cp">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="city" class="col-md-3">Ciudad</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="city" id="city">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country" class="col-md-3">Pais</label>
                                            <div class="col-md-9">
                                                <select size="1" class="form-control" name="country" id="country">
                                                    <option value="0">Seleccionar</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rfc" class="col-md-3">R.F.C.</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="rfc" id="rfc">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-md-3">Direccion</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="address" id="address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="colonia" class="col-md-3">Colonia</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="colonia" id="colonia">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="state" class="col-md-3">Estado</label>
                                            <div class="col-md-9">
                                                <select size="1" class="form-control" name="state" id="state">
                                                    <option value="0">Seleccionar</option>
                                                    @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="envio" class="tab-pane">
                            <form action="#" method="post" id="form-user-envio-info" name="form-user-envio-info" class="form-horizontal form-bordered">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address" class="col-md-3">Direccion</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="address" id="address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="colonia" class="col-md-3">Colonia</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="colonia" id="colonia">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country" class="col-md-3">Pais</label>
                                            <div class="col-md-9">
                                                <select size="1" class="form-control" name="country" id="country">
                                                    <option value="0">Seleccionar</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cp" class="col-md-3">C.P.</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="cp" id="cp">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ciudad" class="col-md-3">Ciudad</label>
                                            <div class="col-md-9">
                                                <input readonly type="text" class="form-control" name="ciudad" id="ciudad">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="state" class="col-md-3">Estado</label>
                                            <div class="col-md-9">
                                                <select size="1" class="form-control" name="state" id="state">
                                                    <option value="0">Seleccionar</option>
                                                    @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--
                    <form action="user" method="post" id="form-user-add" name="form-user-add" class="form-horizontal form-bordered">
                        <fieldset>
                            <legend>Informacion general</legend>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="user-settings-username">Username</label>
                                <div class="col-md-8">
                                    <input type="text" id="username" name="username" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="first-name">Nombre</label>
                                <div class="col-md-8">
                                    <input type="text" id="first-name" name="first-name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="level">Nivel</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="level" id="level">
                                        <option selected="" value="1">Administrador</option>
                                        <option value="2">Sub-Administrador</option>
                                        <option value="3">Consultor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="password">Contraseña</label>
                                <div class="col-md-8">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="repassword">Confirmar</label>
                                <div class="col-md-8">
                                    <input type="password" id="repassword" name="repassword" class="form-control" placeholder="Confirmar">
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group form-actions">
                            <div class="col-xs-12 text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-sm btn-primary">Agregar</button>
                            </div>
                        </div>
                    </form>
                    -->
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END User Settings -->
@stop
<!-- /Dialogos -->

<!-- Scripts adicionales -->
@section ('scripts')
    @parent
    {{ HTML::script('js/pages/customers.report.js') }}
    <script>CustomersReportData.init();</script>
@stop