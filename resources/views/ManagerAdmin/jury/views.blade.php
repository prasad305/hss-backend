<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
</head>

<body class="bg-dark">
   <div class="container custom_container">
    <img class="img-View" src="{{ asset('qr_img/backGroundBanner.png') }}" alt="" />
    <div class="bodyView">
        <img class="ImGLogo" src="{{ asset('qr_img/helloSuperStar.png') }}" alt="" />

        <div class="BodyDear">
            <h5 class="viewDear">Dear,</h5>
            <p class="viewSakib"> {{ $jury->assignjuries->first_name.' '.$jury->assignjuries->last_name }}</p>
            <p class="viewWelcome">Welcome to Hello Superstar </p>
            <p class="viewLorem">
                {!! $jury->description !!}
            </p>
            <div>
                {!! $jury->terms_and_condition !!}
            </div>

            <div class="dQr">
                {!! QrCode::size(150)->generate($jury->qr_code); !!}
                <br>
                <p class="ViewListC">{{ $jury->qr_code? $jury->qr_code : '' }}</p>
            </div>

        </div>
    </div>

    <img class=" footerImage " src="{{ asset('qr_img/24783.jpg') }}" alt="" />
   </div>

    <!-- content -->

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Elsie+Swash+Caps:wght@400;900&display=swap");

        .custom_container {
            margin-top: 20px;
            width: 815px !important;
            position: relative;
            margin-bottom: 20px;

            background: white !important;
            font-family: "Elsie Swash Caps", cursive;
        }
        .img-View {
            width: 250px;
            height: 250px;
            position: absolute;
            top: 0px;
            right: 0px;
        }

        .bodyView {
            padding-left: 100px;
            padding-right: 80px;
            padding-bottom: 100px;
            position: relative;
        }

        .ImGLogo {
            width: 100px;
            height: 100px;
            margin-top: 100px;
        }

        .BodyDear {
            margin-left: 10px;
            margin-right: 10px;
            margin-top: 35px;
        }

        .viewDear {
            color: black;
        }

        .viewSakib {
            color: black;
            font-size: 35px;
        }

        .viewWelcome {
            color: black;
            font-size: 20px;
        }

        .viewLorem {
            color: black;
            font-size: 15px;
        }

        .ViewList {
            color: black;
        }

        .dQr {
            margin-bottom: 20px;
        }

        .ViewListC {
            color: black;
        }

        .Imgqr {
            width: 140px;
            margin-left: -15px;
        }

        .footerImage {
            height: 80px;
            width: 100%;
            object-fit: cover;
            position: absolute;
            bottom: 0px;
            left: 0px;
        }



    </style>
</body>

</html>
