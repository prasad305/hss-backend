<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&family=Roboto:ital,wght@0,300;1,300&display=swap');


        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(145, 141, 141);
            font-family: 'Roboto', sans-serif;

        }

        .mainCard {
            background-color: #FDFEFE;
            box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
            height: 500px;
            width: 30%;
            border-radius: 20px;


        }

        .subBody {
            padding: 30px;
        }

        .logo {
            text-align: center;
        }

        .status {
            text-align: center;
            font-size: 20px;
            color: #229F5E
        }

        .border {

            border-bottom: 1px solid black;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .id {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media only screen and (max-width: 600px) {
            .mainCard {
                width: 90%;
            }

            body {
                font-size: 13px;
            }
        }


        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
            .mainCard {
                width: 90%;
            }

            body {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <div class="mainCard">
        <div class="subBody">
            <div class="logo">
                <img src="https://cdn.dribbble.com/users/614270/screenshots/14575431/media/4907a0869e9ed2ac4e2d1c2beaf9f012.gif"
                    height="100px" width="100px">
            </div>
            <div class="status">Payment Received</div>

            <p>Hi, name</p>
            <span>Your transaction was successfull !</span>

            <p>Payment Details:</p>
            <span>Amount: €$moneyFormatter.format(${amount})</span>
            </br>
            <span>Account: ${accountNumber}.</span>
            </br>
            <span>We advise to keep this email for future reference.</span>


            <div class="border"></div>

            <b class="id">
                Transaction reference 2349048902348
            </b>

            <div style="display: flex;justify-content: center;">
                <div style="display:flex;margin: 10px;">

                    <div><img src="http://www.hadecoration.gift/public/images/ajax-loader-green.gif" height="20px"
                            width="20px"></div>
                    <div style="display: flex;justify-content: center;"> <span>Automatic redirect in 10 second</span>
                    </div>

                </div>
            </div>



            <div style="display: flex;justify-content: center;">
                <button
                    style="background-color: green; border:none; padding:5px 10px 5px 10px;color: white; border-radius: 10px; ">Go
                    Back</button>
            </div>

        </div>


    </div>

</body>
</body>

</html>
