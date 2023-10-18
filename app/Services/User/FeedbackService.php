<?php 

namespace App\Services\User;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Requests\FeedbackRequest;
use App\Jobs\SendEmails​;
use App\Traits\General;
use Throwable;

class FeedbackService
{
    use General;

    public function store(FeedbackRequest $request){
        try{
            $request->validated();
                
            if ($request->hasFile('file')) {
                $this->imageUpload($request,'uploads/feedback','image');
            }
            $request->request->add(['created_by' => auth()->id()]);
            Feedback::create($this->createData($request));
            SendEmails​::dispatch('New feedback has been created');
        } catch(Throwable $caught){
            dd($caught);
        }
    }

    public function datatable(Request $request){
        
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Feedback::select('count(id) as allcount')->count();
        $totalRecordswithFilter = Feedback::select('count(id) as allcount')->where('title', 'like', '%' . $searchValue . '%')->where('created_by',auth()->id())->count();
        // Get records, also we have included search filter as well
        $records = Feedback::orderBy($columnName, $columnSortOrder)
        ->select('feedbacks.id', 'feedbacks.title', 'categories.name as category')
        ->selectSub(function ($query) {
            $query->selectRaw('COUNT(id)')
                ->from('feedback_votes as fv')
                ->whereColumn('fv.feedback_id', 'feedbacks.id');
        }, 'count')
        ->join('categories', 'feedbacks.category_id', '=', 'categories.id')
        ->where('feedbacks.created_by',auth()->id())
        ->where(function ($query) use ($searchValue) {
            $searchValue = '%' . $searchValue . '%';
            $query->orWhere('feedbacks.title', 'like', $searchValue)
                ->orWhere('categories.name', 'like', $searchValue);
        })
        ->groupBy('feedbacks.id')
        ->skip($start)
        ->take($rowperpage)
        ->get();
        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "title" => $record->title,
                "category_id" => $record->category,
                "count" => $record->count
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        echo json_encode($response);
    }
}