<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HelloSuperstar Cirtificate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap" rel="stylesheet"> --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet"> --}}
<!-- <link rel="stylesheet" href="./assets/css/style.css"> -->
    <style>
      /* @import url("https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap"); */

      * {
        box-sizing: border-box;
      }

      @media print {
        .no-print,
        .no-print * {
          display: none !important;
        }

        .print-m-0 {
          margin: 20% !important;
          width: 90% !important;
        }
      }

      .btn {
        padding: 10px 17px;
        border-radius: 3px;
        background: #f4b71a;
        border: none;
        font-size: 12px;
        margin: 10px 5px;
      }

      .toolbar {
        background: #333;
        width: 100vw;
        position: fixed;
        left: 0;
        top: 0;
        text-align: center;
      }

      .cert-container {
        margin: 65px 0 65px 0;
        width: 80%;
        display: flex;
        justify-content: center;
      }

      .cert {
        width: 800px;
        height: 600px;
        padding: 15px 20px;
        text-align: center;
        position: relative;
        z-index: -1;
      }

      .cert-bg {
        position: absolute;
        left: 0px;
        top: 0;
        z-index: -1;
        width: 100%;
      }

      .cert-content {
        width: 750px;
        height: 470px;
        padding: 30px 60px 0px 60px;
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
      }

      h1 {
        font-size: 20px;
      }

      p {
        font-size: 25px;
      }

      small {
        font-size: 14px;
        line-height: 12px;
      }

      .bottom-txt {
        padding: 12px 5px;
        display: flex;
        justify-content: space-between;
        font-size: 16px;
      }

      .bottom-txt * {
        white-space: nowrap !important;
      }

      .other-font {
        font-family: Cambria, Georgia, serif;
        font-style: italic;
      }

      .ml-215 {
        margin-left: 215px;
      }

      .Logo img {
        height: 80px;
        width: 80px;
      }
      .QrCode img {
        height: 50px;
        width: 50px;
        margin: 0;
        padding: 0;
      }
      .sign {
        border-width: 1;
        border-bottom: 1px solid black;
        width: 60%;
        margin: 0 auto;
      }
      .sign img {
        height: 30px;
        width: 30px;
      }
      .signature small {
        font-size: 10px;
        margin: 0;
        padding: 0;
      }
      .signature span {
        font-size: 13px;
        font-weight: bold;
        margin: 0;
        padding: 0;
      }

      .text-img img {
        height: 40px;
        width: 450px;
      }
      .text-img2 img {
        height: 30px;
        width: 200px;
      }
      /* .font-Name {
        font-family: "Dancing Script", cursive;
      } */

      .header {
        /* background-color: green; */
        width: 100% !important;
      }
      table,
      td,
      th {
        border: 0px solid;
      }

      table {
        width: 100%;
        border-collapse: collapse;
      }

      .stars span {
        font-size: 30px;
        color: #f4b71a;
      }
      .titlecirtificate{
    font-size: 30px;
    font-weight: 800;
   color: #ad7b17;
  margin: 5px;
  padding: 0;
  }
  .mainContent p{
    font-size: 14px;
  }
    </style>
  </head>

  <body>
    <!-- <div class="toolbar no-print">
        <button class="btn btn-info" onclick="window.print()">
          Print Certificate
        </button>
        <button class="btn btn-info" id="downloadPDF">Download PDF</button>
      </div> -->

    <div class="cert-container print-m-0">
      <div id="content2" class="cert">
        <img src="{{asset('/assets/img/bg.png')}}" class="cert-bg" alt="" />
        @if ($PDFInfo['certificateContent'])
          
        
        <div class="cert-content">
          <div class="header">
            <table>
              <tr>
                <th>
                  <div class="Logo" style="text-align: left">
                    <img src="{{asset('/assets/img/versetilo-gp.png')}}" alt="" />
                  </div>
                </th>
                <th>
                  <div class="Logo" style="text-align: right">
                    
                    <img src="{{asset('/assets/img/logo.png')}}" alt="" />
                  </div>
                </th>
              </tr>
            </table>
          </div>

          <!-- <h1 class="other-font" style="font-size: 30px;">Certificate of Participation</h1> -->
          <div class="text-img">

            <h1 class="titlecirtificate">{{$PDFInfo['certificateContent']->title}}</h1>
          </div>
          <span
            style="
              font-size: 15px;
              text-transform: uppercase;
              font-weight: bold;
            "
            >{{$PDFInfo['certificateContent']->sub_title}}</span
          >
          <br />
          <span class="other-font">
            <div class="text-img2">
                
        {{-- {{asset('asset/img/versetilo-gp.png')}} --}}
              <img src="{{asset('/assets/img/mid-design.png')}}" alt="" />
            </div>
          </span>
          <br />
          @if($PDFInfo)
          
          <span class="other-font" style="font-size: 35px"
            ><span class="">{{ $PDFInfo['user'] }}</span></span
          >
          @endif
          <br />
          <br />
          
          <div class="mainContent">{!!html_entity_decode($PDFInfo['certificateContent']->main_content)!!}</div
            
          >
          <br /><br />

          <div class="stars">
            <i class="far fa-star fa-stack-1x"></i>
            @foreach(range(1,5) as $i)
    @if($PDFInfo['starRating'] >0)
        @if($PDFInfo['starRating'] >0.5)
            <i class="fa fa-star"></i>
        @else
            <i class="fa fa-star-half-o"></i>
        @endif
    @else
        <i class="fa  fa-star-o"></i>
    @endif
