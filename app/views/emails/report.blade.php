@extends ('layouts.admin')

<!-- Contenido -->
@section ('content')
<div id="page-content">
    <!-- Inbox Header -->
    <div class="content-header">
        <div class="header-section">
            <h1><i class="gi gi-message_new"></i>Email's<br><small>Reporte de envio de correos</small></h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Panel de control</li>
        <li>Email's</li>
        <li>Reporte</li>
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
                    <h2>Emails</h2>
                </div>
                <!-- END Messages List Title -->

                <!-- Messages List Content -->
                <div class="table-responsive">
                    <table class="table table-vcenter table-striped table-condensed table-emails-report">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Estatus</th>
                                <th># Orden</th>
                                <th>Envio</th>
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
@stop
<!-- /Dialogos -->

<!-- Scripts adicionales -->
@section ('scripts')
    @parent
    {{ HTML::script('js/pages/emails.report.js') }}
    <script>EmailsReportData.init();</script>
@stop