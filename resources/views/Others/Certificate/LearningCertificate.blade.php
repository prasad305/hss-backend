<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HelloSuperstar Learning Certificate</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
        @import url("https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap");

        .certificateHeading {
            background-color: #00233f;
            padding: 10px;
            color: #ddd;
            font-weight: bold;

            text-transform: uppercase;
        }

        .presentedText {
            color: #00233f;
        }

        .certificateBg {
            background-color: #fff;
            min-height: 70vh;
            font-family: "Poppins", sans-serif;
            /* background-image: url("../../../../Assets/Images/CertificateBg.png"); */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .celebrityName {
            color: #cc8f12;
            font-weight: 1000;
            font-size: 50px;
            font-family: "Dancing Script", cursive !important;
        }

        .underLineGold {
            border-bottom: 3px solid #cc8f12;
            width: 15vw;
        }

        .loremDiv {
            width: 90%;
        }

        .underLineSignature {
            border-bottom: 3px solid #cc8f12;
        }

        .SignatureTextBold {
            font-size: 30px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="row certificateBg">
        <div class="col-md-1"></div>
        <div class="col-md-7 d-flex justify-content-center align-items-center">
            <div>
                <div class="d-flex justify-content-center my-3">
                    <h3 class="certificateHeading text-center">
                        {" "}
                        Certificate of Achievement
                    </h3>
                </div>

                <h4 class="presentedText text-center">
                    This certificate is proudly presented to
                </h4>

                <h1 class="text-center celebrityName">
                    {certificateData && certificateData.name}
                </h1>

                <div class="d-flex justify-content-center">
                    <div class="underLineGold"></div>
                </div>

                <div class="d-flex justify-content-center presentedText my-3">
                    <p class="text-center">
                        This is certified by the HelloSuperStar authority to <br />
                        <b> {certificateData && certificateData.name}</b> son of
                        <b> {certificateData && certificateData.father_name}</b>.
                    </p>
                </div>

                <div class="d-flex justify-content-center presentedText">
                    <p class=" text-center">
                        an online grand talent reviewing session authorized by stars
                        and offered through HelloSuperStar.
                    </p>
                </div>

                <div class="row mx-auto d-flex justify-content-center mt-5">
                    {/* <div class="col-md-2"></div> */}
                    <div class="col-md-4 m-2">
                        <p class="presentedText SignatureTextBold text-center">
                            <img src='' alt="Img1" class="ImgAc" height={30} width={200} />
                        </p>
                        <div class="underLineSignature"></div>
                        <p class="presentedText text-center">
                            President's Signature
                        </p>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4 m-2">
                        <p class="presentedText SignatureTextBold text-center">
                            {moment(LearningSession.event_date).format("LL")}
                        </p>
                        <div class="underLineSignature"></div>
                        <p class="presentedText text-center">Date</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</body>

</html>
