<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\UploadExcel;
use App\UploadExcel2;
use App\Comp2;
use App\Comp1;
use App\CVNumber;
use App\ApprovedLoan;
use App\Subsidiary;
use App\ForTestingOnly;
use App\Transactions;
use App\Billing;
use App\Interest;

use Validator;
use Hash;
use Auth;
use PDF;
use Excel;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // /**
    //  * Show the application dashboard.
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function billing()
    {
      $results = Billing::all();
      return view('billing',['results' => $results]);
    }

    public function post_upload_billing_excel(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'upload_excel' => 'required|mimes:txt'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message','The imported file must be a file of type: csv.');
        }

         $path =  $request->upload_excel->getRealPath();
         $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count())
          {
            foreach ($data->toArray() as $row)
            {
              
              
              if(!empty($row))
              {
                $bill[] =
                [
                  'employee_number' =>  $row['employee_number'],
                  'name' => $row['name'],
                  'cv_number' => $row['cv_number'],
                  'amount_paid' => $row['amount'],
                  'loan_type' => $row['loan_type'],
                  'amount_loan' => $row['amount_loan'],
                  'monthly_dues' => $row['monthly_dues'],
                  'billing_amount' => $row['billing_amount'],
                  'interest_amount' => $row['interest_amount'],
                  'date_loan' => $row['date_loan'],
                  'due_date' => $row['due_date'],
                  'true_false' => $row['true_false'],
                  'advance_payment' => $row['advance_payment'],
                  'billing_number' => $row['billing_number'],
                 
                 ];
               
              }

          }

            DB::beginTransaction();

            try 
              {

                  Billing::insert($bill);
                 
                  DB::commit();
                  return back();
              }
            catch (\Exception $e) {
                  DB::rollback();
                return back();

              }
      
        }
    }

    public function post_upload_excel_billing_finance(Request $request)
    {
      $validator = Validator::make($request->all(), 
        [
            'upload_excel_cv' => 'required|mimes:txt'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message','The imported file must be a file of type: csv.');
        }

         $path =  $request->upload_excel_cv->getRealPath();
         $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count())
          {
            foreach ($data->toArray() as $row)
            {
              
              
              if(!empty($row))
              {
                // $bill[] =
                // [
                //   'employee_number' =>  $row['employee_number'],
                //   'name' => $row['name'],
                //   'cv_number' => $row['cv_number'],
                //   'amount_paid' => $row['amount'],
                //   'loan_type' => $row['loan_type'],
                //   'amount_loan' => $row['amount_loan'],
                //   'monthly_dues' => $row['monthly_dues'],
                //   'billing_amount' => $row['billing_amount'],
                //   'interest_amount' => $row['interest_amount'],
                //   'date_loan' => $row['date_loan'],
                //   'due_date' => $row['due_date'],
                //   'true_false' => $row['true_false'],
                //   'advance_payment' => $row['advance_payment'],
                //   'billing_number' => $row['billing_number'],
                 
                //  ];
               Billing::where('employee_number', $row['employee_number'])
                      ->where('loan_type', $row['loan_type'])
                      ->update(['amount_paid' => $row['amount']]);
              }

          }

            DB::beginTransaction();

            try 
              {

                 // Billing::insert($bill);
                 
                  DB::commit();
                  return back();
              }
            catch (\Exception $e) {
                  DB::rollback();
                return back();

              }
      
        }
    }
    public function download_excel_billing_new()
    {
         $result = Billing::orderBy('id','asc')->get();
         $setData='';
                 $rowData = '<table border=1>
                               <tr>
                                  <th>employee_number</th>
                                  <th>name</th>
                                  <th>cv_number</th>
                                  <th>amount</th>
                                  <th>loan_type</th>
                                  <th>amount_loan</th>
                                  <th>monthly_dues</th>
                                  <th>billing_amount</th>
                                  <th>interest_amount</th>
                                  <th>date_loan</th>
                                  <th>due_date</th>
                                  <th>true_false</th>
                                  <th>advance_payment</th>
                                  <th>billing_number</th>
                                 </tr>';
                 foreach ($result as $data) {
                    $rowData .= '<tr>
                                  <td>'.$data->employee_number.'</td>
                                  <td>'.$data->name.'</td>
                                  <td>'.$data->cv_number.'</td>
                                  <td>'.$data->amount_paid.'</td>
                                  <td>'.$data->loan_type.'</td>
                                  <td>'.$data->amount_loan.'</td>
                                  <td>'.$data->monthly_dues.'</td>
                                  <td>'.$data->billing_amount.'</td>
                                  <td>'.$data->interest_amount.'</td>
                                  <td>'.$data->date_loan.'</td>
                                  <td>'.$data->due_date.'</td>
                                  <td>'.$data->true_false.'</td>
                                   <td>'.$data->advance_payment.'</td>
                                    <td>'.$data->billing_number.'</td>
                                </tr>';
                 }
                 $rowData .= '</table>';
         $setData .= trim($rowData);
      
         
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=BillingNew.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
         
        echo $setData;
    }

    public function index()
    {
        $results = UploadExcel::orderBy('description','asc')->get();
        $reg = UploadExcel::where('loan_type',0)->sum('amount');
        $loan1 = UploadExcel::where('loan_type',1)->sum('amount');
        $loan2 = UploadExcel::where('loan_type',2)->sum('amount');
        $loan3 = UploadExcel::where('loan_type',3)->sum('amount');
        $loan4 = UploadExcel::where('loan_type',4)->sum('amount');
        $loan5 = UploadExcel::where('loan_type',5)->sum('amount');
        $loan6 = UploadExcel::where('loan_type',6)->sum('amount');
        $loan7 = UploadExcel::where('loan_type',7)->sum('amount');
        return view('welcome',['results' => $results]);
    }

    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function post_upload_excel(Request $request)
    {


        $validator = Validator::make($request->all(), 
        [
            'upload_excel' => 'required|mimes:txt'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message','The imported file must be a file of type: csv.');
        }

          $path =  $request->upload_excel->getRealPath();
          $data = $this->csvToArray($path);

           foreach ($data as $row) {

              $name =  utf8_encode($row['name']);
              $Reg[] =
                [
                  'employee_number' =>  $row['employee_number'],
                  'name' => $name,
                  'amount' => $row['reg'],
                  'loan_type' => 0,
                 ];
                 $l1[] =
                [
                  'employee_number' =>  $row['employee_number'],
                  'name' => $name,
                  'amount' => $row['l1'],
                  'loan_type' => 1,
                 ];

                 $l2[] =
                [
                  'employee_number' =>  $row['employee_number'],
                  'name' => $name,
                  'amount' => $row['l2'],
                  'loan_type' => 2,
                 ];

                 $l3[] =
                [
                  'employee_number' =>  $row['employee_number'],
                  'name' => $name,
                  'amount' => $row['l3'],
                  'loan_type' => 3,
                 ];

                 $l4[] =
                [
                  'employee_number' =>  $row['employee_number'],
                  'name' => $name,
                  'amount' => $row['l4'],
                  'loan_type' => 4
                 ];

                 $l5[] =
                [
                  'employee_number' =>  $row['employee_number'],
                   'name' => $name,
                   'amount' => $row['l5'],
                  'loan_type' => 5
                 ];

                 $l6[] =
                [
                  'employee_number' =>  $row['employee_number'],
                  'name' => $name,
                   'amount' => $row['l6'],
                  'loan_type' => 6
                 ];

                 $l7[] =
                [
                  'employee_number' =>  $row['employee_number'],
                  'name' => $name,
                  'amount' => $row['l7'],
                  'loan_type' => 7
                 ];

           }
         

            DB::beginTransaction();

            try 
              {

                  UploadExcel::insert($Reg);
                  UploadExcel::insert($l1);
                  UploadExcel::insert($l2);
                  UploadExcel::insert($l3);
                  UploadExcel::insert($l4);
                  UploadExcel::insert($l5);
                  UploadExcel::insert($l6);
                  UploadExcel::insert($l7);
                  
                   // Comp1::insert($comp1);
                   // Comp2::insert($comp2);
                  DB::commit();
                  return back();
              }
            catch (\Exception $e) {
                  DB::rollback();
                return back();

              }
      
        
    }

    public function post_upload_excel_cv_number(Request $request)
    {
          $validator = Validator::make($request->all(), 
        [
            'upload_excel_cv' => 'required|mimes:txt'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message','The imported file must be a file of type: csv.');
        }

         $path =  $request->upload_excel_cv->getRealPath();
         $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count())
          {
            foreach ($data->toArray() as $row)
            {
              
              
              if(!empty($row))
              {
                // $cv_number[] =
                // [
                //   'employee_number' =>  $row['employee_number'],
                //   'amount' => $row['amount'],
                //   'cv_number' => $row['cv_number'],
                //   'loan_type' => $row['loan_type'],
                //   'terms' => $row['loan_duration'],
                //   'date_loan' => $row['date_loan'],
                //   'particulars' => $row['particulars'],
                //  ];
                  // CVNumber::where('employee_number', $row['employee_number'])
                  //          ->where('loan_type', $row['loan_type'])
                  //          ->update(['amount' => $row['amount']]);

                   // ApprovedLoan::where('employee_number', $row['employee_number'])
                   //             ->where('loan_type', $row['loan_type'])
                   //             ->where('cv_number', $row['cv_number'])
                   //             ->where('date_loan', $row['date_loan'])
                   //             ->where('loan_duration', $row['terms'])
                   //             ->update(['amount' => $row['amount']]);

                  // Subsidiary::where('employee_number', $row['employee_number'])
                  //             ->where('loan_type', $row['loan_type'])
                  //              ->where('cv_number', $row['cv_number'])
                  //              ->where('account_code', 121)
                  //              ->update(['debit' => $row['amount']]);

                  // ForTestingOnly::where('employee_number', $row['employee_number'])
                  //               ->where('loan_type', $row['loan_type'])
                  //                ->where('cv_number', $row['cv_number'])
                  //               ->update(['amount_loan' => $row['amount']]);

                  // Transactions::where('employee_number', $row['employee_number'])
                  //            ->where('loan_type', $row['loan_type'])
                  //              ->where('cv_number', $row['cv_number'])
                  //              ->where('date_loan', $row['date_loan'])
                  //              ->where('loan_duration', $row['terms'])
                  //            ->update(['debit' => $row['amount']]);

                // UploadExcel2::where('employee_number', $row['employee_number'])
                //                ->where('loan_type', $row['loan_type'])
                //                ->where('date_loan', $row['date_loan'])
                //                ->where('terms', $row['terms'])
                //                ->update(['amount' => $row['amount_granted']]);
                UploadExcel::where('employee_number', $row['employee_number'])
                               ->where('loan_type', $row['loan_type'])
                               ->update(['cv_number' => $row['cv_number']]);
                // $dividends[] =
                //         [
                //           'employee_number' =>  $row['employee_number'],
                //           'credit' => $row['credit'],
                //           'debit' => 0,
                //           'account_code' => $row['account_code'],
                //           'loan_type' => $row['loan_type'],
                //           'member_status' => $row['member_status'],
                //         ];

                // $trans[] =
                //         [
                //           'employee_number' =>  $row['employee_number'],
                //           'credit' => $row['credit'],
                //           'debit' => 0,
                //           'account_code' => $row['account_code'],
                //           'loan_type' => $row['loan_type'],
                //           'member_status' => $row['member_status'],
                //           'transact_type' => 'other'
                //         ]; 

              }

          }

            DB::beginTransaction();

            try 
              {

                // UploadExcel2::insert($cv_number);
               // Subsidiary::insert($dividends);
               //Transactions::insert($trans);
                  DB::commit();
                  return back();
              }
            catch (\Exception $e) {
                  DB::rollback();
                return back();

              }
      
        }
    }

    public function download_excel(Request $request)
    {
         $result = UploadExcel::orderBy('id','asc')->get();
         $setData='';
                 $rowData = '<table border=1>
                               <tr>
                                  <th>employee_number</th>
                                  <th>cv_number</th>
                                  <th>name</th>
                                  <th>amount</th>
                                  <th>loan_type</th>
                                 </tr>';
                 foreach ($result as $data) {
                    $rowData .= '<tr>
                                  <td>'.$data->employee_number.'</td>
                                  <td>'.$data->cv_number.'</td>
                                   <td>'.$data->name.'</td>
                                  <td>'.$data->amount.'</td>
                                  <td>'.$data->loan_type.'</td>
                                </tr>';
                 }
                 $rowData .= '</table>';
         $setData .= trim($rowData);
      
         
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=Final Loan Upload.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
         
        echo $setData;
    }

    public function clear_excel()
    {
       UploadExcel::truncate();
       return back();
    }

    public function interest()
    {
         $result = Interest::orderBy('id','asc')->get();
        // $reg = UploadExcel::where('loan_type',0)->sum('amount');
        // $loan1 = UploadExcel::where('loan_type',1)->sum('amount');
        // $loan2 = UploadExcel::where('loan_type',2)->sum('amount');
        // $loan3 = UploadExcel::where('loan_type',3)->sum('amount');
        // $loan4 = UploadExcel::where('loan_type',4)->sum('amount');
        // $loan5 = UploadExcel::where('loan_type',5)->sum('amount');
        // $loan6 = UploadExcel::where('loan_type',6)->sum('amount');
        // $loan7 = UploadExcel::where('loan_type',7)->sum('amount');
        return view('interest', ['result' => $result]);
    }

    public function post_upload_member_interest(Request $request)
    {
         $validator = Validator::make($request->all(), 
        [
            'upload_interest' => 'required|mimes:txt'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message','The imported file must be a file of type: csv.');
        }

         $path =  $request->upload_interest->getRealPath();
         $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count())
          {
            foreach ($data->toArray() as $row)
            {
              
              
              if(!empty($row))
              {
                $interests[] =
                [
                  'employee_number' =>  $row['employee_number'],
                  'payee' =>  $row['payee'],
                  'amount' => $row['amount'],
                  'loan_type' => $row['loan_type'],
                  'year' => $row['year'],
                  
                 ];
        
              }

          }

            DB::beginTransaction();

            try 
              {

                  Interest::insert($interests);
             
                  DB::commit();
                  return back();
              }
            catch (\Exception $e) {
                  DB::rollback();
                return back();

              }
      
        }
    }

    public function post_update_interest(Request $request)
    {
       $validator = Validator::make($request->all(), 
        [
            'update_interest' => 'required|mimes:txt'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error_message','The imported file must be a file of type: csv.');
        }

         $path =  $request->update_interest->getRealPath();
         $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count())
          {
            foreach ($data->toArray() as $row)
            {
              
              
              if(!empty($row))
              {
                // $interests[] =
                // [
                //   'employee_number' =>  $row['employee_number'],
                //   'amount' => $row['amount'],
                //   'loan_type' => $row['loan_type'],
                //   'year' => $row['year'],
                  
                //  ];
                  Interest::where('employee_number', $row['employee_number'])->where('loan_type', $row['loan_type'])->update(['cv_number' => $row['cv_number']]);
              }

          }

            DB::beginTransaction();

            try 
              {

                  //Interest::insert($interests);
             
                  DB::commit();
                  return back();
              }
            catch (\Exception $e) {
                  DB::rollback();
                return back();

              }
      
        }
    }

    public function download_excel_interest(Request $request)
    {
        $result = Interest::orderBy('id','asc')->get();
         $setData='';
                 $rowData = '<table border=1>
                               <tr>
                                  <th>employee_number</th>
                                  <th>payee</th>
                                  <th>cv_number</th>
                                  <th>amount</th>
                                  <th>loan_type</th>
                                  <th>year</th>
                                 </tr>';
                 foreach ($result as $data) {
                    $rowData .= '<tr>
                                  <td>'.$data->employee_number.'</td>
                                  <td>'.$data->payee.'</td>
                                  <td>'.$data->cv_number.'</td>
                                  <td>'.$data->amount.'</td>
                                  <td>'.$data->loan_type.'</td>
                                  <td>'.$data->year.'</td>
                                </tr>';
                 }
                 $rowData .= '</table>';
         $setData .= trim($rowData);
      
         
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=Interest For Upload.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
         
        echo $setData;
    }

    public function clear_excel_interest(Request $request)
    {
       Interest::truncate();
       return back();
    }
}
