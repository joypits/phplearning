
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
<style type="text/css">
   #datatable{
    width: 50%;
    border-collapse: collapse;
   }
     #datatable tr td,th{
        border: 1px solid #000;
        padding: 5px;
    }
   
   .tbl_interest{
    border-collapse: collapse;
    padding: 5px;
   }
   .tbl_interest tr td{
    border:1px solid #000;
    padding: 20px;
   }
</style>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <center>
                                    <table class="tbl_interest">
                                        <tr>
                                            <td>

                                              <form method="post" action="{{ route('post_upload_member_interest') }}" enctype="multipart/form-data">
                                                {{ csrf_field() }}

                                                    <div class="form-group">
                                                            <input type="file" name="upload_interest" class="form-control">
                                                        </div>
                                                        <br>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="return confirm('Are you sure?')">Upload Member Interest</button>
                                                        </div>
                                                          
                                                    </form>
                                        </td>
                                        <td>
                                              <form method="post" action="{{ route('post_update_interest') }}" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <input type="file" name="update_interest" class="form-control">
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="return confirm('Are you sure?')">Update Interest CV Number</button>
                                                    </div>
                                                       
                                                    </form>
                                            </td>
                                        </tr>
                                    </table>
                                     <table id="datatable">
                                                <thead>
                                                     <tr>
                                                        <td colspan="6">Summary
                                                            <form method="post" action="{{ route('download_excel_interest') }}"  enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <button type="submit">download excel</button>
                                                            </form>
                                                            <form method="post" action="{{ route('clear_excel_interest') }}"  enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <button type="submit">Clear</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Emp No.</th>
                                                        <th>payee</th>
                                                        <th>CV No</th>
                                                        <th>Amount</th>
                                                        <th>Loan Type</th>
                                                         <th>Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <?php 

                                                        $result = DB::select("SELECT * FROM upload_excel.tbl_interest order by id asc");

                                                        $sum = DB::table('tbl_interest')->sum('amount');
                                                        $i = 1;
                                                        echo '<tr><td style="color:red" colspan="6">Grand Total: '.number_format($sum).'</td></tr>';
                                                        foreach ($result as $rows) {
                                                            echo '<tr>
                                                                    <td>'.$i++.'</td>
                                                                    <td>'.$rows->employee_number.'</td>
                                                                     <td>'.$rows->payee.'</td>
                                                                     <td>'.$rows->cv_number.'</td>
                                                                     <td>'.$rows->amount.'</td>
                                                                    <td>'.$rows->loan_type.'</td>
                                                                     <td>'.$rows->year.'</td>
                                                                 </tr>';
                                                        }
                                                        

                                                    ?>
                                                </tbody>
                                        </table>

                                      
                                      
                                        
                                    </center>
                                </div>
                        </div>
                      
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>