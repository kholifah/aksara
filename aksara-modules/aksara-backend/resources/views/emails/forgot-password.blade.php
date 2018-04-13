<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aksara</title>
</head>
<body style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:'Montserrat', sans-serif;font-size:14px;background-color:#f7f7f7;color:#242424;" >
  <div>
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="main_wrapper">
      <tbody>
        <tr>
          <td valign="top" align="center">
            <table id="container" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color:#fff;border-width:1px;border-style:solid;border-color:#ddd;border-radius:3px !important;" >
              <tbody>
                   
                <tr>
                  <td>
                    <table id="content" width="600" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td>
                            <div class="content-wrapper" style="padding-top:20px;padding-bottom:0;padding-right:40px;padding-left:40px;" >
                              <h2 style="font-size:28px;font-weight:700;margin-top:0;margin-bottom:20px;margin-right:0;margin-left:0;" >Reset Password</h2>
                              <p style="font-weight:500;margin-top:0;margin-bottom:30px;margin-right:0;margin-left:0;" >You are receiving this email because we received a password reset request for your account. </p>
                              <p style="font-weight:500;margin-top:0;margin-bottom:30px;margin-right:0;margin-left:0;" >Click this link : <a id="link_btn" href="{{ url(config('app.url').route('password.reset', $token, false)) }}" style="text-decoration:none;background-color:#2c2abb;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;color:#fff;text-transform:uppercase;padding-top:5px;padding-bottom:5px;padding-right:10px;padding-left:10px;border-radius:10px;font-weight:700;" >Reset Password</a></p>
                              <p style="font-weight:500;margin-top:0;margin-bottom:30px;margin-right:0;margin-left:0;" >If you did not request a password reset, no further action is required.</p>
                            </div>
                          </td>
                        </tr>                    
                      </tbody>
                    </table>                  
                  </td>
                </tr>
                <tr>
                  <td>
                    <table id="footer" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color:#F7F7F7;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-top-width:1px;border-top-style:solid;border-top-color:rgba(0, 0, 0, 0.05);" >
                      <tbody>
                        <tr>
                          <td>
                            <table id="copyright" width="600" cellspacing="0" cellpadding="0" border="0" style="padding-top:20px;padding-bottom:0;padding-right:40px;padding-left:40px;" >
                              <tbody>
                                <tr>
                                  <td class="copy_text" style="padding-bottom:20px;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgba(0, 0, 0, 0.05);font-size:12px;color:#8F8F8F;font-weight:500;" >© {{ date('Y') }} {{ config('app.name') }}.</td>                                  
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