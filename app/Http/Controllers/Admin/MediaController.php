<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\media\MediaInterface;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    private $media;

    public function __construct(MediaInterface $media ) {
        $this->media = $media;

    }
    public function deleteMedia($fileId)
    {
        try {
            $res = $this->media->deleteMedia($fileId);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
