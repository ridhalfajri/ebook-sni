<div>
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="{{route('ebooks.edit',$id)}}" class="btn btn-outline-secondary"><i class="fa fa-edit"></i></a>
            <a href="{{route('ebooks.show',$id)}}" class="btn btn-outline-secondary"><i class="fa fa-eye"></i></a>
            <button type="button" class="btn btn-outline-secondary"onclick="delete_ebook({{ $id }})"><i class="fa fa-trash"></i></button>
        </div>
</div>
