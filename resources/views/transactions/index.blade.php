@extends('layouts.app')

@section('title', __('transaction.list'))

@section('content')
<h3 class="page-header">
    @include('transactions.partials.index_actions')
    {{ __('transaction.list') }}
    <small>{{ __('app.total') }} : {{ $transactions->count() }} {{ __('transaction.transaction') }}</small>
</h3>
<div class="row">
    <div class="col-md-12">
        @include('transactions.partials.stats')
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                @include('transactions.partials.index_filters')
            </div>
            @desktop
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th class="text-center">{{ __('app.date') }}</th>
                        <th>{{ __('transaction.description') }}</th>
                        <th class="text-right">{{ __('transaction.amount') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $key => $transaction)
                    @php
                        $groups = $transactions->where('date_only', $transaction->date_only);
                        $firstGroup = $groups->first();
                        $groupCount = $groups->count();
                    @endphp
                    <tr>
                        <td class="text-center">{{ 1 + $key }}</td>
                        @if ($firstGroup->id == $transaction->id)
                            <td class="text-center text-middle" rowspan="{{ $groupCount }}">
                                {{ link_to_route('transactions.index', $transaction->date_only, [
                                    'date' => $transaction->date_only,
                                    'month' => $month,
                                    'year' => $year,
                                    'category_id' => request('category_id'),
                                ]) }}
                            </td>
                        @endif
                        <td>
                            <span class="pull-right">
                                @if ($transaction->partner)
                                    @php
                                        $partnerRoute = route('partners.show', [
                                            $transaction->partner_id,
                                            'start_date' => $startDate,
                                            'end_date' => $year.'-'.$month.'-'.date('t'),
                                        ]);
                                    @endphp
                                    <!--  -->
                                @endif
                                @if ($transaction->category)
                                    @php
                                        $categoryRoute = route('categories.show', [
                                            $transaction->category_id,
                                            'start_date' => $startDate,
                                            'end_date' => $year.'-'.$month.'-'.date('t'),
                                        ]);
                                    @endphp
                                    <a href="{{ $categoryRoute }}">{!! optional($transaction->category)->name_label !!}</a>
                                @endif
                            </span>
                            {{ $transaction->description }}
                        </td>
                        <td class="text-right">{{ $transaction->amount_string }}</td>
                        <td class="text-center">
                            @can('update', $transaction)
                                {!! link_to_route(
                                    'transactions.index',
                                    __('app.edit'),
                                    ['action' => 'edit', 'id' => $transaction->id] + request(['month', 'year', 'query', 'category_id']),
                                    ['id' => 'edit-transaction-'.$transaction->id]
                                ) !!}
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">{{ __('transaction.not_found') }}</td></tr>
                    @endforelse
                </tbody>
                @if (request('category_id') || request('partner_id'))
                <tfoot>
                    <tr><th colspan="5" class="text-right">&nbsp;</th></tr>
                    <tr>
                        <th colspan="3" class="text-right">{{ __('transaction.income_total') }}</th>
                        <th class="text-right">{{ format_number($incomeTotal) }}</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">{{ __('transaction.spending_total') }}</th>
                        <th class="text-right">{{ format_number($spendingTotal) }}</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">{{ __('transaction.difference') }}</th>
                        <th class="text-right">{{ number_format($incomeTotal - $spendingTotal, 2) }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </tfoot>
                @else
                <tfoot>
                    <tr><th colspan="5" class="text-right">&nbsp;</th></tr>
                    <tr>
                        <th colspan="3" class="text-right">{{ __('transaction.start_balance') }}</th>
                        <th class="text-right">
                            @php
                                $balance = 0;
                            @endphp
                            @if ($transactions->last())
                                {{ format_number($balance = balance(Carbon\Carbon::parse($transactions->last()->date)->subDay()->format('Y-m-d'))) }}
                            @else
                                0
                            @endif
                        </th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">{{ __('transaction.income_total') }}</th>
                        <th class="text-right">{{ format_number($incomeTotal) }}</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">{{ __('transaction.spending_total') }}</th>
                        <th class="text-right">{{ format_number($spendingTotal) }}</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">{{ __('transaction.end_balance') }}</th>
                        <th class="text-right">
                            @if ($transactions->first())
                                {{ format_number($balance + $incomeTotal - $spendingTotal) }}
                            @else
                                0
                            @endif
                        </th>
                        <th>&nbsp;</th>
                    </tr>
                </tfoot>
                @endif
            </table>
            @elsedesktop
            <div class="panel-body">
                @foreach ($transactions->groupBy('date') as $groupedTransactions)
                    @foreach ($groupedTransactions as $date => $transaction)
                        @include('transactions.partials.single_transaction_mobile', ['transaction' => $transaction, 'month' => $month, 'year' => $year])
                    @endforeach
                    <hr style="margin: 6px 0">
                @endforeach
                @include('transactions.partials.transaction_summary_mobile', ['transactions' => $transactions])
            @enddesktop
        </div>
    </div>
    <div class="col-md-4">
        @if(Request::has('action'))
        @include('transactions.forms')
        @endif
    </div>
</div>
@endsection

@section('styles')
    {{ Html::style(url('css/plugins/jquery.datetimepicker.css')) }}
@endsection

@push('scripts')
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
