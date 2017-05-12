 <table cellpadding="10" style="margin-left:2%;width:100%;">
    <th>Action</th>
    <th>Title</th>
    <th>Thumbnail image</th>
    @foreach($results as $k => $v)
       <tr>
    @foreach ($v as $key => $value)
        
        @if ($key == 'filename') 
        <td>
        <img width="100px" src="/storage/{{$value}}">
        </td>
        @endif
        @if ($key == 'title')
        <td>
           {{$value}}
        </td>
        @endif
        @if ($key == 'id')
          <td>
          <a href="/drawing/edit/{{$value}}" >edit</a>
          <br>
          <a href="/drawing/delete/{{$value}}" >delete</a>
          </td>
        @endif
        
    @endforeach
       </tr>
    @endforeach 
    </table>
