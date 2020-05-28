<?php
/**
 * Function helper to add flash notification.
 *
 * @param  null|string $message The flashed message.
 * @param  string $level   Level/type of message
 * @return void
 */
function flash($message = null, $level = 'info')
{
    $session = app('session');
    if (!is_null($message)) {
        $session->flash('flash_notification.message', $message);
        $session->flash('flash_notification.level', $level);
    }
}

/**
 * Format number to string.
 *
 * @param  float  $number
 * @return string
 */
function format_number(float $number)
{
    $number = number_format($number, 2);

    return str_replace('-', '- ', $number);
}

/**
 * Get balance amount based on transactions.
 *
 * @param  string|null  $perDate
 * @param  string|null  $startDate
 * @return float
 */
function balance($perDate = null, $startDate = null, $categoryId = null, $partnerId = null)
{
    $transactionQuery = DB::table('transactions');
    if ($perDate) {
        $transactionQuery->where('date', '<=', $perDate);
    }
    if ($startDate) {
        $transactionQuery->where('date', '>=', $startDate);
    }
    if ($categoryId) {
        $transactionQuery->where('category_id', $categoryId);
    }
    if ($partnerId) {
        $transactionQuery->where('partner_id', $partnerId);
    }
    $transactions = $transactionQuery->where('creator_id', auth()->id())->get();

    return $transactions->sum(function ($transaction) {
        return $transaction->in_out ? $transaction->amount : -$transaction->amount;
    });
}
