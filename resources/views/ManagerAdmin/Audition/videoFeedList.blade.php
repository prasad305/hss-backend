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

    <section class="content">
        <div class="container-fluid">

            <h3 class="ml-5">Appeal Failed Video</h3>
            <div class="row">
                @if ($appealedGeneralVideos)
                    @foreach ($appealedGeneralVideos->videos as $video)
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box border border-warning">
                                <div class="row">

                                    <video width="390" height="315" controls src="{{ asset($video->video) }}">
                                    </video>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

    </section>
    <section class="content">
        <div class="container-fluid">
            <h3 class="ml-5">General Failed Video</h3>
            <div class="row">
                @if ($notAppealedGeneralVideos)
                    @foreach ($notAppealedGeneralVideos->videos as $video)
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box border border-warning">
                                <div class="row">

                                    <video width="390" height="315" controls src="{{ asset($video->video) }}">
                                    </video>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
    </section>
    @if ($appealedGeneralVideos || $notAppealedGeneralVideos)
        <Button class="btn btn-warning ml-3"><a class="Link"
                href="{{ route('managerAdmin.audition.videoPublishedToVideofeed', $round_info_id = $appealedGeneralVideos ? $appealedGeneralVideos->id : $notAppealedGeneralVideos) }}">
                Published
                To
                Video Feed</a></Button>
    @endif


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
