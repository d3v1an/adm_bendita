@extends ('layouts.admin')

<!-- Contenido -->
@section ('content')
<div id="page-content">
    <!-- Inbox Header -->
    <div class="content-header">
        <div class="header-section">
            <h1><i class="gi gi-package"></i>Inventario<br><small>Administracion de inventario</small></h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Panel de control</li>
        <li>Productos</li>
        <li>Inventario</li>
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
                    <div class="block-options pull-right">
                        <div class="btn-group btn-group-sm">
                            <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default dropdown-toggle enable-tooltip" data-toggle="dropdown" title="Opciones"><span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                                <li>
                                    <a href="javascript:void(0)" class="btn-new-product"><i class="gi gi-package pull-right"></i>Nuevo producto</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:void(0)" class="btn-categories"><i class="gi gi-show_big_thumbnails pull-right"></i>Categorias</a>
                                    <a href="javascript:void(0)" class="btn-sub-categories"><i class="gi gi-show_thumbnails pull-right"></i>Sub-Categorias</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:void(0)" class="btn-colors"><i class="gi gi-brush pull-right"></i>Colores</a>
                                    <a href="javascript:void(0)" class="btn-materials"><i class="gi gi-dress pull-right"></i>Materiales</a>
                                    <a href="javascript:void(0)" class="btn-sizes"><i class="gi gi-resize_small pull-right"></i>Tallas</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h2>Productos</h2>
                </div>
                <!-- END Messages List Title -->

                <!-- Messages List Content -->
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped table-condensed table-inventory-report">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Codigo</th>
                                <th>Categoria</th>
                                <th>Sub-Categoria</th>
                                <th>Descripcion</th>
                                <th>PP</th>
                                <th>MM</th>
                                <th>M</th>
                                <th>D</th>
                                <th>Estatus</th>
                                <th></th>
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
    <!-- Visor de producto -->
    <div id="modal-product-view" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Edicion de producto. Codigo [<strong class="mdl-product-code"></strong>]</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">

                        <!-- Galeria de imagenes -->
                        <div class="col-md-5">
                            <div class="widget">
                                <div class="widget-extra-full themed-background-dark">
                                    <!-- Carousel -->
                                    <div id="widget-carousel1" class="carousel slide remove-margin">
                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner wid-item-gallery">
                                        </div>
                                        <!-- END Wrapper for slides -->

                                        <!-- Controls -->
                                        <a class="left carousel-control" href="#widget-carousel1" data-slide="prev">
                                            <span><i class="fa fa-chevron-left"></i></span>
                                        </a>
                                        <a class="right carousel-control" href="#widget-carousel1" data-slide="next">
                                            <span><i class="fa fa-chevron-right"></i></span>
                                        </a>
                                        <!-- END Controls -->
                                    </div>
                                    <!-- END Carousel -->
                                </div>
                            </div>
                        </div>

                        <!-- Informacion del producto -->
                        <div class="col-md-7">
                            <div class="block">
                                <!-- Info Title -->
                                <div class="block-title">
                                    <h2>
                                    Codigo <strong class="wid-item-code"></strong>
                                    <a href="" target="_blank" class="btn btn-xs btn-default wid-item-link"><i class="gi gi-globe_af"></i></a>
                                    </h2>
                                </div>
                                <!-- END Info Title -->

                                <!-- Info Content -->
                                <table class="table table-borderless table-striped">
                                    <tbody>
                                        <tr>
                                            <td><strong>Stock</strong></td>
                                            <td><a href="javascript:void(0)" class="label label-danger wid-item-stock"></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Categoria</strong></td>
                                            <td class="wid-item-category"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;"><strong>Descripción</strong></td>
                                            <td class="wid-item-description"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;"><strong>Detalle</strong></td>
                                            <td class="wid-item-detail"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Materiales</strong></td>
                                            <td class="wid-item-materials"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Colores</strong></td>
                                            <td class="wid-item-colors"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Publico</strong></td>
                                            <td class="wid-item-p-public"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>M. Mayoreo</strong></td>
                                            <td class="wid-item-p-half-wholesale"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mayoreo</strong></td>
                                            <td class="wid-item-p-wholesale"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Distribuidor</strong></td>
                                            <td class="wid-item-p-dealer"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- END Info Content -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Visor de producto -->

    <!-- Nuevo producto -->
    <div id="modal-add-product" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Nuevo producto</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">

                    <!-- Default Tabs -->
                    <ul class="nav nav-tabs push" data-toggle="tabs">
                        <li class="active"><a href="#images">Imagenes</a></li>
                        <li><a href="#detail">Detalle</a></li>
                        <li><a href="#example-tabs-messages" data-toggle="tooltip" title="Messages"><i class="fa fa-envelope-o"></i></a></li>
                        <li><a href="#example-tabs-settings" data-toggle="tooltip" title="Settings"><i class="fa fa-cog"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- Imagenes -->
                        <div class="tab-pane active" id="images">
                            <div class="row">
                        
                                <div class="col-md-12">
                                    <div class="dropzone" id="dropzone"></div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12" id="previews">

                                    <div id="template" class="galery-up-file">
                                        <div><span class="preview"><img data-dz-thumbnail class="img-responsive center-block" /></span></div>                               
                                        <div>
                                            <!-- <p class="name" data-dz-name></p> -->
                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                        </div>
                                        <div>
                                            <span class="size" data-dz-size></span>
                                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="btn-group">
                                                <button data-dz-remove class="btn btn-xs btn-default" type="button"><i class="gi gi-bin"></i> Eliminar</button>
                                                <button class="btn btn-xs btn-success" type="button"><i class="gi gi-heart"></i> Principal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Detalles -->
                        <div class="tab-pane" id="detail">
                            <!-- Basic Form Elements Content -->
                            <form action="page_forms_general.html" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onsubmit="return false;">
                                <!-- Codigo -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="code">Codigo</label>
                                    <div class="col-md-3">
                                        <input type="text" id="code" name="code" class="form-control" placeholder="Codigo de producto..">
                                    </div>
                                    <label class="col-md-2 control-label" for="stock">Stock</label>
                                    <div class="col-md-2">
                                        <input type="text" id="stock" name="stock" class="form-control" placeholder="Stock..">
                                    </div>
                                </div>
                                <!-- Titulo -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="detail">Titulo</label>
                                    <div class="col-md-10">
                                        <input type="text" id="detail" name="detail" class="form-control" placeholder="Titulo de producto..">
                                    </div>
                                </div>
                                <!-- Descripcion -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-textarea-input">Descripcion</label>
                                    <div class="col-md-10">

                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                            
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        Español
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Ingles
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <!-- Categoria y sub categoria -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-select">Categoria</label>
                                    <div class="col-md-4">
                                        <select id="example-select" name="example-select" class="form-control" size="1">
                                            <option value="0">Please select</option>
                                            <option value="1">Option #1</option>
                                            <option value="2">Option #2</option>
                                            <option value="3">Option #3</option>
                                        </select>
                                    </div>
                                    <label class="col-md-2 control-label" for="example-select">Sub Categoria</label>
                                    <div class="col-md-4">
                                        <select id="example-select" name="example-select" class="form-control" size="1">
                                            <option value="0">Please select</option>
                                            <option value="1">Option #1</option>
                                            <option value="2">Option #2</option>
                                            <option value="3">Option #3</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Multi Sub Categoria -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-multiple-select">Multi Categoria</label>
                                    <div class="col-md-10">
                                        <select id="example-multiple-select" name="example-multiple-select" class="form-control" size="7" multiple>
                                            <optgroup label="Lenceria">
                                                <option value="1">Option #1</option>
                                                <option value="2">Option #2</option>
                                                <option value="3">Option #3</option>
                                                <option value="4">Option #4</option>
                                                <option value="5">Option #5</option>
                                                <option value="6">Option #6</option>
                                                <option value="7">Option #7</option>
                                                <option value="8">Option #8</option>
                                                <option value="9">Option #9</option>
                                                <option value="10">Option #10</option>
                                            </optgroup>
                                            <optgroup label="Juguetes">
                                                <option value="1">Option #1</option>
                                                <option value="2">Option #2</option>
                                                <option value="3">Option #3</option>
                                                <option value="4">Option #4</option>
                                                <option value="5">Option #5</option>
                                                <option value="6">Option #6</option>
                                                <option value="7">Option #7</option>
                                                <option value="8">Option #8</option>
                                                <option value="9">Option #9</option>
                                                <option value="10">Option #10</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <!-- END Basic Form Elements Content -->
                        </div>
                        <div class="tab-pane" id="example-tabs-messages">Messages..</div>
                        <div class="tab-pane" id="example-tabs-settings">Settings..</div>
                    </div>
                    <!-- END Default Tabs -->
                    
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default btn-upload-product">Agregar</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Nuevo producto -->

    <!-- Categorias -->
    <div id="modal-categories" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Nuevo producto</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Categorias -->

    <!-- Sub Categorias -->
    <div id="modal-sub-categories" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Nuevo producto</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Sub Categorias -->

    <!-- Colores -->
    <div id="modal-colors" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Nuevo producto</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Colores -->

    <!-- Materiales -->
    <div id="modal-materials" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Nuevo producto</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Materials -->

    <!-- Tallas -->
    <div id="modal-sizes" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Nuevo producto</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Tallas -->
@stop
<!-- /Dialogos -->

<!-- Scripts adicionales -->
@section ('scripts')
    @parent
    {{ HTML::script('js/pages/inventory.report.js') }}
    <script>InventoryReportData.init();</script>
@stop