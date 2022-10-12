<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HelloSuperstar Cirtificate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

            /* .print-m-0 {
          margin: 20% !important;
          width: 90% !important;
        } */
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
            /* margin: 55px 0; */
            /* width: 70% !important; */
            display: flex;
            justify-content: center;
        }

        .cert {
            width: 680px;
            height: 700px !important;
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
            /* background-color: #ad7b17; */
            width: 570px;
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
            width: 30%;
            margin: 0 auto;
        }

        .sign img {
            height: 40px;
            width: 40px;
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

        .titlecirtificate {
            font-size: 20px;
            font-weight: 800;
            color: #ad7b17;
            margin: 5px;
            padding: 0;
        }


        .mainContent span {
            font-size: 13px;
        }

        .mainContent b {
            font-size: 13px;
        }

        .tableRow {
            left: -10px;
            position: absolute;
            top: 20rem;
            /* background-color: green; */
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
            <img src="{{ asset('/assets/img/bg.png') }}" class="cert-bg" alt="" />


            <div class="cert-content">
                <div class="header">
                    <table>
                        <tr>
                            <th>
                                <div class="Logo" style="text-align: center">
                                    <img src="{{ asset('/assets/img/logo.png') }}" alt="" />
                                </div>
                            </th>

                        </tr>
                    </table>
                </div>

                <div class="text-img">

                    <h1 class="titlecirtificate">CERTIFICATE OF ACHIEVEMENT</h1>
                </div>
                <span
                    style="
                        font-size: 15px;
                        text-transform: uppercase;
                        font-weight: bold;
                      ">This
                    certificate is proudly presented to</span>
                <br />
                <span class="other-font">
                    <div class="text-img2">

                        <img src="{{ asset('/assets/img/mid-design.png') }}" alt="" />
                    </div>
                </span>
                <span class="other-font" style="font-size: 30px"><span
                        class="">{{ $PDFInfo['userName'] }}</span></span>

                <div class="mainContent">
                    <span>This is certified by the HelloSuperStar authority

                        <b>{{ $PDFInfo['userName'] }}</b> son of <b>{{ $PDFInfo['fatherName'] }}</b>
                    </span>
                    </br>
                    <span>
                        an online grand talent reviewing session authorized by stars and offered through
                        HelloSuperStars.
                    </span>

                </div>
                <br />


            </div>


            <table class="tableRow">
                <tr>
                    <th>

                        <div class="signature">
                            <div class="sign">
                                {{-- <img src="{{ asset('/assets/img/text.png') }}" alt="" /> --}}
                                <img src=" {{ asset('http://localhost:8000/' . $PDFInfo['signature']) }}"
                                    alt="" />
                            </div>
                            <span>{{ $PDFInfo['starFullName'] }}</span> <br />
                            <small>Super Star</small> <br />
                            <small>Hello Super Stars</small>
                        </div>

                    </th>
                    <th>
                        <div class="signature">
                            <div class="sign">
                                <img src="{{ asset('/assets/img/qr_code.png') }}" alt="" />
                            </div>
                        </div>
                    </th>





                </tr>
            </table>
            </span>
        </div>
    </div>
    </div>
    </div>

    <script>
        $("#downloadPDF").click(function() {
            // $("#content2").addClass('ml-215'); // JS solution for smaller screen but better to add media queries to tackle the issue
            getScreenshotOfElement(
                $("div#content2").get(0),
                0,
                0,
                $("#content2").width() +
                45, // added 45 because the container's (content2) width is smaller than the image, if it's not added then the content from right side will get cut off
                $("#content2").height() +
                30, // same issue as above. if the container width / height is changed (currently they are fixed) then these values might need to be changed as well.
                function(data) {
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
                onrendered: function(canvas) {
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
