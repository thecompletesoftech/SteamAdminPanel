<?php

namespace App\Services;

use App\Models\CustomerFeedbackModel;
use Illuminate\Support\Facades\DB;

class CustomerFeedbackService
{

    public static function create(array $data)
    {
        $data = CustomerFeedbackModel::create($data);
        return $data;
    }

    public static function update(array $data,CustomerFeedbackModel $review)
    {
        $data = $review->update($data);
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = CustomerFeedbackModel::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = CustomerFeedbackModel::find($id);
        return $data;
    }

    public static function delete(CustomerFeedbackModel $review)
    {
        $data = $review->delete();
        return $data;
    }

    public static function deleteById($id)
    {
        $data = CustomerFeedbackModel::whereId($id)->delete();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('customerfeedback')->orderBy('created_at', 'asc')->get();
        return $data;
    }

}
