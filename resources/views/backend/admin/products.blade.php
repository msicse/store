@extends('layouts.backend.app')

@section('title','Admin | Products')

@push('css')
	<!-- JQuery DataTable Css -->
    <link href="{{ asset('backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
	
    <!-- JQuery Select Css -->
    <link href="{{ asset('backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet">

@endpush
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <button type="button" class="btn btn-primary waves-effect pull-right" style="margin-bottom:10px;" data-toggle="modal" data-target="#craeateCategory">
            <i class="material-icons">add</i>
            <span>Add New Product</span>
        </button>

    </div>
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        All Products
                        <span class="badge ">{{ $products->count() }}</span>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Model</th>
                                    <th>Unit</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Model</th>
                                    <th>Unit</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach( $products as $key => $data)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $data->title }}</td>
                                    <td>
                                        {{ $data->type }}
                                    </td>
                                    <td>{{ $data->model }}</td>
                                    <td>{{ $data->unit }}</td>
                                    <td>{{ $data->description }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success waves-effect edit" data-id="{{$data->id}}" data-toggle="modal" data-target="#editModal">
                                            <i class="material-icons">create</i>
                                        </button>

                                        <button type="button" class="btn btn-danger waves-effect delete" data-delete-id="{{$data->id}}" data-toggle="modal" data-target="#delete-modal" >

                                            <i class="material-icons">delete</i>
                                        </button>


                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
</div>

{{-- Modals --}}
<!-- Create -->
<div class="modal fade" id="craeateCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.products.store')}}" method="post">
                <div class="modal-header custom-modal">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Product</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group form-float">
                        <label class="form-label">Title</label>
                        <div class="form-line">
                            <input type="text" name="title" class="form-control" required>
                            
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <label class="form-label">Select Product Type</label>
                        <select name="type" class="form-control show-tick">
                            <option value="">Select Type</option>
                        
                            <option value="laptop">Laptop</option>
                            <option value="phone">Phone</option>
                            <option value="pendrive">Pendrive</option>
                            <option value="camera">Camera</option>
                            <option value="sim">Sim</option>
                        
                        </select>
                    </div>

                    <div class="form-group form-float">
                        <label class="form-label">Model</label>
                        <div class="form-line">
                            <input type="text" name="model" class="form-control" required>
                    
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <label class="form-label">Unit</label>
                        <div class="form-line">
                            <input type="text" name="unit" class="form-control" required>
                    
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <label class="form-label">Description</label>
                        <div class="form-line">
                            <textarea name="description" class="form-control" rows="6"></textarea>
                    
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect">Save</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Edit  -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="edit-form" action="" method="post">
                @csrf
                @method('PUT')

                <div class="modal-header custom-modal">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Product</h4>
                </div>
                <div class="modal-body">
                   
                    <div class="form-group form-float">
                        <label class="form-label">Title</label>
                        <div class="form-line">
                            <input type="text" id="title" name="title" class="form-control" required>
                            
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <label class="form-label">Select Product Type</label>
                        <select id="type" name="type" class="form-control show-tick">
                            <option id="st">Select Type</option>
                            <option value="laptop">Laptop</option>
                            <option value="phone">Phone</option>
                            <option value="pendrive">Pendrive</option>
                            <option value="camera">Camera</option>
                            <option value="sim">Sim</option>
                        </select>

                    </div>


                    <div class="form-group form-float">
                        <label class="form-label">Model</label>
                        <div class="form-line">
                            <input type="text" id="model" name="model" class="form-control" required>
                    
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <label class="form-label">Unit</label>
                        <div class="form-line">
                            <input type="text" name="unit" id="unit" class="form-control" required>
                    
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <label class="form-label">Description</label>
                        <div class="form-line">
                            <textarea name="description" class="form-control" rows="5" id="description"></textarea>
                    
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect">Save</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Delete Modal --}}
<div class="modal fade" id="delete-modal">
  <div class="modal-dialog">
      <form class="delete_form" method="post">
          @csrf
          @method('DELETE')
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Delete Product</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <strong>Are you sure to delete this information ?</strong>
              </div>
              <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
              </div>
          </div>
          <!-- /.modal-content -->
      </form>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@push('js')
	<!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

	<script src="{{ asset('backend/js/pages/tables/jquery-datatable.js') }}"></script>

    <script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>

<script>

$( ".edit" ).click(function( event ) {
    var id = $(this).data('id');
    var update_url = location.origin + "/admin/products/" + id;
    var url = location.origin + '/admin/products/' + id;
    $('.edit-form').attr('action', update_url);

    $.get(url, function (data) {
        $('#title').val(data['title']);
        $('#model').val(data['model']);
        $('#unit').val(data['unit']);
        $("#description" ).text(data['description']);
        //$("#type option" ).text();
       

        $('#type option[value="'+data['type']+'"]').attr('selected',true);
      
        //data-original-index


        // $('select#type option').each(function () {
        //     if ($(this).val() == data['producttype_id']) {
        //         this.selected = true;
        //         console.log(data['producttype_id']);
        // } });
    });
});




$( ".delete" ).click(function() {
    var data_id=$(this).data('delete-id');
    var url=location.origin+'/admin/products/'+data_id;
    $('.delete_form').attr('action',url);

});

$('#type').materialSelect();

</script>


@endpush
