@extends('template')

@section('title')
		Owner List
@endsection

@section('css_file')
 <!-- DataTables -->
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"/>

@endsection

@section('content')
 
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Wing List		
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Wing List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          @if ($message = Session::get('success'))
            <div class="alert alert-success">
              <p>{{ $message }}</p>
            </div>
          @endif
          <div class="box">
            <div class="box-header" >
			
			@foreach($companies as $c)	
			<a href="/wing_owner_list/{{ $c->id}}" @if($c->id == $cid) class="btn btn-success" @else class="btn btn-info" @endif >{{ $c->name}}</a>  
			@endforeach
			
			
			<a href="/uploadOwnerPage" style="float: right;" class="btn btn-success">Import Owner</a> &nbsp;
			<a href="/files/OwnerExcelWithUniqeNo.xls" class="btn btn-primary pull-right" style='margin-right:10px;'>Sample Sheet</a> 
            <!-- /.box-header -->
            <div class="box-body">			
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>                  
                  <th width="10%">Uniqe No</th>
                  <th width="30%">Building Name</th>
                  <th width="30%">Description</th> 
                  <th width="10%">Updated Date</th>
                  <th width="20%">Action</th>                          
                </tr>
                </thead>
         
                <tbody>
                <?php $c=1; ?>
                @foreach($wings as $w)
                <tr>
                  <td>{{ $w->id }}</td>
                  <td>{{ $w->name}}</td>
                  <td>{{ $w->description}}</td>
                  <td>{{ $w->updated_date}}</td>         
                  <td>					
                    <a href="/owner_list/{{ $w->id }}" class="btn btn-primary">View</a>
					<a href="/exportOwner/{{ $w->id }}" class="btn btn-warning">Export</a>
					<a href="/add_owner/{{ $w->id }}" class="btn btn-danger">Add Owner</a>
                  </td>
                 </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 @endsection
 
@section('js_file')
 <!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

@endsection

@section('script')
<script>
$(function () {
    $('#example1').DataTable({
      "aaSorting": [[ 1, "asc" ]],
      "paging": false
    });
	
    
  })
</script>
@endsection