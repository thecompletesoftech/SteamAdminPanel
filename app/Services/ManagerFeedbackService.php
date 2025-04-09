<?php

namespace App\Services;

use App\Models\ManagerFeedbackModel;
use Illuminate\Support\Facades\DB;

class ManagerFeedbackService
{

    public static function create(array $data)
    {
        $data = ManagerFeedbackModel::create($data);
        return $data;
    }

    public static function update(array $data,ManagerFeedbackModel $managerfeedback)
    {
        $data = $managerfeedback->update($data);
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = ManagerFeedbackModel::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = ManagerFeedbackModel::find($id);
        return $data;
    }

    public static function delete(ManagerFeedbackModel $managerfeedback)
    {
        $data = $managerfeedback->delete();
        return $data;
    }

    public static function deleteById($id)
    {
        $data = ManagerFeedbackModel::whereId($id)->delete();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('managerfeedback')->orderBy('created_at', 'asc')->get();
        return $data;
    }

}
