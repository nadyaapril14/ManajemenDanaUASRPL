<!-- @extends('layouts.app')

@section('title', __('partner.transactions'))

@section('content')

{{ link_to_route('partners.index', __('partner.back_to_index'), [], ['class' => 'btn btn-sm btn-default pull-right']) }}
<h3 class="page-header">{{ $partner->name }} <small>{{ __('partner.transactions') }}</small></h3>

@include('transactions.partials.stats')

@if ($partner->description)
    <div class="alert alert-info"><strong>{{ __('app.description') }}:</strong><br>{{ $partner->description }}</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                @include('partners.partials.show_filter')
            </div>
            @desktop
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th class="text-center col-md-1">{{ __('app.table_no') }}</th>
                        <th class="text-center col-md-2">{{ __('app.date') }}</th>
                        <th class="col-md-7">{{ __('transaction.description') }}</th>
                        <th class="text-right col-md-2">{{ __('transaction.amount') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $key => $transaction)
                    <tr>
                        <td class="text-center">{{ 1 + $key }}</td>
                        <td class="text-center">{{ $transaction->date }}</td>
                        <td>
                            {{ $transaction->description }}
                            <div class="pull-right">
                                {!! optional($transaction->category)->name_label !!}
                            </div>
                        </td>
                        <td class="text-right">{{ $transaction->amount_string }}</td>
                        <td class="text-center">
                            @can('update', $transaction)
                                {!! link_to_route(
                                    'partners.show',
                                    __('app.edit'),
                                    [$partner->id, 'action' => 'edit', 'id' => $transaction->id] + request(['start_date', 'end_date', 'query', 'category_id']),
                                    ['id' => 'edit-transaction-'.$transaction->id]
                                ) !!}
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">{{ __('transaction.not_found') }}</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">{{ __('app.total') }}</th>
                        <th class="text-right">
                            {{ format_number($transactions->sum(function ($transaction) {
                                return $transaction->in_out ? $transaction->amount : -$transaction->amount;
                            })) }}
                        </th>
                        <th>&nbsp;</th>
                    </tr>
                </tfoot>
            </table>
            @elsedesktop
            <div class="panel-body">
                @foreach ($transactions as $transaction)
                    @include('partners.partials.single_transaction_mobile', ['transaction' => $transaction])
                @endforeach
            </div>
            @enddesktop
        </div>
    </div>
</div>
@if(Request::has('action'))
@include('partners.partials.transaction-forms')
@endif
@endsection

@section('styles')
    {{ Html::style(url('css/plugins/bootstrap-colorpicker.min.css')) }}
    {{ Html::style(url('css/plugins/jquery.datetimepicker.css')) }}
@endsection

@push('scripts')
    {{ Html::script(url('js/plugins/bootstrap-colorpicker.min.js')) }}
    {{ Html::script(url('js/plugins/jquery.datetimepicker.js')) }}
<script>
(function () {
    $('#transactionModal').modal({
        show: true,
        backdrop: 'static',
    });
    $('.date-select').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endpush
 -->