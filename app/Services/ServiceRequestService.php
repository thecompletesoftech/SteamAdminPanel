<?php

namespace App\Services;

use App\Models\ServiceRequestModel;
use Illuminate\Support\Facades\DB;

class ServiceRequestService
{
    /**
     * Update the specified resource in storage.
     *
     * @param  array $data
     * @return Review
     */
    public static function create(array $data)
    {

        $data = ServiceRequestModel::create($data);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array $data - Updated Data
     * @param  Review $promocode
     * @return Review
     */
    public static function update(array $data, ServiceRequestModel $servicerequest)
    {
        $data = $servicerequest->update($data);
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
        $data = ServiceRequestModel::whereId($id)->update($data);
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
        $data = ServiceRequestModel::find($id);
        return $data;
    }



  


    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Review
     * @return bool
     */
    public static function delete(ServiceRequestModel $servicerequest)
    {
        $data = $servicerequest->delete();
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
        $data = ServiceRequestModel::whereId($id)->delete();
        return $data;
    }



    /**
     * Get data for datatable from storage.
     *
     * @return Review with states, countries
     */
    public static function datatable()
    {
        // $data = DB::table('service_request')->orderBy('created_at', 'asc')->get();

        $data = DB::table('service_request')
        ->select('service_request.*','service_request.id as id','service_request.Service_request','users.name as managername','service_request.manger_id as manger_id','service_request.created_at as service_request')
        ->join('users','users.id','=','service_request.manger_id',)
        ->orderBy('service_request.created_at', 'desc')->get();
        return $data;
    }
}
