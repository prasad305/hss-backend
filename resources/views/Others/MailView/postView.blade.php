<!doctype html>
<html lang="en-US">

<head>
     <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
     <title>Post Notification Email Template</title>
     <meta name="description" content="Reset Password Email Template.">
     <style type="text/css">
          a:hover {
               text-decoration: underline !important;
          }

          .mail-container {


               /* background-image: url("https://www.hellosuperstars.com/static/media/bg-img.e3e9bbc346325749e206.jpeg"); */
               background-position: center;
               background-repeat: no-repeat;
               background-size: cover;
               -webkit-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               -moz-box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
               box-shadow: 0 6px 18px 0 rgba(0, 0, 0, .06);
          }
     </style>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
     <!--100% body table-->
     <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="aliceblue"
          style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
          <tr>
               <td>
                    <table style=" max-width:670px;  margin:0 auto;" width="100%" border="0" align="center"
                         cellpadding="0" cellspacing="0">
                         <tr>
                              <td style="height:80px;">&nbsp;</td>
                         </tr>

                         <tr>
                              <td style="height:20px;">&nbsp;</td>
                         </tr>
                         <tr>
                              <td>
                                   <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                        class="mail-container"
                                        style="max-width:670px;  text-align:center;background-color: #fff;">
                                        <tr>
                                             <td style="height:40px;">&nbsp;</td>

                                        </tr>
                                        <tr>
                                             <td style="text-align:center;">
                                                  <a href="https://www.hellosuperstars.com" title="logo"
                                                       target="_blank">
                                                       <img width="120"
                                                            src="https://www.hellosuperstars.com/static/media/HelloSuperStarLogo.b2954c0f9e2cfe31a215.png"
                                                            title="logo" alt="logo">
                                                  </a>
                                             </td>
                                        </tr>
                                        <tr>

                                             <td style="padding:0 35px;padding-top:20px">
                                                  <h2
                                                       style="
                                                       text-shadow: 5px 5px 10px #bba78f;color:#e9ad07f1; font-weight:800; margin:0;font-size:25px;font-family:'Rubik',sans-serif;">
                                                       <!-- Sports -->
                                                       {{$senderInfo->category->name}}
                                                  </h2>


                                             </td>
                                        </tr>
                                        <tr style="text-align: left;">
                                             <td>
                                                  <br>
                                                  <br>
                                                  <p style="color:#455056;padding: 0px 40px;">
                                                       Date : {{ date("F j, Y, g:i a") }}
                                                       <!-- Post title : {{$postInfo->title}} -->
                                                  </p>
                                                  <p
                                                       style="color:#455056; font-size:15px;line-height:24px; margin:2px 40px;">
                                                       <span style="font-weight: 600;">Subject : </span>
                                                       <!-- Sick Leave
                                                       Application
                                                       to Principal Written By Parents of Child -->
                                                       {{$postInfo->title}}
                                                  </p>

                                                  <p
                                                       style="color:#455056; font-size:15px;line-height:24px; padding: 15px 40px 0px 40px;">
                                                       Respected (Sir/Madam),
                                                  </p>
                                                  <div style="color:#455056; font-size:15px;line-height:24px; margin:0px 40px; text-align:left !important"><table ><tr >
                                                       <td >
                                                            
                                                       {!! $postInfo->description !!}
                                                       </td>
                                                  </tr></table></p>
                                                  <!-- <p
                                                       style="color:#455056; font-size:15px;line-height:24px; margin:0px 40px;">
                                                       Shakib Al Hasan has his career decorated with a large number of
                                                       records, most of them coming as an all-rounder. He holds the
                                                       record for the highest fifth wicket partnership in the ICC
                                                       Champions Trophy (225 runs with Mahmudullah). This partnership
                                                       also made the duo to get the highest batting partnership for
                                                       Bangladesh in One Day Internationals.
                                                       Shakib Al Hasan is also the first Bangladeshi bowler to have
                                                       taken 5 wickets in a match against all the Test playing nations.
                                                       He is the fourth bowler in the World to achieve this feat after
                                                       Dale Steyn, Muttiah Muralitharan and Rangana Herath. Also, Shakib
                                                       Al Hasan has taken 76 wickets at the Shere Bangla Stadium in T20I
                                                       matches, which is a record for taking the highest wickets at a
                                                       single ground.
                                                       {!! $postInfo->description !!}
                                                  </p> -->




                                             </td>


                                        </tr>
                                        <tr>
                                             <td>
                                                  <center
                                                       style="text-align: center;text-decoration:none !important; font-weight:500; margin-top:35px; color:rgb(0, 0, 0);text-transform:uppercase; font-size:14px;padding:5px 20px;display:inline-block;border-radius:5px;">

                                                       POSTED BY

                                                       <span style="color:coral;font-weight:600">
                                                       <!-- MANAGER ADMIN (MUSICIANS) -->

                                                       {{$senderInfo->first_name}} {{$senderInfo->last_name}}
                                                       </span>
                                                       ,
                                                       <br>

                                                       <span style="color:darkgoldenrod;font-weight:600">
                                                       THANK YOU
                                                       </span>

                                                  </center>
                                             </td>
                                        </tr>


                                   </table>
                                   <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">

                                        <td><img style="margin: 0px;
                                             height: 70px;
                                             width: 100%;"
                                                  src="https://www.hellosuperstars.com/static/media/footer.jpg" alt="">
                                        </td>
                                   </table>


                              </td>
                         <tr>
                              <td style="height:20px;">&nbsp;</td>
                         </tr>
                         <tr>
                              <td style="text-align:center;">
                                   <a href="https://www.hellosuperstars.com/"
                                        style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                                        &copy; <strong>www.hellosuperstars.com</strong></a>
                              </td>
                         </tr>
                         <tr>
                              <td style="height:80px;">&nbsp;</td>
                         </tr>
                    </table>
               </td>
          </tr>
     </table>
     <!--/100% body table-->
</body>

</html>

<!-- https://www.hellosuperstars.com/static/media/static/media/bg-img.e3e9bbc….jpeg -->


</body>

</html>