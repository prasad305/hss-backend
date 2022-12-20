<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>

     <style>
          .mail-body {
               background-color: aliceblue;
          }

          .mail-center {
               display: flex;
               justify-content: center;

          }

          .mail-container {
               font-family: arial;
               font-size: 24px;
               margin: 25px;
               max-width: 800px;

               background-image: url("{{asset('img/bg-img.jpeg')}}");
               background-position: center;
               background-repeat: no-repeat;
               background-size: cover;
               border-radius: 10px;
               text-align: center;
               -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
          }

          .mail-img {
               margin-top: 80px;
          }

          .mail-cat {
               color: rgb(255, 174, 0);
               text-shadow: 5px 5px 10px rgb(255, 123, 0);
          }

          .mail-title {
               text-align: left !important;
               padding: 0px 10%;
               color: rgb(200, 201, 202);
               font-weight: 500;
               margin: 0;
               font-size: large;
               font-family: 'Rubik', sans-serif;
               margin-bottom: 10px;
               line-height: 30px;
          }

          .img-footer {
               margin: 0px;
               height: 100px;
               width: 100%;

          }

          .top-footer {
               font-size: large;
               font-weight: 800;
               justify-content: center;
               background-color: azure;
               margin: 0px 70px;
               border-radius: 10px;
               text-align: center;
               -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               margin-top: 20px;
               margin-bottom: 20px;
               padding: 20px;
          }

          .link {
               color: rgb(228, 155, 21);
          }

          @media only screen and (max-width: 991px) {

               .mail-cat {
                    color: rgb(255, 174, 0);
                    text-shadow: 5px 5px 10px rgb(255, 123, 0);
                    font-size: 25px !important;
               }

               .mail-title {
                    font-size: 12px;
                    line-height: 25px;
                    padding: 0px 5%;
               }

               .top-footer {
                    font-size: 12px;
                    margin: 0px 20px;
               }

               .img-footer {
                    margin: 0px;
                    height: 70px;
                    width: 100%;

               }
          }
     </style>
</head>

<body  marginheight="0" topmargin="0" marginwidth="0" leftmargin="0" style="background-color: aliceblue;@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700);
font-family: 'Open Sans',
sans-serif;">
     <div class="mail-center">

          <div class="mail-container " style="font-family: arial;
               font-size: 24px;
               margin: 25px;
               max-width: 800px;
               background-image: url('https://www.hellosuperstars.com/static/media/HelloSuperStarLogo.b2954c0f9e2cfe31a215.png');
               background-position: center;
               background-repeat: no-repeat;
               background-size: cover;
               border-radius: 10px;
               text-align: center;
               -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);">
               <img width="120"
                    src="https://www.hellosuperstars.com/static/media/HelloSuperStarLogo.b2954c0f9e2cfe31a215.png"
                    title="logo" alt="logo" class="mail-img">
               <h2 class="mail-cat" style=" color: rgb(255, 174, 0);
                    text-shadow: 5px 5px 10px rgb(255, 123, 0);
                    font-size: 25px !important;">
                    {{$senderInfo->category->name}}
               </h2>
               <p class="mail-title" style=" text-align: left !important;
               padding: 0px 10%;
               color: rgb(200, 201, 202);
               font-weight: 500;
               margin: 0;
               font-size: large;
               font-family: 'Rubik', sans-serif;
               margin-bottom: 10px;
               line-height: 30px;">
                    Date : {{ date("F j, Y, g:i a") }}
               </p>
               <p class="mail-title" style=" text-align: left !important;
               padding: 0px 10%;
               color: rgb(200, 201, 202);
               font-weight: 500;
               margin: 0;
               font-size: large;
               font-family: 'Rubik', sans-serif;
               margin-bottom: 10px;
               line-height: 30px;">
                    Subject :  {{$postInfo->title}}
               </p>
               <p class="mail-title" style=" text-align: left !important;
               padding: 0px 10%;
               color: rgb(200, 201, 202);
               font-weight: 500;
               margin: 0;
               font-size: large;
               font-family: 'Rubik', sans-serif;
               margin-bottom: 10px;
               line-height: 30px;">Respected (Sir/Madam),</p>
               <p class="mail-title" style=" text-align: left !important;
               padding: 0px 10%;
               color: rgb(200, 201, 202);
               font-weight: 500;
               margin: 0;
               font-size: large;
               font-family: 'Rubik', sans-serif;
               margin-bottom: 10px;
               line-height: 30px;">
                    {!! $postInfo->description !!}
               </p>
               <div class="top-footer">
                    POSTED BY {{$senderInfo->first_name}} {{$senderInfo->last_name}},
                    <br>
                    THANK YOU <br>
                    &copy; <strong><a href="https://www.hellosuperstars.com/" target="_blank"
                              class="link">www.hellosuperstars.com</a></strong>
               </div>

               <img src="https://www.hellosuperstars.com/static/media/HelloSuperStarLogo.b2954c0f9e2cfe31a215.png" alt="" class="img-footer">
          </div>

     </div>

</body>

</html>