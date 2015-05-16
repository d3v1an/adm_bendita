@extends ('layouts.printable')

<!-- Contenido -->
@section ('content')
<!-- Page content -->
<div id="page-content">

    <!-- Invoice Block -->
    <div class="block full">
        <!-- Invoice Title -->
        <div class="block-title">
            <h2><strong>Orden</strong> #198</h2>
        </div>
        <!-- END Invoice Title -->

        <!-- Invoice Content -->

        <!-- 2 Column grid -->
        <div class="row block-section">
            <!-- Client Info -->
            <div class="col-sm-6">
                <h2><strong>{{ $order->user->name }} {{ $order->user->first_name }} {{ $order->user->last_name }}</strong></h2>
                <address>
                    {{ $order->user->email }}<br>
                    {{ $order->user->phone }}<br>
                    {{ $order->status->label }}
                </address>
            </div>
            <!-- END Client Info -->
        </div>
        <!-- END 2 Column grid -->

        <hr>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th style="width: 40%;">Articulo</th>
                        <th class="text-center">Codigo</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio U.</th>
                        <th class="text-right">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    @foreach($order->items as $oi)
                    <tr>
                        <td><h4>{{ $oi->product->description }}</h4></td>
                        <td class="text-center"><strong>{{ $oi->product->code }}</strong></td>
                        <td class="text-center"><strong>x <span class="badge">{{ $oi->quanty }}</span></strong></td>
                        <td class="text-center"><strong>$ {{ number_format($oi->price,2) }}</strong></td>
                        <td class="text-right"><span class="label label-primary">$ {{ number_format($oi->total,2) }}</span></td>
                    </tr>
                    <?php $total += $oi->total; ?>
                    @endforeach
                    <tr class="active">
                        <td colspan="4" class="text-right"><span class="h4">TOTAL</span></td>
                        <td class="text-right"><span class="h4">$ {{ number_format($total,2) }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END Table -->

        <!-- END Invoice Content -->
    </div>
    <!-- END Invoice Block -->
</div>
<!-- END Page Content -->
@stop
<!-- /Contenido -->

<!-- Scripts adicionales -->
@section ('scripts')
    @parent
    {{ HTML::script('js/pages/bootstrap3-typeahead.min.js') }}
    {{ HTML::script('js/pages/orders.report.js') }}
    <script>OrdersReportData.init();</script>
@stop