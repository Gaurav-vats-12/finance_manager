<?php

namespace FireflyIII\Database\TransactionCurrency;

use FireflyIII\Database\CommonDatabaseCalls;
use FireflyIII\Database\CUD;
use FireflyIII\Exception\NotImplementedException;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;

/**
 * Class TransactionType
 *
 * @package FireflyIII\Database
 */
class TransactionCurrency implements TransactionCurrencyInterface, CommonDatabaseCalls, CUD
{

    /**
     * @param Eloquent $model
     *
     * @return bool
     */
    public function destroy(Eloquent $model)
    {
        $model->delete();
    }

    /**
     * @param array $data
     *
     * @return Eloquent
     */
    public function store(array $data)
    {
        $currency = new \TransactionCurrency($data);
        $currency->save();
        return $currency;
    }

    /**
     * @param Eloquent $model
     * @param array    $data
     *
     * @return bool
     */
    public function update(Eloquent $model, array $data)
    {
        $model->symbol = $data['symbol'];
        $model->code = $data['code'];
        $model->name = $data['name'];
        $model->save();

        return true;
    }

    /**
     * Validates an array. Returns an array containing MessageBags
     * errors/warnings/successes.
     *
     * @param array $model
     *
     * @return array
     */
    public function validate(array $model)
    {
        $warnings  = new MessageBag;
        $successes = new MessageBag;

        $currency = new \TransactionCurrency($model);
        $currency->isValid();
        $errors = $currency->getErrors();

        $fields = ['name', 'code', 'symbol'];
        foreach ($fields as $field) {
            if (!$errors->has($field)) {
                $successes->add($field, 'OK');
            }
        }

        return ['errors' => $errors, 'warnings' => $warnings, 'successes' => $successes];
    }

    /**
     * Returns an object with id $id.
     *
     * @param int $objectId
     *
     * @return \Eloquent
     */
    public function find($objectId)
    {
        // TODO: Implement find() method.
        throw new NotImplementedException;
    }

    /**
     * Finds an account type using one of the "$what"'s: expense, asset, revenue, opening, etc.
     *
     * @param $what
     *
     * @return \AccountType|null
     */
    public function findByWhat($what)
    {
        // TODO: Implement findByWhat() method.
        throw new NotImplementedException;
    }

    /**
     * Returns all objects.
     *
     * @return Collection
     */
    public function get()
    {
        return \TransactionCurrency::orderBy('code', 'ASC')->get();
    }

    /**
     * @param array $objectIds
     *
     * @return Collection
     */
    public function getByIds(array $objectIds)
    {
        // TODO: Implement getByIds() method.
        throw new NotImplementedException;
    }

    /**
     * @param string $code
     *
     * @return \TransactionCurrency|null
     */
    public function findByCode($code)
    {
        return \TransactionCurrency::whereCode($code)->first();
    }
}