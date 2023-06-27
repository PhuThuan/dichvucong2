<h2>Xin chào {{ $data['name'] }}</h2> 
<br>
    
<strong>------------Nội dung ------------ </strong><br>
{{ $data['message'] }} <br>
<strong>--------------------------------- </strong><br>
<strong>Họ và tên: </strong>{{ $data['name'] }} <br>
@foreach($data['info'] as $key => $value)
    <strong>{{$key}}: </strong>{{ $value }} <br>
@endforeach

  
Thank you