<?php


enum RequisitionStatus:string
{
    case  STATUS_WAITING_TO_BE_FULFILLED = "waiting to be fulfilled";
    case STATUS_FULFILLED = "fulfilled";
    case STATUS_REJECTED = "rejected";
}