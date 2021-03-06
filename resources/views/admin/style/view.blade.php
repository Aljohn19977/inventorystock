@extends('admin.partials.master')

@section('style')
<!-- MultiSelect -->
<link rel="stylesheet" href="{{ asset('admin/dist/css/bootstrap-multiselect.css')}}">
@endsection

@section('script')
<!-- MultiSelect -->
<script src="{{ asset('admin/dist/js/bootstrap-multiselect.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('admin/dist/js/sweetalert2.min.js') }}"></script>

<script>
$(document).ready(function(){


    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

var selected_brand = {{ $styles->brand_id }};
var selected_category = {{ $styles->category_id }};

multiselect();

$('.select-ajax').multiselect({
    maxHeight: 400,
    buttonWidth: '100%',
    includeSelectAllOption: true,
    enableFiltering: true,
}); 
    
  function multiselect (){
      $.ajax({
        type: 'GET',
        url: '/apiGetAllBrand',
        dataType: 'json',
        success: function(data) {
          $('#select_brand').find('option').remove()
          $.each(data.items, function (i, item) {
              if(item.id == selected_brand){
                $('#select_brand').append('<option value="' + item.id + '" selected>' + item.name + '</option>'); 
              }else{
                $('#select_brand').append('<option value="' + item.id + '">' + item.name + '</option>');   
              }  
          });
          $('#select_brand').multiselect('rebuild');
          $('#select_brand').multiselect('disable');
        },
        error: function() {
              alert('error loading items');
        }
      });

      $.ajax({
        type: 'GET',
        url: '/apiGetAllCategory',
        dataType: 'json',
        success: function(data) {
          $.each(data.items, function (i, item) {
              if(item.id == selected_category){
                $('#select_category').append('<option value="' + item.id + '" selected>' + item.name + '</option>'); 
              }else{
                $('#select_category').append('<option value="' + item.id + '">' + item.name + '</option>');   
              }  
          });
          $('#select_category').multiselect('rebuild');
          $('#select_category').multiselect('disable');
        },
        error: function() {
              alert('error loading items');
        }
      });
  }  

});

</script>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Style Management
        <small>Add Style</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
         <!-- general form elements -->
         <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Style</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" id="insert_form">
              <div class="box-body">
              <div id="error"></div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group" id="sku_style_id_this">
                      <label for="style_id">ID</label>
                      <input type="email" class="form-control" id="sku_style_id" value="{{ $styles->sku_style_id }}" disabled>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="brand_id_this">
                      <label>Brand</label>
                      <select class="select-ajax form-control" id="select_brand"></select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="category_id_this">
                      <label>Category</label>
                      <select class="select-ajax form-control" id="select_category"></select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group" id="name_this">
                      <label for="name">Name</label>
                      <input type="text" value="{{ $styles->name }}" class="form-control" id="name" placeholder="Enter Name" disabled>
                    </div>
                  </div>
                  <div class="col-md-2">
                   <div class="form-group" id="status_this">
                      <label>Status</label>
                      <select class="form-control select2" data-placeholder="Select Status" style="width: 100%;" id="status" disabled>
                            @if($styles->status == 'Active')
                            <option selected="selected" value="Active">Active</option>
                            @else
                            <option selected="selected" value="Deactive">Deactive</option>
                            @endif
                      </select>
                   </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="description_this">
                      <label>Description</label>
                      <textarea class="form-control" rows="3" id="description" placeholder="Enter Description" disabled>{{ $styles->description }}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->

    </section>
    <!-- /.content -->
  </div>
@endsection