@extends ('layouts.admin')

<!-- Contenido -->
@section ('content')
<div id="page-content">
    <!-- Inbox Header -->
    <div class="content-header">
        <div class="header-section">
            <h1><i class="gi gi-picture"></i>Carrusel<br><small>Listado y modificacion</small></h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Panel de control</li>
        <li>Media</li>
        <li>Carrusel</li>
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
                    <h2>Carrusel</h2>
                    <div class="block-options pull-right">
                        <div class="btn-group btn-group-sm">
                            <a title="" data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle enable-tooltip" href="javascript:void(0)" data-original-title="Opciones"><span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                                <li>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-carrousel-add"><i class="gi gi-circle_plus pull-right"></i> Agregar item</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END Messages List Title -->

                <!-- Messages List Content -->
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped table-condensed table-carrousel-report">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Titulo</th>
                                <th>Linkable</th>
                                <th>Link</th>
                                <th>Categoria</th>
                                <th>Estatus</th>
                                <th>Orden</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carrousel as $c)
                            <tr id="_c_{{ $c->id }}">
                                <td class="vimage"><a href="{{ Config::get('btsite.url') . Config::get('btsite.img_slider') .  $c->pic}}" class="g-link"><i class="gi gi-camera"></i></a></td>
                                <td class="vtitle">{{ $c->title }}</td>
                                <td class="vlinkable"><input type="checkbox" data-id="{{ $c->id }}" value="linkable" name="cb_{{ $c->id }}" id="cb_{{ $c->id }}" {{ $c->linkable==1?'checked':'' }}></td>
                                <td class="vlink"><a href="{{ $c->link }}" target="_blank">{{ $c->link }}</a></td>
                                <td>
                                    <select data-id="{{ $c->id }}" name="category" id="category">
                                        <option value="0" {{ $c->status==0?'selected':'' }}>Todas</option>
                                        @foreach($product_categories as $pc)
                                            <option value="{{ $pc->id }}" {{ $c->category_id==$pc->id?'selected':'' }}>{{ $pc->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select data-id="{{ $c->id }}" name="status" id="status">
                                        <option value="1" {{ $c->status==1?'selected':'' }}>Activo</option>
                                        <option value="0" {{ $c->status==0?'selected':'' }}>Inactivo</option>
                                    </select>
                                </td>
                                <td class="vorder">
                                    (<span>{{ $c->order }}</span>)
                                    <div class="btn-group btn-group-xs">
                                        <button class="btn btn-default" data-cmd='up' data-id="{{ $c->id }}" data-order="{{ $c->order }}"><i class="gi gi-up_arrow"></i></button>
                                        <button class="btn btn-default" data-cmd='down' data-id="{{ $c->id }}" data-order="{{ $c->order }}"><i class="gi gi-down_arrow"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <button class="btn btn-default" data-cmd='edit' data-id="{{ $c->id }}"><i class="gi gi-pencil"></i></button>
                                        <button class="btn btn-danger" data-cmd='del' data-id="{{ $c->id }}"><i class="fa fa-times"></i></button>
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
        <div id="modal-carrousel-edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="gi gi-facetime_video"></i> Edicion de carrusel</h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="{{ URL::to('media/carrousel/edit') }}" method="post" id="form-carrousel-edit" name="form-carrousel-edit" class="form-horizontal form-bordered">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="link">Link</label>
                                <div class="col-md-10">
                                    <input type="text" id="link" name="link" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="image">Imagen</label>
                                <div class="col-md-10">
                                    <div class="dropzone" id="dropzone"></div>
                                    <div class="progress progress-striped active fileprogress"><div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="100" role="progressbar" class="progress-bar progress-bar-info upprogress"></div></div>
                                </div>
                            </div>
                            <div class="form-group form-actions">
                                <div class="col-xs-12 text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                                    <button class="btn btn-sm btn-primary btn-carrousel-update">Actualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>
        <!-- /Dialogo para la edicion de videos -->        

        <!-- Dialogo para la agregar items al carrusel -->
        <div id="modal-carrousel-add" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="gi gi-picture"></i> Nuevo item</h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="{{ URL::to('media/carrousel/add') }}" method="post" id="form-carrousel-add" name="form-carrousel-add" class="form-horizontal form-bordered">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="title">Titulo</label>
                                <div class="col-md-10">
                                    <input type="text" id="title" name="title" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="linkable">Linkable</label>
                                <div class="col-md-10">
                                    <input type="checkbox" checked="" id="linkable" name="linkable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="link">Link</label>
                                <div class="col-md-10">
                                    <input type="text" id="link" name="link" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="category">Categoria</label>
                                <div class="col-md-10">
                                    <select name="category" id="category" class="form-control">
                                        <option value="0">Todas</option>
                                        <option value="1">Lenceria</option>
                                        <option value="2">Zapatos</option>
                                        <option value="3">Juguetes</option>
                                        <option value="4">Accesorios</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="status">Esatus</label>
                                <div class="col-md-10">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="image">Imagen</label>
                                <div class="col-md-10">
                                    <div class="dropzone" id="dropzone-add"></div>
                                    <div class="progress progress-striped active fileprogress-add"><div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="100" role="progressbar" class="progress-bar progress-bar-info upprogress-add"></div></div>
                                </div>
                            </div>
                            <div class="form-group form-actions">
                                <div class="col-xs-12 text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-sm btn-primary btn-carrousel-add">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>
        <!-- /Dialogo para la agregar items al carrusel -->

@stop
<!-- /Dialogos -->

<!-- Scripts adicionales -->
@section ('scripts')
    @parent
    {{ HTML::script('js/pages/media.carrousel.js') }}
    <script>MediaData.init();</script>
@stop