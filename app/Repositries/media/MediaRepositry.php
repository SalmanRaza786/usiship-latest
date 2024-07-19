<?php

namespace App\Repositries\media;

use App\Http\Helpers\Helper;
use App\Models\FileContent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use DataTables;


class MediaRepositry implements MediaInterface
{

    public function deleteMedia($id)
    {
        try {
            $role = FileContent::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }

}
