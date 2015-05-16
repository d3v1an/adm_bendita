@extends ('layouts.admin')

<!-- Contenido -->
@section ('content')
<div id="page-content">
    <!-- Inbox Header -->
    <div class="content-header">
        <div class="header-section">
            <h1><i class="gi gi-cargo"></i>Ordenes<br><small>Reporte de ordenes de clientes</small></h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Panel de control</li>
        <li>Clientes</li>
        <li>Ordenes</li>
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
                    <h2>Ordenes</h2>
                </div>
                <!-- END Messages List Title -->

                <!-- Messages List Content -->
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped table-condensed table-orders-report">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Entrada</th>
                                <th>Actualizacion</th>
                                <th>Paqueteria</th>
                                <th>Guia</th>
                                <th>$ Envio</th>
                                <th>Sub Total</th>
                                <th>Total</th>
                                <th>Estatus</th>
                                <th>Pagada</th>
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
    <!-- Visor de notificaciones -->
    <div id="modal-notification-view" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="gi gi-message_new"></i> Notificacion email</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <iframe src="about:blank" id="templ_preview_iframe"></iframe>
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Visor de notificaciones -->

    <!-- Visor de notificaciones -->
    <div id="modal-order-view" class="modal modal-wide fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="gi gi-cargo"></i> Detalle de orden [<span class="moie"></span>]</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <ul data-toggle="tabs" class="nav nav-tabs push">
                        <li class="active"><a href="#items" data-toggle="tab"><i class="gi gi-shopping_cart"></i> Articulos</a></li>
                        <li class=""><a href="#extras" data-toggle="tab"><i class="hi hi-heart-empty"></i> Extras</a></li>
                        <li class=""><a href="#reply" data-toggle="tab"><i class="gi gi-comments"></i> Comunicacion</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="items" class="tab-pane active">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped table-order-detail">
                                    <thead>
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center"></th>
                                            <th class="text-center" style="width: 50px;"><i class="gi gi-picture"></i></th>
                                            <th class="text-center">Codigo</th>
                                            <th>Descripcion</th>
                                            <th class="text-center">Tipo</th>
                                            <th class="text-center">Moneda</th>
                                            <th class="text-center">Precio U.</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Sub Total</th>
                                            <th class="text-center" style="width: 150px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="extras" class="tab-pane">
                            <form class="form-horizontal form-bordered" id="form-additional-data" name="form-additional-data" method="post" action="/orders/aditional">
                                <input type="hidden" id="order_id" name="order_id">
                                <div class="form-group">
                                    <label for="payment-type" class="col-md-3 control-label">Metodo de pago</label>
                                    <div class="col-md-9">
                                        <select size="1" class="form-control" name="payment-type" id="payment-type">
                                            <option value="0">-- Seleccionar --</option>
                                            <option value="1">Desposito Bancario</option>
                                            <option value="2">Efectivo</option>
                                            <option value="3">Paypal</option>
                                            <option value="4">Oxxo</option>
                                            <option value="5">Cheque</option>
                                            <option value="6">Local</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="payment-detail" class="col-md-3 control-label">Detalles de pago</label>
                                    <div class="col-md-9">
                                        <textarea placeholder="Detalles de pago.." class="form-control" rows="5" name="payment-data" id="payment-data"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="reply" class="tab-pane">
                            <form class="form-horizontal form-bordered" id="form-chat-data" name="form-chat-data" method="post" action="/customer/orders/chat">
                                <input type="hidden" id="note_id" name="note_id">
                                <div class="block full mh-chat">
                                    <!-- Timeline Style Content -->
                                    <!-- You can remove the class .block-content-full if you want the block to have its regular padding -->
                                    <div class="timeline block-content-full">
                                        <ul class="timeline-list timeline-hover">
                                        </ul>
                                    </div>
                                    <!-- END Timeline Style Content -->
                                </div>
                                <div class="reply-container form-group display-none">
                                    <label for="reply-to-note" class="col-md-3 control-label">Respuesta</label>
                                    <div class="col-md-9">
                                        <textarea placeholder="Respuesta de mensaje" class="form-control" rows="2" name="reply-to-note" id="reply-to-note"></textarea>
                                    </div>
                                    <label for="" class="col-md-3 control-label"></label>
                                    <div class="col-md-9">
                                        <button class="btn btn-sm btn-success btn-reply-save">Responer</button>
                                        <button class="btn btn-sm btn-warning btn-reply-cancel">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary btn-print" id="btn-print" data-oid="">Imprimir</button>
                    <button class="btn btn-sm btn-success btn-save" disabled>Guardar</button>
                    <!-- <button class="btn btn-sm btn-danger btn-reply" disabled>Replicar</button> -->
                    <button class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Visor de notificaciones -->

    <!-- Visor de notificaciones -->
    <div id="modal-order-item-edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Actualizacion de articulo</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Horizontal Form Content -->
                    <form action="/orders/detail/item/replace" method="post" id="form-item-replace" name="form-item-replace" class="form-horizontal form-bordered" onsubmit="return false;">
                        <input type="hidden" name="utype_id" id="utype_id">
                        <input type="hidden" name="uid" id="uid">
                        <input type="hidden" name="trid" id="trid">
                        <input type="hidden" name="currency" id="currency">
                        <input type="hidden" name="lang" id="lang">
                        <input type="hidden" name="order_id" id="order_id">
                        <input type="hidden" name="o_item_id" id="o_item_id">
                        <input type="hidden" name="n_item_id" id="n_item_id">
                        <div class="form-group">
                            <input type="text" id="code" name="code" class="form-control" placeholder="Codigo.." autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input type="text" id="price" name="price" class="form-control" placeholder="Precio.." readonly>
                        </div>
                        <div class="form-group">
                            <input type="text" id="quanty" name="quanty" class="form-control" placeholder="Cantidad..">
                        </div>
                        <div class="form-group">
                            <input type="text" id="ptype" name="ptype" class="form-control" placeholder="Tipo de precio.." readonly>
                        </div>
                        <div class="form-group">
                            <input type="text" id="sub_total" name="sub_total" class="form-control" placeholder="Sub total.." readonly>
                        </div>
                    </form>
                    <!-- END Horizontal Form Content -->
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button class="btn btn-sm btn-success btn-item-replace">Remplazar</button>
                    <button class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Visor de notificaciones -->

    <!-- Envio de notificaciones -->
    <div id="modal-order-notify" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title">Notificacion</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Horizontal Form Content -->
                    <form action="/orders/notify" method="post" id="form-notify" name="form-notify" class="form-horizontal form-bordered" onsubmit="return false;">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="form-group">
                            <textarea id="notify" name="notify" class="form-control" rows="15" style="resize:none;"></textarea>
                        </div>
                    </form>
                    <!-- END Horizontal Form Content -->
                </div>
                <!-- END Modal Body -->

                <div class="modal-footer">
                    <button class="btn btn-sm btn-success btn-user-notify">Notificar</button>
                    <button class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Envio de notificaciones -->
@stop
<!-- /Dialogos -->

<!-- Scripts adicionales -->
@section ('scripts')
    @parent
    {{ HTML::script('js/pages/bootstrap3-typeahead.min.js') }}
    {{ HTML::script('js/pages/orders.report.js') }}
    <script>OrdersReportData.init();</script>
@stop