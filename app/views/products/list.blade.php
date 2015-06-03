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
                        <li><a href="#relations">Relacion</a></li>
                        <li><a href="#extras">Extras</a></li>
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
                                                <div class="progress-bar progress-bar-success progress-object" style="width:0%;" data-dz-uploadprogress></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="btn-group"> <!-- data-dz-remove  -->
                                                <button class="btn btn-xs btn-default btn-del" type="button"><i class="gi gi-bin"></i> Eliminar</button>
                                                <button class="btn btn-xs btn-success btn-pic" type="button"><i class="gi gi-heart"></i> Principal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Detalles -->
                        <div class="tab-pane" id="detail">

                            <!-- Basic Form Elements Content -->
                            <form action="#" method="post" class="form-horizontal form-bordered" id="form-detail" name="form-detail" onsubmit="return false;">
                                
                                <!-- Codigo -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="code">Codigo</label>
                                    <div class="col-md-3">
                                        <input type="text" id="code" name="code" class="form-control" placeholder="Codigo de producto..">
                                    </div>
                                    <label class="col-md-2 control-label" for="stock">Stock</label>
                                    <div class="col-md-2">
                                        <input type="text" id="stock" name="stock" class="form-control" placeholder="Stock.." value="0">
                                    </div>
                                </div>
                                
                                <!-- Titulo -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="title-accordion">Titulo</label>
                                    <div class="col-md-10">

                                        <div class="panel-group" id="title-accordion" role="tablist" aria-multiselectable="true">
                                            
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#title-accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        Español
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <input type="text" id="title" name="title" class="form-control" placeholder="Titulo de producto..">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#title-accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Ingles
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        <input type="text" id="title-eng" name="title-eng" class="form-control" placeholder="Product title">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Descripcion -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="description-accordion">Descripcion</label>
                                    <div class="col-md-10">

                                        <div class="panel-group" id="description-accordion" role="tablist" aria-multiselectable="true">
                                            
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#description-accordion" href="#collapseOne-Desc" aria-expanded="true" aria-controls="collapseOne">
                                                        Español
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne-Desc" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <textarea id="description" name="description" class="ckeditor"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#description-accordion" href="#collapseTwo-Desc" aria-expanded="false" aria-controls="collapseTwo">
                                                        Ingles
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo-Desc" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        <textarea id="description-eng" name="description-eng" class="ckeditor"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Categoria y sub categoria -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="categories">Categoria</label>
                                    <div class="col-md-4">
                                        <select id="categories" name="categories" class="form-control" size="1">
                                        </select>
                                    </div>
                                    <label class="col-md-2 control-label" for="sub-categories">Sub Categoria</label>
                                    <div class="col-md-4">
                                        <select id="sub-categories" name="sub-categories" class="form-control" size="1">
                                        </select>
                                    </div>
                                </div>

                                <!-- Multi Sub Categoria -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="multi-sub-categories">Multi Categoria</label>
                                    <div class="col-md-10">
                                        <select id="multi-sub-categories" name="multi-sub-categories" class="form-control" size="7" multiple>
                                        </select>
                                    </div>
                                </div>

                                <!-- Prices -->
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-2 control-label" for="price_public">P. Publico</label>
                                        <div class="col-md-2">
                                            <input type="text" id="price_public" name="price_public" class="form-control" placeholder="0.00 MXN">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="price_public_usd" name="price_public_usd" class="form-control" placeholder="0.00 USD" readonly>
                                        </div>
                                        <label class="col-md-2 control-label" for="price_half_wholesale">P. Medio Mayoreo</label>
                                        <div class="col-md-2">
                                            <input type="text" id="price_half_wholesale" name="price_half_wholesale" class="form-control" placeholder="0.00 MXN">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="price_half_wholesale_usd" name="price_half_wholesale_usd" class="form-control" placeholder="0.00 USD" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 control-label" for="price_wholesale">P. Mayoreo</label>
                                        <div class="col-md-2">
                                            <input type="text" id="price_wholesale" name="price_wholesale" class="form-control" placeholder="0.00 MX">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="price_wholesale_usd" name="price_wholesale_usd" class="form-control" placeholder="0.00 USD" readonly>
                                        </div>
                                        <label class="col-md-2 control-label" for="price_dealer">P. Distribuidor</label>
                                        <div class="col-md-2">
                                            <input type="text" id="price_dealer" name="price_dealer" class="form-control" placeholder="0.00 MX">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="price_dealer_usd" name="price_dealer_usd" class="form-control" placeholder="0.00 USD" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Genero -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="gender">Genero</label>
                                    <div class="col-md-2">
                                        <select id="gender" name="gender" class="form-control" size="1">
                                            <option value="f">Mujer</option>
                                            <option value="m">Hombre</option>
                                        </select>
                                    </div>
                                </div>

                            </form>
                            <!-- END Basic Form Elements Content -->
                        </div>

                        <!-- Relaciones -->
                        <div class="tab-pane" id="relations">

                            <!-- Basic Form Elements Content -->
                            <form action="#" method="post" class="form-horizontal form-bordered" id="form-relations" name="form-relations" onsubmit="return false;">
                                
                                <!-- Codigo -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="code">Codigo</label>
                                    <div class="col-md-3">
                                        <input type="text" id="code" name="code" class="form-control" placeholder="Codigo de producto.." autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-sm btn-default btn-search-code" disabled>Agregar</button>
                                    </div>
                                </div>
                                
                                <!-- Relations -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="code">Relaciones</label>
                                    <div class="col-md-10">
                                        <div class="table-responsive">
                                            <table id="relations-datatable" class="table table-vcenter table-condensed table-bordered table-relations">
                                                <thead>
                                                    <tr>
                                                        <th width="50px">Imagen</th>
                                                        <th>Codigo</th>
                                                        <th>Descripcion</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <!-- END Basic Form Elements Content -->
                        </div>

                        <!-- Materials -->
                        <div class="tab-pane" id="extras">
                            <form action="#" method="post" class="form-horizontal form-bordered" id="form-extras" name="form-extras" onsubmit="return false;">

                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="materials">Materiales</label>
                                        <select id="materials" name="materials" class="form-control" size="5" multiple>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="sizes">Tallas</label>
                                        <select id="sizes" name="sizes" class="form-control" size="5" multiple>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="colors">Colores</label>
                                        <select id="colors" name="colors" class="form-control" size="5" multiple>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-1 text-center btn-vc">
                                        <button class="btn btn-xs btn-default btn-color-link"><i class="hi hi-log_in"></i></button>
                                    </div>
                                    <div class="col-md-11">
                                        <label for="link-color">Colores & Codigo</label>
                                        <select id="link-color" name="link-color" class="form-control" size="5" readonly>
                                        </select>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!-- END Default Tabs -->
                    
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default btn-upload-product">Agregar</button>
                    <button type="button" class="btn btn-sm btn-default btn-cancel-product" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Nuevo producto -->

    <!-- Edicion de producto -->
    <div id="modal-edit-product" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Edicion de producto</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">

                    <!-- Default Tabs -->
                    <ul class="nav nav-tabs push navup" data-toggle="tabs">
                        <li class="active"><a href="#e_images">Imagenes</a></li>
                        <li><a href="#e_detail">Detalle</a></li>
                        <li><a href="#e_relations">Relacion</a></li>
                        <li><a href="#e_extras">Extras</a></li>
                    </ul>

                    <div class="tab-content">

                        <!-- Imagenes -->
                        <div class="tab-pane active" id="e_images">

                            <div class="row">
                                <div class="col-md-12" id="existing-images">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dropzone" id="e_dropzone"></div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12" id="previewsUp">

                                    <div id="templateUp" class="galery-edit-file">
                                        <div><span class="preview"><img data-dz-thumbnail class="img-responsive center-block" /></span></div>                               
                                        <div>
                                            <!-- <p class="name" data-dz-name></p> -->
                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                        </div>
                                        <div>
                                            <span class="size" data-dz-size></span>
                                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                <div class="progress-bar progress-bar-success progress-object" style="width:0%;" data-dz-uploadprogress></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Detalles -->
                        <div class="tab-pane" id="e_detail">

                            <!-- Basic Form Elements Content -->
                            <form action="#" method="post" class="form-horizontal form-bordered" id="form-edit-detail" name="form-edit-detail" onsubmit="return false;">
                                <input type="hidden" id="pid" name="pid" />
                                <!-- Codigo -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="code">Codigo</label>
                                    <div class="col-md-3">
                                        <input type="text" id="code" name="code" class="form-control" placeholder="Codigo de producto.." readonly>
                                    </div>
                                    <label class="col-md-2 control-label" for="stock">Stock</label>
                                    <div class="col-md-2">
                                        <input type="text" id="stock" name="stock" class="form-control" placeholder="Stock.." value="0">
                                    </div>
                                </div>
                                
                                <!-- Titulo -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="title-edit-accordion">Titulo</label>
                                    <div class="col-md-10">

                                        <div class="panel-group" id="title-edit-accordion" role="tablist" aria-multiselectable="true">
                                            
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#title-edit-accordion" href="#e_collapseOne" aria-expanded="true" aria-controls="e_collapseOne">
                                                        Español
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="e_collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <input type="text" id="title" name="title" class="form-control" placeholder="Titulo de producto..">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#title-edit-accordion" href="#e_collapseTwo" aria-expanded="false" aria-controls="e_collapseTwo">
                                                        Ingles
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="e_collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        <input type="text" id="title-eng" name="title-eng" class="form-control" placeholder="Product title">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Descripcion -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="description-edit-accordion">Descripcion</label>
                                    <div class="col-md-10">

                                        <div class="panel-group" id="description-edit-accordion" role="tablist" aria-multiselectable="true">
                                            
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#description-edit-accordion" href="#e_collapseOne-Desc" aria-expanded="true" aria-controls="e_collapseOne-Desc">
                                                        Español
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="e_collapseOne-Desc" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <textarea id="e_description" name="e_description" class="ckeditor"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#description-edit-accordion" href="#e_collapseTwo-Desc" aria-expanded="false" aria-controls="e_collapseTwo-Desc">
                                                        Ingles
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="e_collapseTwo-Desc" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        <textarea id="e_description-eng" name="e_description-eng" class="ckeditor"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Categoria y sub categoria -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="categories">Categoria</label>
                                    <div class="col-md-4">
                                        <select id="categories" name="categories" class="form-control" size="1">
                                        </select>
                                    </div>
                                    <label class="col-md-2 control-label" for="sub-categories">Sub Categoria</label>
                                    <div class="col-md-4">
                                        <select id="sub-categories" name="sub-categories" class="form-control" size="1">
                                        </select>
                                    </div>
                                </div>

                                <!-- Multi Sub Categoria -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="e-multi-sub-categories">Multi Categoria</label>
                                    <div class="col-md-10">
                                        <select id="e-multi-sub-categories" name="e-multi-sub-categories" class="form-control" size="7" multiple>
                                        </select>
                                    </div>
                                </div>

                                <!-- Prices -->
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-2 control-label" for="price_public">P. Publico</label>
                                        <div class="col-md-2">
                                            <input type="text" id="price_public" name="price_public" class="form-control" placeholder="0.00 MXN">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="price_public_usd" name="price_public_usd" class="form-control" placeholder="0.00 USD" readonly>
                                        </div>
                                        <label class="col-md-2 control-label" for="price_half_wholesale">P. Medio Mayoreo</label>
                                        <div class="col-md-2">
                                            <input type="text" id="price_half_wholesale" name="price_half_wholesale" class="form-control" placeholder="0.00 MXN">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="price_half_wholesale_usd" name="price_half_wholesale_usd" class="form-control" placeholder="0.00 USD" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 control-label" for="price_wholesale">P. Mayoreo</label>
                                        <div class="col-md-2">
                                            <input type="text" id="price_wholesale" name="price_wholesale" class="form-control" placeholder="0.00 MX">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="price_wholesale_usd" name="price_wholesale_usd" class="form-control" placeholder="0.00 USD" readonly>
                                        </div>
                                        <label class="col-md-2 control-label" for="price_dealer">P. Distribuidor</label>
                                        <div class="col-md-2">
                                            <input type="text" id="price_dealer" name="price_dealer" class="form-control" placeholder="0.00 MX">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" id="price_dealer_usd" name="price_dealer_usd" class="form-control" placeholder="0.00 USD" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Genero -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="gender">Genero</label>
                                    <div class="col-md-2">
                                        <select id="gender" name="gender" class="form-control" size="1">
                                            <option value="f">Mujer</option>
                                            <option value="m">Hombre</option>
                                        </select>
                                    </div>
                                </div>

                            </form>
                            <!-- END Basic Form Elements Content -->
                        </div>

                        <!-- Relaciones -->
                        <div class="tab-pane" id="e_relations">

                            <!-- Basic Form Elements Content -->
                            <form action="#" method="post" class="form-horizontal form-bordered" id="form-edit-relations" name="form-edit-relations" onsubmit="return false;">
                                
                                <!-- Codigo -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="code">Codigo</label>
                                    <div class="col-md-3">
                                        <input type="text" id="code" name="code" class="form-control" placeholder="Codigo de producto.." autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-sm btn-default btn-search-code" disabled>Agregar</button>
                                    </div>
                                </div>
                                
                                <!-- Relations -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="code">Relaciones</label>
                                    <div class="col-md-10">
                                        <div class="table-responsive">
                                            <table id="relations-edit-datatable" class="table table-vcenter table-condensed table-bordered table-edit-relations">
                                                <thead>
                                                    <tr>
                                                        <th width="50px">Imagen</th>
                                                        <th>Codigo</th>
                                                        <th>Descripcion</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <!-- END Basic Form Elements Content -->
                        </div>

                        <!-- Materials/Sizes/Colors -->
                        <div class="tab-pane" id="e_extras">
                            <form action="#" method="post" class="form-horizontal form-bordered" id="form-edit-extras" name="form-edit-extras" onsubmit="return false;">

                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="e-materials">Materiales</label>
                                        <select id="e-materials" name="e-materials" class="form-control" size="5" multiple>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="e-sizes">Tallas</label>
                                        <select id="e-sizes" name="e-sizes" class="form-control" size="5" multiple>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="e-colors">Colores</label>
                                        <select id="e-colors" name="e-colors" class="form-control" size="5" multiple>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-1 text-center btn-vc">
                                        <button class="btn btn-xs btn-default btn-edit-color-link"><i class="hi hi-log_in"></i></button>
                                    </div>
                                    <div class="col-md-11">
                                        <label for="e-link-color">Colores & Codigo</label>
                                        <select id="e-link-color" name="e-link-color" class="form-control" size="5" readonly>
                                        </select>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                    <!-- END Default Tabs -->
                    
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default btn-edit-product">Editar</button>
                    <button type="button" class="btn btn-sm btn-default btn-cancel-edit-product" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edicion de producto -->

    <!-- Categorias -->
    <div id="modal-categories" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Categorias</h2>
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
                    <h2 class="modal-title">Sub categorias</h2>
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
                    <h2 class="modal-title">Colores</h2>
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
                    <h2 class="modal-title">Materiales</h2>
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
                    <h2 class="modal-title">Tallas</h2>
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

    <!-- Link Color -->
    <div id="modal-link-color" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <!-- <h2 class="modal-title">Categorias</h2> -->
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="#" method="post" class="form-horizontal form-bordered" id="form-link-color" name="form-link-color" onsubmit="return false;">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="lcolors">Colores</label>
                                <select id="lcolors" name="lcolors" class="form-control" size="5">
                                </select>
                            </div>
                            <label class="col-md-2 control-label" for="code">Codigo</label>
                            <div class="col-md-7">
                                <input type="text" id="code" name="code" class="form-control" placeholder="Codigo de producto.." autocomplete="off">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default btn-select">Seleccionar</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Link Color -->

    <!-- Edit Link Color -->
    <div id="modal-edit-link-color" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <!-- <h2 class="modal-title">Categorias</h2> -->
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="#" method="post" class="form-horizontal form-bordered" id="form-edit-link-color" name="form-edit-link-color" onsubmit="return false;">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="l-e-colors">Colores</label>
                                <select id="l-e-colors" name="l-e-colors" class="form-control" size="5">
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label for="code">Codigo</label>
                                <input type="text" id="code" name="code" class="form-control" placeholder="Codigo de producto.." autocomplete="off">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default btn-edit-select">Seleccionar</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Link Color -->
@stop
<!-- /Dialogos -->

<!-- Scripts adicionales -->
@section ('scripts')
    @parent
    {{ HTML::script('js/md5.js') }}
    {{ HTML::script('js/pages/bootstrap3-typeahead.min.js') }}
    {{ HTML::script('js/ckeditor/ckeditor.js') }}
    {{ HTML::script('js/pages/inventory.report.js') }}
    <script>
        $(function(){
            InventoryReportData.load();
            InventoryReportData.init();
        });
    </script>
@stop