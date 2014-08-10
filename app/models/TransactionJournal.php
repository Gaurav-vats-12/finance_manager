<?php

use LaravelBook\Ardent\Ardent;


/**
 * TransactionJournal
 *
 * @property integer                                                      $id
 * @property \Carbon\Carbon                                               $created_at
 * @property \Carbon\Carbon                                               $updated_at
 * @property integer                                                      $transaction_type_id
 * @property integer                                                      $transaction_currency_id
 * @property string                                                       $description
 * @property boolean                                                      $completed
 * @property \Carbon\Carbon                                               $date
 * @property-read \TransactionType                                        $transactionType
 * @property-read \TransactionCurrency                                    $transactionCurrency
 * @property-read \Illuminate\Database\Eloquent\Collection|\Transaction[] $transactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Component[]   $components
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Budget[] $budgets
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Category[] $categories
 * @method static \Illuminate\Database\Query\Builder|\TransactionJournal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TransactionJournal whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TransactionJournal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TransactionJournal whereTransactionTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\TransactionJournal whereTransactionCurrencyId($value)
 * @method static \Illuminate\Database\Query\Builder|\TransactionJournal whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\TransactionJournal whereCompleted($value)
 * @method static \Illuminate\Database\Query\Builder|\TransactionJournal whereDate($value)
 * @method static \TransactionJournal after($date)
 * @method static \TransactionJournal before($date)
 * @property integer                                                      $user_id
 * @property-read \User                                                   $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Budget[] $budgets
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Category[] $categories
 * @method static \Illuminate\Database\Query\Builder|\TransactionJournal whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Budget[] $budgets
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Budget[] $budgets
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Budget[] $budgets
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Budget[] $budgets
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Budget[] $budgets
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Budget[] $budgets
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Budget[] $budgets
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Budget[] $budgets
 * @property-read \Illuminate\Database\Eloquent\Collection|\
 *             'Category[] $categories
 */
class TransactionJournal extends Ardent
{

    public static $rules
        = [
            'transaction_type_id'     => 'required|exists:transaction_types,id',
            'transaction_currency_id' => 'required|exists:transaction_currencies,id',
            'description'             => 'required|between:1,255',
            'date'                    => 'required|date',
            'completed'               => 'required|between:0,1'
        ];

    /**
     * @return array
     */
    public static function factory()
    {
        $date = new \Carbon\Carbon;

        return [
            'transaction_type_id'     => 'factory|TransactionType',
            'transaction_currency_id' => 'factory|TransactionCurrency',
            'description'             => 'string',
            'completed'               => '1',
            'user_id'                 => 'factory|User',
            'date'                    => $date
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transactionType()
    {
        return $this->belongsTo('TransactionType');
    }

    /**
     * User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transactionCurrency()
    {
        return $this->belongsTo('TransactionCurrency');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('Transaction');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function components()
    {
        return $this->belongsToMany('Component');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function budgets()
    {
        return $this->belongsToMany(
            'Budget', 'component_transaction_journal', 'transaction_journal_id', 'component_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(
            'Category', 'component_transaction_journal', 'transaction_journal_id', 'component_id'
        );
    }

    /**
     * @return array
     */
    public function getDates()
    {
        return ['created_at', 'updated_at', 'date'];
    }

    /**
     * @param                $query
     * @param \Carbon\Carbon $date
     *
     * @return mixed
     */
    public function scopeAfter($query, \Carbon\Carbon $date)
    {
        return $query->where('date', '>=', $date->format('Y-m-d'));
    }

    /**
     * @param                $query
     * @param \Carbon\Carbon $date
     *
     * @return mixed
     */
    public function scopeBefore($query, \Carbon\Carbon $date)
    {
        return $query->where('date', '<=', $date->format('Y-m-d'));
    }

} 