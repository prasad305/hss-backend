<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assests/Style.css" />
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Nanum+Brush+Script&family=Roboto+Condensed:wght@300;400&display=swap');


        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;



        }

        h2,
        h3 {
            color: white;
            font-family: 'Lato', sans-serif;
            letter-spacing: 3px;

        }

        table,
        th,
        td {
            border: 1px solid #3A3744;
            border-collapse: collapse;
            margin: 0;
            padding: 0;

        }

        .full-container {
            min-height: 100vh;
            /* background-color: #F2F5F8; */


        }

        .ticket-container {
            width: 800px;
            margin: 0px auto;

        }

        .collumn-1 {
            width: 28%;

            background-image: url('{{ asset('/assets/img/paradise.png') }}');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .collumn-2 {
            background-color: #3A3744;

        }

        .collumn-3 {
            background-color: #F6F6F6;
            width: 29%;

        }

        .img-style {
            height: 120px;
            width: 120px;
            border-radius: 100%;

        }

        .img-style-2 {
            /* height: 20px; */
            width: auto;

        }

        .img-logo {
            text-align: center;
            margin: 20px 0 20px 0;
        }

        .img-logo-2 {
            text-align: center;
            /* margin-top: -10%; */
            /* background-color: red; */



        }

        .img-logo-3 {
            text-align: center;
        }

        .collum-2-content {
            background-color: #2B2934;

        }

        .column-2-sub-content {
            padding: 20px;
            font-family: 'Lato', sans-serif;
            font-weight: 300;
            letter-spacing: 3px;
        }

        .collum-2-content-2 h1 {
            color: #ffaa00;
        }

        .collum-2-content-2 p {
            color: white;
        }

        .content-3 {
            font-family: 'Roboto Condensed', sans-serif;
            text-align: center;
            font-weight: 400;
            letter-spacing: 3px;
            margin-top: 40px;
        }

        .content-3-last {
            height: 20px;
            background-color: #2F2F2F;
            width: 60%;
            margin: 0 auto;
        }

        .ticket-number {
            color: gray;
            font-family: 'Roboto Condensed', sans-serif;
            font-weight: 400;
            letter-spacing: 4px;
        }
    </style>
</head>

<body>
    <div class="full-container">
        <div class="ticket-container">
            <div style="padding-top: 40px">
                <table style="width: 100%">
                    <tr>
                        <td class="collumn-1">

                        </td>
                        <td class="collumn-2">
                            <div class="center-items">
                                <div class="img-logo">
                                    <img src="{{ asset('/assets/img/Logo.png') }}" alt="" />
                                </div>

                                <div class="collum-2-content">
                                    <div class="column-2-sub-content">
                                        <h2>{{ $meetUp->title }}</h2>
                                        <h3>AT {{ $meetUp->venue }}</h3>
                                    </div>
                                </div>

                                <div class="collum-2-content-2 column-2-sub-content">
                                    <h1>{{ $meetUp->event_date }}</h1>
                                    <p>Pan Pacific Sonargaon , Banani Dhaka-1213</p>
                                </div>
                            </div>
                        </td>
                        <td class="collumn-3">

                            <div class="center-items-2">
                                <div class="img-logo-2">
                                    {{-- <img src="./assests/img/col-2top.png" class="img-style-2" alt="" /> --}}
                                    <img src="{{ asset('/assets/img/col-2top.png') }}" alt="" />
                                </div>
                                <div class="content-3">
                                    <h4>Name</h4>
                                    <p>{{ $user->first_name . ' ' . $user->last_name }}</p>
                                </div>
                                <div class="content-3">
                                    <h4>Address</h4>
                                    <p>{{ $meetUp->venue }}</p>
                                </div>
                                <div class="content-3">
                                    <h4>Time</h4>
                                    <p>{{ $meetUp->start_time . '-' . $meetUp->end_time }}</p>
                                </div>
                                <div class="img-logo-3">
                                    {{-- <img src="./assests/img/bottomQR.png" class="img-style-2" alt="" /> --}}
                                    <img src="{{ asset('/assets/img/bottomQR.png') }}" alt="" />
                                    <p class="ticket-number">
                                        #20030220
                                    </p>
                                </div>
                                <div style="margin-top: 80px; ">
                                    <div class="content-3-last">

                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
