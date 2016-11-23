<?php

namespace App\Models\Notices;

use App\Models\BaseModel;


class AlipayNotices extends BaseModel
{
    protected $table = 'alipay_notices';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
