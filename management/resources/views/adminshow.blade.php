<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

   
    <div class="card" style="width: 18rem;">
        <div class="card-body">
        <form id="my-form" method="post" action="{{url('/adminupdate/'.$admin->id)}}">
                              @csrf
                              <select class="form-select" name="staff_id" id="staff_id">
                                @foreach($user as  $users)
                                <option value="{{ $users->id}}" {{$users->id == $admin->staff_id ? 'selected':'' }}>{{$users->name}}</option>
                                    @endforeach
                              </select>
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-2 text-sm">
                              <label for="cars">Task</label>
                              <input type="text" value="{{$admin->task}}" name="task">
                            </h6>
                            <h6 class="mb-0 text-sm">
                              <label for="cars">Date</label>
                              <input type="datetime-local" id="done_at" value="{{$admin->done_at}}" name="done_at">

                            </h6>

                          </div>

                          <div class="text-center">
                            <button type="submit" id="btnSubmit" name="btn" class="form-control bg-secondary w-100 my-4 pl-4 mb-4">update</button>
                          </div>
                          </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>