<html>
    <head>

    </head>

    <body>
    <div class="card-deck" style="width:100%;">

<div class="card  opacity-10">
  <div class="card-body text-center">
    <h4 class="card-title" style="display: inline-block;">All User Tasks</h4>

    <table class="table table text-white">
      <tr class="table-info">
        <th>No.</th>
        <th>Task</th>
        <th>Date</th>
        <th>Days</th>
      </tr>
      
         @if($tasks->staff_id==3)
         @foreach($task as $tasks)
           <p>{{$tasks->task}}</p>
           @endforeach
          @endif
      
    
    </table>

  </div>
</div>


</div>

</div>
    </body>
</html>       