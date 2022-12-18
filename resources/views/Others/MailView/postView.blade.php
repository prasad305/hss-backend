<!doctype html>
<html lang="en-US">

<head>
     <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
     <title>Post Notification Email Template</title>
     <meta name="description" content="Reset Password Email Template.">


     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap" rel="stylesheet">
     <style type="text/css">
          @import url('https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap');


          .a-tag:hover {
               text-decoration: underline !important;
          }


          .body-email {
               max-width: 670px;
               background: rgb(26, 25, 25);
               border-radius: 10px;
               -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);

          }

          .mail-cat {
               font-weight: 500;
               margin: 0;
               font-size: 25px;
               font-family: 'Bungee Spice', sans-serif;
               background: -webkit-linear-gradient(rgb(195, 49, 5), rgb(255, 181, 7));
               -webkit-background-clip: text;
               -webkit-text-fill-color: transparent;
               font-weight: 600;
          }

          .mail-title {
               color: #acacac;
               font-size: 18px;
               font-weight: 600;
          }

          .mail-sir {
               color: #acacac;
               font-size: 17px;
               font-weight: 600;
          }

          .mail-description {
               color: #acacac;
               font-size: 15px;
          }

          .top-footer {
               background: #ececec;
               text-decoration: none !important;
               font-weight: 500;
               margin-top: 35px;
               color: rgb(0, 0, 0);
               text-transform: uppercase;
               font-size: 14px;
               padding: 5px 20px;
               display: inline-block;
               border-radius: 5px;
          }

          .mail-footer {
               font-size: 14px;
               color: rgba(250, 171, 0, 0.741);
               line-height: 18px;
          }
     </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" leftmargin="0" class="main-mail">
     <br> <br> <br> <br>
     <!--100% body table-->
     <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="body-email pt-5">
          <tr>
               <td style="height:20px;">&nbsp;</td>
          </tr>

          <tr>
               <td class="text-center">
                    <a href="https://www.hellosuperstars.com" title="logo" target="_blank" class="a-tag">
                         <img width="80"
                              src="https://www.hellosuperstars.com/static/media/HelloSuperStarLogo.b2954c0f9e2cfe31a215.png"
                              title="logo" alt="logo">
                    </a>
               </td>
          </tr>
          <tr>

               <td style="padding:0 35px;padding-top:20px">
                    <h2 class="mail-cat text-center">
                         {{$senderInfo->category->name}}
                    </h2>

                    <br>
                    <p class="mail-title">
                         Subject : {{$postInfo->title}}
                    </p>
                    <p class="mail-sir">Respected (Sir/Madam),</p>
                    <p class="mail-description">
                         {!! $postInfo->description !!}
                    </p>


               </td>
          </tr>
          <tr class="text-center">
               <td>
                    <div href="javascript:void(0);" class="top-footer text-center">

                         POSTED BY {{$senderInfo->first_name}} {{$senderInfo->last_name}},
                         <br>
                         THANK YOU
                         <br>
                         {{ date("F j, Y, g:i a") }}
                    </div>
               </td>
          </tr>
          <tr>
               <td style="height:20px;">&nbsp;</td>
          </tr>

          <td class="text-center">
               <p class="mail-footer">
                    &copy; <strong>www.hellosuperstars.com</strong></p>
          </td>
     </table>
     <!--/100% body table-->
     <br>

</body>

</html>