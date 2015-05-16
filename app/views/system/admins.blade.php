@extends ('layouts.admin')

<!-- Contenido -->
@section ('content')
<div id="page-content">
    <!-- Inbox Header -->
    <div class="content-header">
        <div class="header-section">
            <h1><i class="gi gi-notes_2"></i>Administradores<br><small>Listado y modificacion</small></h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Panel de control</li>
        <li>Sistema</li>
        <li>Administradores</li>
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
                    <h2>Administradores</h2>
                    <div class="block-options pull-right">
                        <div class="btn-group btn-group-sm">
                            <a title="" data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle enable-tooltip" href="javascript:void(0)" data-original-title="Opciones"><span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                                <li>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-user-add"><i class="gi gi-user_add pull-right"></i> Agregar administrador</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END Messages List Title -->

                <!-- Messages List Content -->
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped table-condensed table-admin-report">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Nivel</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                            <tr id="_uid_{{ $admin->id }}">
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->username }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>
                                    <select id="level" name="level" data-uid="{{ $admin->id }}">
                                        <option value="1" {{ $admin->admins_level_id==1?'selected':'' }}>Administrador</option>
                                        <option value="2" {{ $admin->admins_level_id==2?'selected':'' }}>Sub-Administrador</option>
                                        <option value="3" {{ $admin->admins_level_id==3?'selected':'' }}>Consultor</option>
                                    </select>
                                </td>
                                <td>
                                    <select id="status" name="status" data-uid="{{ $admin->id }}">
                                        <option value="1" {{ $admin->status==1?'selected':'' }}>Activo</option>
                                        <option value="0" {{ $admin->status==0?'selected':'' }}>Inactivo</option>
                                    </select>
                                </td>
                                <td><button class="btn btn-xs btn-danger btn-del-admin" data-uid="{{ $admin->id }}"><i class="fa fa-times"></i></button></td>
                            </tr>
                            @endforeach
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
        <div id="modal-user-add" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="gi gi-user_add"></i> Nuevo administrador</h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">
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
                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>
        <!-- END User Settings -->
@stop
<!-- /Dialogos -->

<!-- Scripts adicionales -->
@section ('scripts')
    @parent
    {{ HTML::script('js/pages/sys_admins.js') }}
    <script>SysAdmins.init();</script>
@stop