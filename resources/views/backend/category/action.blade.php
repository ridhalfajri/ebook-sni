<div>
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="{{route('categories.edit',$id)}}" class="btn btn-outline-secondary"><i class="fa fa-edit"></i></a>
            <button type="button" class="btn btn-outline-secondary"onclick="delete_category({{ $id }})"><i class="fa fa-trash"></i></button>
        </div>
</div>
