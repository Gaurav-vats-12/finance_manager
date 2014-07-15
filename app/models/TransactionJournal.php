<?php

use LaravelBook\Ardent\Ardent;


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

    public static $factory
        = [
            'transaction_type_id'     => 'factory|TransactionType',
            'transaction_currency_id' => 'factory|TransactionCurrency',
            'description'             => 'string',
            'completed'               => '1',
            'date'                    => 'date|Y-m-d'
        ];

    public function transactionType()
    {
        return $this->belongsTo('TransactionType');
    }

    public function transactionCurrency()
    {
        return $this->belongsTo('TransactionCurrency');
    }

    public function transactions()
    {
        return $this->hasMany('Transaction');
    }

    public function components()
    {
        return $this->belongsToMany('Component');
    }

    public function budgets()
    {
        return $this->belongsToMany(
            'Budget', 'component_transaction_journal', 'transaction_journal_id', 'component_id'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            'Category', 'component_transaction_journal', 'transaction_journal_id', 'component_id'
        );
    }

    public function getDates()
    {
        return array('created_at', 'updated_at', 'date');
    }

    public function scopeAfter($query, \Carbon\Carbon $date)
    {
        return $query->where('date', '>=', $date->format('Y-m-d'));
    }

    public function scopeBefore($query, \Carbon\Carbon $date)
    {
        return $query->where('date', '<=', $date->format('Y-m-d'));
    }

} 