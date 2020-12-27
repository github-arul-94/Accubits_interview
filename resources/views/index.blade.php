@extends('base')

@section('main')

<div class="row" style="">

<div class="col-sm-12" style="padding: 20px;">
<h3 class="display-3">Upload CSV File </h3> 
<a href="{{ url('/') }}" class="btn btn-primary" style="float: right;">Create New </a>
</div>
<div class="col-sm-12" style="padding: 20px;">   
    
@if(count($errors) > 0 )
<ul class="p-0 m-0">
    @foreach ($errors as $i=> $error)
        <li style="color : red;">{{$error}}</li>
    @endforeach
</ul>
@endif
@if($success !='' )
<ul class="p-0 m-0">
    <li style="color : green;">{{$success}}</li>
</ul>
@endif
<span>Notes :</span>

<ul class="p-0 m-0">
    <li>First Column name should be : <span style="color : green;">Module Code </span> in csv file</li>
    <li>Second Column name should be : <span style="color : green;">Module Name</span>  in csv file</li>
    <li>Third Column name should be : <span style="color : green;"> Module Term</span>  in csv file</li>
</ul>
    <form method='post' id="module_form" action="{{ url('/uploadFile') }}" enctype='multipart/form-data' >
       {{ csrf_field() }}
       <div class="form-group">
            <label for="exampleInputEmail1">Selct File</label>
            <input type='file' name='file' class="form-control" required />
          </div>
       
       <input type='submit' name='submit' id="submit_btn" value='Upload' class="btn btn-primary"/>
     </form>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $("#module_form").submit(function(){
        $("#submit_btn").html('Processing...');
    });
});
</script>
@endsection
