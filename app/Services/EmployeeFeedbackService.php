<?php

namespace App\Services;

use App\Models\EmployeeFeedbackModel;
use Illuminate\Support\Facades\DB;

class EmployeeFeedbackService
{
    /**
     * Update the specified resource in storage.
     *
     * @param  array $data
     * @return Review
     */
    public static function create(array $data)
    {
        $data = EmployeeFeedbackModel::create($data);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array $data - Updated Data
     * @param  Review $promocode
     * @return Review
     */
    public static function update(array $data, EmployeeFeedbackModel $employeefeedback)
    {
        $data = $employeefeedback->update($data);
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
        $data = EmployeeFeedbackModel::whereId($id)->update($data);
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
        $data = EmployeeFeedbackModel::find($id);
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Review
     * @return bool
     */
    public static function delete(EmployeeFeedbackModel $employeefeedback)
    {
        $data = $employeefeedback->delete();
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
        $data = EmployeeFeedbackModel::whereId($id)->delete();
        return $data;
    }



    /**
     * Get data for datatable from storage.
     *
     * @return Review with states, countries
     */
    public static function datatable()
    {
        $data = DB::table('employee_feedback')->orderBy('created_at', 'asc')->get();
        return $data;
    }
}
