<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aksara</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      font-size: 14px;
      background-color: #f7f7f7;
      color: #242424; }

    a {
      color: #EF426F;
      font-weight: 600;
      text-decoration: none; }
      a:hover {
        text-decoration: underline; }

    p {
      font-weight: 500;
      margin: 0; }

    #container {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 3px !important; }

    #header {
      border-bottom: 1px solid rgba(0, 0, 0, 0.05); }
      #header .logo {
        padding: 20px 40px; }
        #header .logo img {
          max-width: 125px;
          max-height: 60px; }

    #content .content-wrapper {
      padding: 20px 40px 0; }
      #content .content-wrapper h2 {        
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 20px; }
      #content .content-wrapper p {
        margin: 0 0 30px; }
    #content .order {
      text-align: center;
      background: #E70606;
      height: 50px;
      margin: 0 40px;
      line-height: 50px; }
      #content .order span {
        text-transform: uppercase;
        color: #fff;
        font-weight: 700;
        font-size: 12px; }
    #content .tagihan-id {
      background: #EF426F; }
    #content .time_out {
      background: #E1E1E1; }
      #content .time_out a {
        color: #242424; }
    #content .sukses {
      background: #54D169; }

    #harga {
      padding: 20px 40px; }
      #harga .thead {
        color: #EF426F;
        font-weight: 700; }
      #harga td {
        padding: 10px 0;
        border-bottom: 1px solid #e8e7e7;
        color: #949494;
        font-weight: 500; }
      #harga td.total {
        font-weight: 700;
        color: #414141; }

    #term {
      padding: 150px 40px 20px; }

    .term_tagihan {
      padding: 50px 40px 20px !important; }

    #term-wrap {
      background: #FFF4E8;
      border: 2px solid #F8C372;
      border-radius: 8px; }
      #term-wrap p {
        font-size: 10px;
        font-weight: 600;
        color: #606060;
        margin: 0;
        line-height: 1.8; }
      #term-wrap img {
        width: 32px; }

    #footer {
      background: #F7F7F7;
      border-top: 1px solid rgba(0, 0, 0, 0.05); }

    #copyright {
      padding: 20px 40px 0; }
      #copyright td {
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); }
      #copyright .copy_text {
        font-size: 12px;
        color: #8F8F8F;
        font-weight: 500; }
      #copyright a {
        margin-right: 15px; }
        #copyright a img {
          height: 18px; }

    #unsubscribe {
      padding: 20px 40px 40px;
      font-size: 10px;
      text-align: center; }

    #amount {
      padding: 20px 40px; }
      #amount .amount-detail h3 {
        font-size: 32px;
        color: #414141;
        margin: 15px 0; }
      #amount .amount-detail p.info {
        color: #B1B1B1;
        font-style: italic;
        font-weight: 600; }

    #bank_account {
      margin: 20px 0 40px;
      background: #F9F9F9;
      border: 1px solid rgba(0, 0, 0, 0.2); }
      #bank_account td {
        border-bottom: 1px solid rgba(0, 0, 0, 0.2);
        padding: 15px 25px; }
      #bank_account .number {
        font-weight: 700;
        color: #727272;
        display: block; }

    #deal_time {
      padding: 20px 40px 0; }
      #deal_time td {
        padding: 10px 0;
        border-bottom: 1px solid #e8e7e7;
        color: #949494;
        font-weight: 500; }

    .alamat {
      font-style: normal;
      color: #949494;
      font-weight: 500;
      line-height: 1.7;
      margin: 0 40px; }

    .btn-link-wrap {
      margin: 50px 0; }

    #link_btn {
      background: #EF426F;
      color: #fff;
      text-transform: uppercase;
      padding: 15px 40px;
      border-radius: 25px;
      font-weight: 700; }   
  </style>

</head>
<body>
  <div>
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="main_wrapper">
      <tbody>
        <tr>
          <td valign="top" align="center">
            <table id="container" width="600" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                   
                <tr>
                  <td>
                    <table id="content" width="600" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td>
                            <div class="content-wrapper">
                              <h2>Reset Password</h2>
                              <p>You are receiving this email because we received a password reset request for your account. </p>
                              <p>Click this link : <a href="{{ url(config('app.url').route('password.reset', $token, false)) }}" >Reset Password</a></p>
                              <p>If you did not request a password reset, no further action is required.</p>
                            </div>
                          </td>
                        </tr>                    
                      </tbody>
                    </table>                  
                  </td>
                </tr>
                <tr>
                  <td>
                    <table id="footer" width="600" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td>
                            <table id="copyright" width="600" cellspacing="0" cellpadding="0" border="0">
                              <tbody>
                                <tr>
                                  <td class="copy_text">© {{ date('Y') }} {{ config('app.name') }}.</td>                                  
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>                  
                  </td>
                </tr>                                               
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>