@endforeach
          </div>
          @endif
          <table>
            <tr>
              <th>
                @if(sizeof($PDFInfo['stars']) > 0)
                    @foreach ($PDFInfo['stars'] as $PDF)
                        @if ($PDF['isSuperAdmin'])
                        {{-- @dd($PDF['fullName']) --}}
                        <div class="signature">
                            <div class="sign">
                              <img src=" {{ asset('http://localhost:8000/' . $PDF['signature']) }}" alt="" />
                            </div>
                            <span>{{ $PDF['name'] }}</span> <br />
                            <small>Super Judge</small> <br />
                            <small>Hello Super Stars</small>
                          </div>
                        @endif
                    @endforeach
                @endif
                
              </th>
              
              @foreach ($PDFInfo['stars'] as $PDF)
                        @if (!$PDF['isSuperAdmin'])
                        <th>
                          <div class="signature">
                            <div class="sign">
                              <img src=" {{ asset('http://localhost:8000/' . $PDF['signature']) }}" alt="" />
                            </div>
                            <span>{{ $PDF['name'] }}</span> <br />
                            <small>Judge</small> <br />
                            <small>Hello Super Stars</small>
                          </div>
                        </th>
                        @endif
                @endforeach
              
            </tr>
          </table>

          <!-- <small
              >lorem jf sdkljflsdjfklsdjfksdlf</small
            > -->
          <!-- <div class="bottom-txt">
              <span>dsfsdfsdfF</span>
              <span>Completed on:  2022</span>
            </div> -->
        </div>
      </div>
    </div>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script src="./assets/js/main.js"></script> -->
    <script>
      $("#downloadPDF").click(function () {
        // $("#content2").addClass('ml-215'); // JS solution for smaller screen but better to add media queries to tackle the issue
        getScreenshotOfElement(
          $("div#content2").get(0),
          0,
          0,
          $("#content2").width() + 45, // added 45 because the container's (content2) width is smaller than the image, if it's not added then the content from right side will get cut off
          $("#content2").height() + 30, // same issue as above. if the container width / height is changed (currently they are fixed) then these values might need to be changed as well.
          function (data) {
            var pdf = new jsPDF("l", "pt", [
              $("#content2").width(),
              $("#content2").height(),
            ]);

            pdf.addImage(
              "data:image/png;base64," + data,
              "PNG",
              0,
              0,
              $("#content2").width(),
              $("#content2").height()
            );
            pdf.save("azimuth-certificte.pdf");
          }
        );
      });

      // this function is the configuration of the html2cavas library (https://html2canvas.hertzen.com/)
      // $("#content2").removeClass('ml-215'); is the only custom line here, the rest comes from the library.
      function getScreenshotOfElement(
        element,
        posX,
        posY,
        width,
        height,
        callback
      ) {
        html2canvas(element, {
          onrendered: function (canvas) {
            // $("#content2").removeClass('ml-215');  // uncomment this if resorting to ml-125 to resolve the issue
            var context = canvas.getContext("2d");
            var imageData = context.getImageData(
              posX,
              posY,
              width,
              height
            ).data;
            var outputCanvas = document.createElement("canvas");
            var outputContext = outputCanvas.getContext("2d");
            outputCanvas.width = width;
            outputCanvas.height = height;

            var idata = outputContext.createImageData(width, height);
            idata.data.set(imageData);
            outputContext.putImageData(idata, 0, 0);
            callback(
              outputCanvas.toDataURL().replace("data:image/png;base64,", "")
            );
          },
          width: width,
          height: height,
          useCORS: true,
          taintTest: false,
          allowTaint: false,
        });
      }
    </script>
  </body>
</html>
