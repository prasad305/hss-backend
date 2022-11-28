@extends('Layouts.ManagerAdmin.master')


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Video Feed</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Video Feed List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row m-3">
                <h3>Appeal Failed Video</h3>

                @if ($appealedGeneralVideos)
                    @foreach ($appealedGeneralVideos->videos as $video)
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                            <div class="card">
                                <div class="panel panel-primary p-2 text-center">
                                    <video class="img-fluid card-img" controls src="{{ asset($video->video) }}">
                                    </video>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="row m-3">
                <h3>General Failed Video</h3>

                @if ($notAppealedGeneralVideos)
                    @foreach ($notAppealedGeneralVideos->videos as $video)
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-2">
                            <div class="card">
                                <div class="panel panel-primary p-2 text-center">
                                    <video class="img-fluid card-img" controls src="{{ asset($video->video) }}">
                                    </video>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            @if ($appealedGeneralVideos || $notAppealedGeneralVideos)
                <Button class="btn btnPending waves-effect fw-bold waves-light m-3"><a class="Link"
                        href="{{ route('managerAdmin.audition.videoPublishedToVideofeed', $round_info_id = $appealedGeneralVideos ? $appealedGeneralVideos->id : $notAppealedGeneralVideos) }}">
                        Published To Video Feed</a></Button>
            @endif

        </div><!-- /.container-fluid -->
    </div>

    @if (session()->has('success'))
        <script type="text/javascript">
            $(document).ready(function() {
                // notify('{{ session()->get('success') }}','success');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        </script>
    @endif
@endsection
