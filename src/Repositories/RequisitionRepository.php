<?php

namespace Nisimpo\Requisition\Repositories;


use Nisimpo\Requisition\Models\Requisition;
/**
 * Class RequisitionRepository
 * @package Requisition
 * @version August 16, 2017, 8:38 pm UTC
 *
 * @method Requisition findWithoutFail($id, $columns = ['*'])
 * @method Requisition find($id, $columns = ['*'])
 * @method Requisition first($columns = ['*'])
 */
class RequisitionRepository extends BaseRepository
{

    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'date',
        'reference_no',
        'total_amount',
        'currency'
    ];

    protected array $tablesJoinable;

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return Requisition::class;
    }

    public function onGoodRequisitionApproval($approval)
    {

    }

    public function createRequisition($jobcard)
    {
        //begin transaction
//        DB::beginTransaction();
//        try {
//
//            $goodRequisition = Requisition::create([
//                'requested_by' => $jobcard->issued_by,
//                'issued_at' => Carbon::now(),
//                'reference_no' => 'ReqRef#',
//                'status' => Approval::$STATUS_WAITING_FOR_APPROVAL,
//                'total_amount' => $jobcard->total_amount,
//                'is_maintenance' => true,
//            ]);
//
//            foreach ($jobcard->jobCardItems as $jobCardItem) {
//
//                if ($jobCardItem->status == maintenanceStatusToBeReplaced()) {
//                    $goodRequisitionItem = RequisitionItem::create([
//                        'name' => $jobCardItem->getName(),
//                        'good_requisition_id' => $goodRequisition->id,
//                    ]);
//                    $jcGeneralLineItem = $jobCardItem->generalLineItem;
//                    $generalLineItem = new GeneralLineItem ([
//                        'name' => $jcGeneralLineItem->name,
//                        'quantity' => $jcGeneralLineItem->quantity,
//                        'sub_total_amount' => $jcGeneralLineItem->sub_total_amount,
//                        'unit_amount' => $jcGeneralLineItem->unit_amount,
//                        'item_id' => $jcGeneralLineItem->item_id,
//                        'unit_id' => $jcGeneralLineItem->unit_id
//                    ]);
//                    $goodRequisitionItem->generalLineItem()->save($generalLineItem);
//                }
//
//
//            }
//
//            //attach  approval
//           $this->approvalRepository->attachApprovalProcess($goodRequisition,
//                ApprovalWorkFlow::getRequisitionApprovalWorkFlows());
//        } catch (ModelNotFoundException $e) {
//            DB::rollback();
//            //dd(get_class_methods($e)); // lists all available methods for exception object
//            Log::info("fail to create good requisition: " . print_r(get_class_methods($e), true));
//
//        }
//        DB::commit();
    }

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function getTablesJoinable(): array
    {
        return $this->tablesJoinable;
    }
}
