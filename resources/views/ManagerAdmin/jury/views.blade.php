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
            <p class="viewSakib"> Sakib Al Hasan</p>
            <p class="viewWelcome">Welcome to Hello Superstar </p>
            <p class="viewLorem">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aut asperiores reiciendis beatae
                fugiat
                sed nemo illum? Illum voluptates saepe,
                incidunt ducimus commodi omnis minima enim pariatur similique? Delectus, natus fugiat.
            </p>
            <p class="ViewList"> 1 .Lorem ipsum, dolor sit amet consectetur a </p>
            <p class="ViewList"> 2 .Lorem ipsum, dolor sit amet consectetur a </p>
            <p class="ViewList"> 3 .Lorem ipsum, dolor sit amet consectetur a </p>
            <p class="ViewList"> 4 .Lorem ipsum, dolor sit amet consectetur a </p>
            <p class="ViewList"> 3 .Lorem ipsum, dolor sit amet consectetur a </p>
            <p class="ViewList"> 4 .Lorem ipsum, dolor sit amet consectetur a </p>

            <div class="dQr">
                <img class="Imgqr" src="{{ asset('qr_img/qrCode.png') }}" alt="" /><br>
                <p class="ViewListC">987 123 9876</p>
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
