<link type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.5/datatables.min.css" rel="stylesheet" />
<link type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.5/datatables.min.js"></script>
<script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>

<div class="container-fluid">
        @if(count($allmembers) > 0)
    
{{-- <form id="frm-example" action="/broadcaststaging" method="POST">
    {{ csrf_field() }} --}}
<table id="example" class="display" cellspacing="0" width="100%">
   <thead>
      <tr>
         <th></th>
         <th>Name</th>
         <th>Gender</th>
         <th>Mobile</th>
         <th>Email</th>
      </tr>
   </thead>
   <tfoot>
      <tr>
         <th></th>
         <th>Name</th>
         <th>Gender</th>
         <th>Mobile</th>
         <th>Email</th>
      </tr>
   </tfoot>
</table>

{{-- <hr>

<p>Press <b>Submit</b> and check console for URL-encoded form data that would be submitted.</p>

<p><button type="submit">Submit</button></p> --}}

{{-- <p><b>Selected rows data:</b></p>
<pre id="example-console-rows"></pre>

<p><b>Form data as submitted to the server:</b></p>
<pre id="example-console-form"></pre> --}}

{{-- </form> --}}


        @else
    <p>Its Empty here, Add some menbers to start broadcast...</p>
@endif
    </div>

    <script>
$(document).ready(function() {
   var table = $('#example').DataTable({
      'ajax': '/dataapi',
      'columnDefs': [
         {
            'targets': 0,
            'checkboxes': {
               'selectRow': true
            }
         }
      ],
      'select': {
         'style': 'multi'
      },
      'order': [[1, 'asc']]
   });
   
   // Handle form submission event 
   $('#frm-example').on('submit', function(e){
      var form = this;
      
      var rows_selected = table.column(0).checkboxes.selected();

      // Iterate over all selected checkboxes
      $.each(rows_selected, function(index, rowId){
         // Create a hidden element 
         $(form).append(
             $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'id[]')
                .val(rowId)
         );
      });

      // FOR DEMONSTRATION ONLY
      // The code below is not needed in production
      
      // Output form data to a console     
    //  $('#example-console-rows').text(rows_selected.join(","));
      
      // Output form data to a console     
     // $('#example-console-form').text($(form).serialize());
       
      // Remove added elements
    //  $('input[name="id\[\]"]', form).remove();
       
      // Prevent actual form submission
     // e.preventDefault();
   });   
});

            </script>