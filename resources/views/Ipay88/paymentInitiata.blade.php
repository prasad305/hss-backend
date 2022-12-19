<!DOCTYPE html>
<html>

<head>
    <title>Ipay88 Initiating...</title>
    <style>
        .container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #000;
            overflow: hidden;
            position: relative
        }


        .box {
            position: relative;
            width: 100%;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            -webkit-box-reflect: below 0 linear-gradient(transparent, transparent, #0005);
        }

        .box .loader {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            animation: animateLoading 2s linear infinite;
        }

        .box .loader:nth-child(2),
        .box .loader:nth-child(4) {
            animation-delay: -1s;
            filter: hue-rotate(290deg);
        }

        @keyframes animateLoading {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .box .loader:nth-child(1)::before,
        .box .loader:nth-child(2)::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(to top, transparent, rgba(0, 255, 249, 0.5));
            background-size: 100px 180px;
            background-repeat: no-repeat;
            border-top-left-radius: 100px;
            border-bottom-left-radius: 100px;
        }

        .container .loader i {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 20px;
            background: #00fff9;
            border-radius: 50%;
            box-shadow: 0 0 10px #00fff9,
                0 0 20px #00fff9,
                0 0 30px #00fff9,
                0 0 40px #00fff9,
                0 0 50px #00fff9,
                0 0 60px #00fff9,
                0 0 70px #00fff9,
                0 0 80px #00fff9,
                0 0 90px #00fff9,
                0 0 100px #00fff9;
            z-index: 10;
        }

        .box .loader span {
            position: absolute;
            inset: 20px;
            background: #000;
            border-radius: 50%;
            z-index: 1;
        }

        .titleFont {

            color: #ffaa00;
            font-size: 20em !important,
                padding-top:100px !important
        }

        .titleFont img {

            margin-top: 20px
        }
    </style>
</head>

<body style="overflow: hidden; margin:0; padding:0" onLoad="myFunction()">



    <div class="container">

        <div class="box">

            <div class="loader"><span></span></div>
            <div class="loader"><span></span></div>
            <div class="loader"><i></i></div>
            <div class="loader"><i></i></div>
        </div>
        <div class="titleContainer">
            <div style='text-align:center;'>


                <img style='margin-top: 46px;'
                    src="https://www.ipay88.com/wp-content/uploads/2021/02/ipay88-logo-white.png" alt="Ipay 88 logo"
                    width="150">
            </div>

        </div>
    </div>


    <form action="{{ url('https://payment.ipay88.com.my/epayment/entry.asp') }}" method="post" id="myForm">

        <INPUT type="hidden" name="MerchantCode" value={{ $merchantCode }}><br>

        <INPUT type="hidden" name="PaymentId" value={{ $paymentFor }}><br>

        <INPUT type="hidden" name="RefNo" value={{ $refNo }}><br>

        <INPUT type="hidden" name="Amount" value={{ $amount }}><br>

        <INPUT type="hidden" name="Currency" value={{ $countryCode }}><br>
        <INPUT type="hidden" name="Xfield1" value={{ $paymentFor }}><br>
        <INPUT type="hidden" name="ProdDesc" value={{ $eventName }}><br>

        <INPUT type="hidden" name="UserName" value="shohan"><br>

        <INPUT type="hidden" name="UserEmail" value="sarwar.shohan24@gmail.com"><br>

        <INPUT type="hidden" name="UserContact" value="0126500111"><br>

        <INPUT type="hidden" name="Remark" value=""><br>

        <INPUT type="hidden" name="Lang" value="UTF-8"><br>

        <INPUT type="hidden" name="SignatureType" value="SHA256"><br>

        <INPUT type="hidden" name="Signature" value={{ $signature }}>


        <INPUT type="hidden" name="ResponseURL" value={{ $resUrl }}><br>

        <INPUT type="hidden" name="BackendURL" value={{ $resUrlBackend }}><br><br>

    </form>

</body>
<script>
    function myFunction() {
        document.getElementById("myForm").submit();
    }
</script>

</html>
