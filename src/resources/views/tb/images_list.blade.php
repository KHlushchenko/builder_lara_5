@if (count($list))
    @foreach($list as $img)
        <div class="one_img_uploaded" onclick="TableBuilder.selectImgInStorage($(this))">
            <img src="{{glide('/storage/editor/fotos/'. basename($img), ['w'=>100, 'h' => 100])}}" data-path = 'storage/editor/fotos/{{basename($img)}}'>
        </div>
    @endforeach
@endif