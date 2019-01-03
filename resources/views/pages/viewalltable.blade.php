@extends('layouts.app')
@section('content')
<h1>Members <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addModal">Add New Member</button></h1>


@if(Session::has('message'))
<p class="alert alert-info">{{ Session::get('message') }}</p>
@endif
<script>
   $(document).on( "click", '.edit_button',function(e) {
   var id = $(this).data('id');
    var name = $(this).data('name');
    var email = $(this).data('email');
    var contact = $(this).data('contact');
   
    $(".member_id").val(id);
    $(".member_name").val(name);
    $(".member_email").val(email);
    $(".member_contact").val(contact);
    tinyMCE.get('member_content').setContent(content);   
});

        $(document).ready(function(){
       var table = $('#example').DataTable({
          'ajax': 'https://api.myjson.com/bins/1us28',
          'columnDefs': [
             {
                'targets': 0,
                'render': function(data, type, row, meta){
                   if(type === 'display'){
                      data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                   }
    
                   return data;
                },
                'checkboxes': {
                   'selectRow': true,
                   'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                }
             }
          ],
          'select': 'multi',
          'order': [[1, 'asc']]
       });
    });
    </script>
    
    <div class="container-fluid">
            @if(count($allmembers) > 0)
              
        <table id="example" class="table table-bordered table-striped" cellspacing="0" width="100%">
           <thead>
              <tr>
                 <th>ID</th>        
                 <th>Name</th>
                 <th>Gender</th>
                 <th>Email</th>
                 <th>Mobile</th>
                 <th>Created at</th>
                 <th>Last Updated</th>
                 <th>Action</th>
                </tr>
           </thead>
           @foreach($allmembers as $members)
                    <tr>
                     <td>{{$members->id}}</td>
                    <td>{{$members->name}}</td>
                    <td>{{$members->gender}}</td>
                    <td>{{$members->email}}</td>
                    <td>{{$members->mobile}}</td>
                    <td>{{$members->created_at}}</td>
                    <td>{{$members->updated_at}}</td>
                    <form action="/updatedataapi" method="POST" onsubmit="return confirm('Are you sure you want to Update?')">
     
                    <td>
                     
                        <button type="button" class="btn btn-primary btn-xs edit_button" 
                        data-toggle="modal" data-target="#myModal"
                        data-id="{{$members->id}}"
                        data-name="{{$members->name}}"
                        data-email="{{$members->email}}"
                        data-contact="{{$members->mobile}}">
                        Edit
                    </button>
                  </form>
                     &nbsp;
                     <a href="/deletedataapi/{{$members->id}}" onclick="return confirm('Are you sure to delete {{$members->name}} ?')">
                        <img src="{{ asset('image/DeleteButton.png') }}" width="25" height="25">
                        </a>
                  
                  </td>
                    </tr>
        
            @endforeach
           <tfoot>
              <tr>
                  <th>ID</th>        
                  <th>Name</th>
                  <th>Gender</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Created at</th>
                  <th>Last Updated</th>
                 <th>Action</th>
                </tr>
           </tfoot>
        </table>

        <!-- Modal for Edit button -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Edit Member</h4>
              </div>
              <form method="POST" action="/updatedataapi" onsubmit="return confirm('Are you sure you want to update?')">
                  <div class="modal-body">
                      <div class="form-group">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">

                          <input class="form-control member_id" type="hidden" name="id">
                          <input class="form-control member_name" name="name" placeholder="Enter Name" required>
                          <br>
                          <input class="form-control member_email" name="email" placeholder="Enter Email" required>
                          <br>
                          <input class="form-control member_contact" name="contact" placeholder="Enter Contact" required>
                      </div>
                      </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <!-- End of Modal for Edit button -->


  

        @else
        <p>Its Empty here, Add some menbers to start broadcast...</p>
    @endif
 <!-- Modal for Add button -->
 <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Add Member</h4>
              </div>
              <form method="POST" action="/adddataapi" onsubmit="return confirm('Are you sure you want to addd new member?')">
                  <div class="modal-body">
                      <div class="form-group">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">

                          <input class="form-control member_id" type="hidden" name="id">
                          <input class="form-control member_name" name="name" placeholder="Name" required>
                          <br>       
                           <label class="radio-inline"><input type="radio" value="MALE" name="gender" checked>MALE</label>
                           <label class="radio-inline"><input type="radio" value="FEMALE" name="gender">FEMALE</label>
                          <br><br>
                          <input type="email" class="form-control member_email" name="email" placeholder="Email" required>
                          <br>
                          <input type="number" class="form-control member_contact" name="contact" placeholder="Contact" required>
                      </div>
                      </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <!-- End of Modal for Add button -->
   </div>
        

@endsection