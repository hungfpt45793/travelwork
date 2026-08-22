<?php

namespace App\Http\Controllers\Site;


use App\Entity\Input;
use App\Entity\InformationGeneral;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Post;
use App\Entity\User;
use App\Mail\Mail;
use App\Mail\Resetpassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Entity\Job;
use Illuminate\Support\Facades\DB;
use App\Entity\JobJobGroup;
use App\Entity\Employer;
use App\Entity\Employee;
use App\Entity\JobCareer;
use App\Entity\Invite;
use App\Entity\HistoryWork;

class CandidateApplyController extends SiteController
{
  
    public function index(Request $request){
        $user = Auth::user();
        if($user->role >= 2){
            $orderModel = new Order();
            $orders = $orderModel->leftJoin('employer','employer.employer_id','orders.employer_id')
            ->leftJoin('employees','employees.employee_id','orders.employee_id')
            ->leftJoin('jobs','jobs.job_id','orders.job_id')
            ->leftJoin('literacies','literacies.literacy_id','employees.literacy')
            ->select(
            'orders.order_id',
            'orders.status as order_status',
            'orders.date_order',
            'orders.cost_point',            
            'employees.*',
            'jobs.*',
            // 'history_work.company',
            // 'history_work.position',
            // 'history_work.content',
            'employer.enterprise_name',
            'literacies.literacy_name'
            )
            ->where('employer.employer_user_id',$user->id)
            ->limit(10)            
            ->orderBy('orders.order_id', 'desc')
                // ->count('orders.order_id') 
            ->get();


            // foreach ($historys as $history) {
            //     $orders['company'] = $history->company;
            //     $orders['position'] = $history->position;
            //     $orders['content'] = $history->content;
            // }
                
            return view('site.infomation.employer.apply_list', compact('user','orders'));
        }

            return redirect()->back();       
    }

    public function search(Request $request){
        $user = Auth::user();
        $word = $request->input('word');
            $orderModel = new Order();
            $orders = $orderModel->leftJoin('employer','employer.employer_id','orders.employer_id')
                ->leftJoin('employees','employees.employee_id','orders.employee_id')
                ->leftJoin('jobs','jobs.job_id','orders.job_id')
                ->leftJoin('literacies','literacies.literacy_id','employees.literacy')
                ->select(
                'orders.order_id',
                'orders.user_id',
                'orders.status as order_status',
                'orders.date_order',
                'orders.cost_point',
                'employees.*',
                'jobs.*',
                // 'history_work.company',
                // 'history_work.position',
                // 'history_work.content',
                'employer.enterprise_name',
                'literacies.literacy_name'
                ) 
                ->where('employer.employer_user_id',$user->id)                
                ->where('jobs.title', 'like', '%' .$word. '%')
                ->limit(10)            
                ->get();
                
        

                // foreach ($historys as $history) {
                //     $orders['company'] = $history->company;
                //     $orders['position'] = $history->position;
                //     $orders['content'] = $history->content;
                // }

                return view('site.infomation.employer.apply_list', compact('user','orders'));
  
    }


   public function edit($id){
        $user = Auth::user();
        $employers = Employer::get();
        $employers = Employee::get();
        if($user->role >= 2){
          $orderModel = new Order();
            $order = $orderModel->leftJoin('employer','employer.employer_id','orders.employer_id')
            ->leftJoin('employees','employees.employee_id','orders.employee_id')
            ->leftJoin('jobs','jobs.job_id','orders.job_id')
            ->leftJoin('literacies','literacies.literacy_id','employees.literacy')
            ->select(
                'orders.order_id',
                'orders.status as order_status',
                'orders.date_order',
                'jobs.job_id',
                'jobs.title',
                'jobs.content',
                'employees.*',
                'employer.enterprise_name',
                'employer.employer_id',
                'literacies.literacy_name'
            )    
            ->where('orders.order_id',$id)    
            ->orderBy('orders.order_id', 'desc')
            ->first();     
    
            return view('site.infomation.employer.editCandidateApply', compact('user','order','employers','employers'));
        }
        return redirect()->back();

    }
    public function update($id ,Request $request){
        $user = Auth::user();
            // if($user->role >= 2){
                $orderModel = new Order();
               
                $order = $orderModel->where('order_id',$id)
                ->update([
                    // 'job_id' => $request->input('job_id'),
                    // 'date_order' => $request->input('date_order'),
                    'status' => $request->input('status'),
                    'updated_at' => new \DateTime()
                ]);

                if($request->has('note')){
                    NoteOrders::where('note_order_id', $request->input('note-order'))
                        ->update([
                            'order_id' => $order->order_id
                        ]);
                }
                DB::commit();
                
                return redirect('/quan-ly-ung-vien')->with('sucsses1','Cập nhật thành công');
                
            // }
        // return redirect()->back()->with('error');
    }

    public function delete($id){
        $user = Auth::user();
        if($user->role >= 2){
            $orderModel = new Order();
            $orderModel->where('order_id', $id)
            ->delete();
            return redirect()->back();
        }
    }

    public function evaluate($id ,Request $request){
        try{
        Order::where(('order_id'),$id)
        ->update([
            'cost_point' =>$request->input('status'),
            'note_admin' =>$request->input('note')
        ]);
        
        DB::commit();
        }
        catch (\Exception $e) {
            Error::setErrorMessage("Không thể Đánh giá ứng viên  vui lòng thử lại ");
            DB::rollBack();
            }

        return redirect()->back()->with('sucsses2','Đánh giá thành công  thành công');
    }



    

}