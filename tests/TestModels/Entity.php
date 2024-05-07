<?php

namespace Nisimpo\Requisition\Test\TestModels;

use Illuminate\Database\Eloquent\Model;
use Nisimpo\Requisition\HasRequisition;

class Entity extends Model
{
    use HasRequisition;
    protected $guarded = [];

}