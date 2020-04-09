
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
                                    <form method="post" action="{{ route('post_upload_excel') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="file" name="upload_excel" class="form-control">
                                                    </div>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td align="center">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="return confirm('Are you sure?')">Upload Excel from finance</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        </form>

                                        <form method="post" action="{{ route('post_upload_excel_cv_number') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="file" name="upload_excel_cv" class="form-control">
                                                    </div>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td align="center">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="return confirm('Are you sure?')">Upload FOR CV NUMBER</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        </form>
                                       <table id="datatable">
                                                <thead>
                                                     <tr>
                                                        <td colspan="6">Summary
                                                            <form method="post" action="{{ route('download_excel') }}"  enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <button type="submit">download excel</button>
                                                            </form>
                                                            <form method="post" action="{{ route('clear_excel') }}"  enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <button type="submit">Clear</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Emp No.</th>
                                                        <th>Name</th>
                                                        <th>CV No</th>
                                                        <th>Amount</th>
                                                        <th>Loan Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <?php 

                                                        $result = DB::select("SELECT * FROM upload_excel.tbl_uploads");
                                                        $i = 1;
                                                        foreach ($result as $rows) {
                                                            echo '<tr>
                                                                    <td>'.$i++.'</td>
                                                                    <td>'.$rows->employee_number.'</td>
                                                                     <td>'.$rows->name.'</td>
                                                                     <td>'.$rows->cv_number.'</td>
                                                                     <td>'.$rows->amount.'</td>
                                                                    <td>'.$rows->loan_type.'</td>
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