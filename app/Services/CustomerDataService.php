<?php

namespace App\Services;

use App\Models\CustomerDataModel;
use Illuminate\Support\Facades\DB;

class CustomerDataService
{
    /**
     * Update the specified resource in storage.
     *
     * @param  array $data
     * @return Review
     */
    public static function create(array $data)
    {
        $data = CustomerDataModel::create($data);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array $data - Updated Data
     * @param  Review $promocode
     * @return Review
     */
    public static function update(array $data, CustomerDataModel $customerdata)
    {
        // $data = $customerdata->update($data);
        return CustomerDataModel::update([
            'company_name' => $data['company_name'],
            'location' => $data['location'],

          ]);
        return $data;
    }

    /**
     * UpdateById the specified resource in storage.
     *
     * @param  Array $data - Updated Data
     * @param  $id
     * @return Review
     */
    public static function updateById(array $data, $id)
    {
        $data = CustomerDataModel::whereId($id)->update($data);
        return $data;
    }

    /**
     * Get Data By Id from storage.
     *
     * @param  Int $id
     * @return Review
     */
    public static function getById($id)
    {
        $data = CustomerDataModel::find($id);
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Review
     * @return bool
     */
    public static function delete(CustomerDataModel $customerdata)
    {
        $data = $customerdata->delete();
        return $data;
    }

    /**
     * RemoveById the specified resource from storage.
     *
     * @param  $id
     * @return bool
     */
    public static function deleteById($id)
    {
        $data = CustomerDataModel::whereId($id)->delete();
        return $data;
    }



    /**
     * Get data for datatable from storage.
     *
     * @return Review with states, countries
     */
    public static function datatable()
    {
        $data = DB::table('customerdata')->orderBy('created_at', 'asc')->get();
        return $data;
    }
}
