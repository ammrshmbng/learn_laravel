<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="{{ asset('/css/bootstrap.min.css')}} " rel="stylesheet">
  <title>Data Mahasiswa</title>
</head>
<body>

<div class="container text-center p-4">
  <h1 class="mb-3">Mahasiswa</h1>
  <div class="row">
    <div class="col-sm-8 col-md-6 m-auto">
      <ol class="list-group">
        @forelse ($mahasiswas as $mahasiswa)
          <li class="list-group-item">
            <a href="{{ url('mahasiswa/'.$mahasiswa->nim)}}">
	  	      {{ $loop->iteration }}. {{$mahasiswa->nama}}
	  	    </a>
          </li>
        @empty
          <div class="alert alert-dark d-inline-block">Tidak ada data...</div>
        @endforelse
      </ol>
    </div>
  </div>
</div>

</body>
</html>
