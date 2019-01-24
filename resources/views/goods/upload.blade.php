@extends('layout.goods')

@section('content')
    <div class="container">
        <form action="/goods/upload/pdf" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="file" name="pdf">
            <input type="submit" value="UPLOAD">
        </form>
    </div>


@endsection

@section('footer')
    @parent
@endsection