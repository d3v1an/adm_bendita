@extends ('layouts.admin')

<!-- Contenido -->
@section ('content')
<div id="page-content">
    <!-- Inbox Header -->
    <div class="content-header">
        <div class="header-section">
            <h1><i class="gi gi-facetime_video"></i>Videos<br><small>Listado y modificacion</small></h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Panel de control</li>
        <li>Media</li>
        <li>Videos</li>
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
                    <h2>Videos</h2>
                    <div class="block-options pull-right">
                        <div class="btn-group btn-group-sm">
                            <a title="" data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle enable-tooltip" href="javascript:void(0)" data-original-title="Opciones"><span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                                <li>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-video-add"><i class="gi gi-circle_plus pull-right"></i> Agregar video</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END Messages List Title -->

                <!-- Messages List Content -->
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped table-condensed table-video-report">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Etiqueta</th>
                                <th>Link</th>
                                <th>Estatus</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($videos as $video)
                            <tr id="_v_{{ $video->id }}">
                                <td class="vname">{{ $video->name }}</td>
                                <td class="vlabel">{{ $video->label }}</td>
                                <td class="vlink">{{ $video->link }}</td>
                                <td>
                                    <select id="status" name="status" data-id="{{ $video->id }}">
                                        <option value="1" {{ $video->status==1?'selected':'' }}>Activo</option>
                                        <option value="0" {{ $video->status==0?'selected':'' }}>Inactivo</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <button class="btn btn-default" data-cmd='edit' data-id="{{ $video->id }}"><i class="gi gi-pencil"></i></button>
                                        <button class="btn btn-danger" data-cmd='del' data-id="{{ $video->id }}"><i class="fa fa-times"></i></button>
                                    </div>
                                </td>
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
        <!-- Dialogo para la edicion de videos -->
        <div id="modal-video-add" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="gi gi-facetime_video"></i> Nuevo video</h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="{{ URL::to('media/video/add') }}" method="post" id="form-video-add" name="form-video-add" class="form-horizontal form-bordered">
                            <fieldset>
                                <legend>Informacion general</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name">Nombre</label>
                                    <div class="col-md-8">
                                        <input type="text" id="name" name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="label">Etiqueta</label>
                                    <div class="col-md-8">
                                        <input type="text" id="label" name="label" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="link">Link</label>
                                    <div class="col-md-8">
                                        <input type="text" id="link" name="link" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="link">Estatus</label>
                                    <div class="col-md-8">
                                        <select name="status" id="status" class="form-control">
                                            <option selected="" value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
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
        <!-- /Dialogo para la edicion de videos -->

        <!-- Dialogo para la edicion de videos -->
        <div id="modal-video-edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="gi gi-facetime_video"></i> Edicion de video</h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="{{ URL::to('media/video/edit') }}" method="post" id="form-video-edit" name="form-video-edit" class="form-horizontal form-bordered">
                            <input type="hidden" id="id" name="id">
                            <fieldset>
                                <legend>Informacion general</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name">Nombre</label>
                                    <div class="col-md-8">
                                        <input type="text" id="name" name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="label">Etiqueta</label>
                                    <div class="col-md-8">
                                        <input type="text" id="label" name="label" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="link">Link</label>
                                    <div class="col-md-8">
                                        <input type="text" id="link" name="link" class="form-control">
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group form-actions">
                                <div class="col-xs-12 text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>
        <!-- /Dialogo para la edicion de videos -->
@stop
<!-- /Dialogos -->

<!-- Scripts adicionales -->
@section ('scripts')
    @parent
    {{ HTML::script('js/pages/media.videos.js') }}
    <script>MediaData.init();</script>
@stop