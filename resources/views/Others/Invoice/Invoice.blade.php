<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.invoice-main-container {
    width: 80%;
    border: 1px solid black;
    margin: 0 auto;
    padding: 40px;
}
.invoice-header img {
    width: 120%;
    height: 10rem;
}
.order {
    float: right;
}

.header-image {
    width: 100%;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
    
}


.invoice-imgs img {
   
  max-width: 190%;
  height: auto;
  position: relative;
  left: 15%;
  top: -2%;
}
/* .invoice-imgs {
    text-align: center;
    vertical-align: middle;
} */
.left-address {
    float: left;
    text-align: left;
}
.left-condition {
    /* float: left; */
    text-align: left;
}
.payment-info {
    float: left;
    text-align: left;
}
.right-address {
    float: right;
    text-align: left;
}

.product-holder {
    width: 100%;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
}
th {
    border: 1px solid black;
    background-color: darkslategray;
    color: white;
}
.table-data {
    border: 1px solid black;
}

.grand-total {
    height: 200px;
    width: 200px;
    margin: 0 0 0 auto;
}
.parent {
    margin: 0 auto;
    width: 100%;
    /* padding-top: 10px; */
}
.thank {
    text-align: center;
}
.terms_condition {
    width: 100%;
}
.terms-heads {
    float: left;
    text-align: left;
}
.terms {
    float: left;
    text-align: left;
}

.sign {
    border: 1px solid black;
    width: 150px;
    float: right;
}

.sign-text {
    margin-right: -125px;
    float: right;
}

.invoice-fotter img {
    width: 100%;
    height: 5rem;
    margin-top: 20px;
}

.total {
    border: 1px solid black;
    width: 300px;
    float: right;
    margin-top: 10px;
}

.g-total {
    word-spacing: 15px;
}

/* center content  */
.collumn-1 {
    width: 70%;
}
.collumn-2 {
    width: 30%;
}
.sub-content ul li{
    font-size:13px;
}

@media print {
    body {
        -webkit-print-color-adjust: exact;
    }
}

@media only screen and (max-width: 768px) {
    .invoice-fotter img {
        width: 270px;
        height: 3rem;
        margin-top: 50px;
    }

    .grand-total {
        font-size: 10px;
    }

    .order {
        font-size: 10px;
    }
    .left-address {
        font-size: 12px;
        text-align: left;
    }

    .right-address {
        font-size: 10px;
        text-align: left;
    }

    .left-condition {
        font-size: 5px;
        text-align: left;
    }
    .sign-container {
        float: none !important;
        font-size: 5px;
    }
    .left-contain {
        width: 70%;
    }
    .right-contain {
        width: 30%;
    }
    .sign {
        border: 1px solid black;
        width: 100% !important;
        float: none !important;
        margin-right: 15px !important;
    }
    .sign-text {
        margin-right: 10px;
        font-size: 8px;
    }

    .product-holder {
        font-size: 12px;
    }

    .thank {
        text-align: center;
        font-size: 10px;
    }

    .total {
        width: 250px;
        margin-top: 20px;
    }

    .terms {
        text-align: left;
        font-size: 10px;
    }
    .terms-heads {
        font-size: 10px;
    }

    .payment-info {
        float: left;
        text-align: left;
        font-size: 12px;
    }
}

@media only screen and (max-width: 600px) {
    invoice-fotter img {
        width: 280% !important;
        height: 5rem;
        margin-top: 20px;
    }
}

@media only screen and (min-width: 601px) and (max-width: 768px) {
    .invoice-fotter img {
        width: 100%!important;
        height: 2rem;
        margin-top: 30px;
    }
}

    </style>
</head>
<body>
<div class="invoice-main-container">
    <table class="header-image">
        <tr class='invoice-parent'>
            <td >
                <div class="invoice-imgs">
                    <img src="./assets/Invoice-header.png" alt="">

                </div>
            </td>
        </tr>

        <tr>
            <td>
                <div class="order">
                @if($data)
                    <p>Order ID: #{{ $data['orderID'] }}</p>
                    <p>Order Date: {{ $data['orderDate'] }} </p>
                   
                </div>
            </td>
        </tr>

        <tr>
            <td class="left-address">
               
              <div >
                 <h3>HelloSuperstars.com </h3>
                  <p>Adress: Dhaka, Bangladesh</p>
                 <p>Email: support@hellosuperstars.com</p>
                 <p>Phone: +880-1784-502680</p>


             </div>
            </td>

            <td class="right-address">
               
                <div >
                   <h3>HelloSuperstars.com </h3>
                    <p>Adress: Dhaka, Bangladesh</p>
                   <p>Email: support@hellosuperstars.com</p>
                   <p>Phone: +880-1784-502680</p>
  
               </div>
              </td>
        </tr>
    </table>

    <table  class="product-holder">
        <tr>
          <th >Product Name</th>
          <th>Superstar Name</th> 
          <th>Qty</th>
          <th>Unit Price</th>
          <th>Total</th>
        </tr>
        <tr>
            
            <td>{{ $data['productName'] }}</td>
            <td>{{ $data['SuperStar'] }}</td>
            <td>{{ $data['qty'] }}</td>
            <td> $ {{ $data['unitPrice'] }}</td>
            <td> $ {{ $data['total'] }}</td>
        </tr>   
      </table>

     <div class="parent">
        <div class="grand-total ">
            <table >
                <tr>
                    <td>Sub Total</td>
                    <td>{{ $data['subTotal'] }} </td>
                    
                  </tr>
                  <tr>
                    <td >Delivery Charge</td>
                    <td> $ {{ $data['deliveryCharge'] }} </td>
                    
                  </tr>
                  <tr>
                    <td>Total Tax </td>
                    <td> $ {{ $data['tax'] }} </td>
                    
                  </tr>

            </table>

            <div class="total">

            </div>

            <p class="g-total">Grand Total  $ {{ $data['grandTotal'] }}  </p>


        </div>
     </div>

 <div class="center-contents">
    <h3>THANK YOU FOR YOUR BUSINESS</h3>
 </div>
 <div class="sub-content">
    <ul>
        <li>Payment Info</li>
        <li>A/C Name: {{ $data['name'] }}</li>
        <li>Payment Status: paid</li>
    </ul>
 </div>






    <table class="terms_condition">
    
        
        <tr>
          <td class="collumn-1">
            <h4>Terms & Conditions</h4>
            <ul>
                <li>
                {{ $data['description'] }}
                </li>
                
                
            </ul>
          </td>
        <td class="collumn-2"> 
            <div class="sign-container">
            <div class="sign"></div>
            <h4 class="sign-text">Authorised Sign</h4>
           </div>
        </td>
        </tr>
      </table>

    <table class="header-image">

      <tr>
        <td>
            <div class="invoice-fotter">
                <img src="./assets/Invoice-footer.png" class='footer-img'  alt="">
            </div>
        </td>
      </tr>
      @endif
    </table>
</div>      
</body>
</html>