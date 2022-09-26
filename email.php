<html lang="en">

    <head>
      <meta charset="UTF-8">
      <title>Test mail</title>
      <style>
        .wrapper {
          padding: 20px;
          color: #444;
          font-size: 1.3em;
        }
        a {
          background: #2b898b;
          text-decoration: none;
          padding: 8px 15px;
          border-radius: 5px;
          color: #fff;
        }
      </style>
    </head>

    <body>
      <div class="wrapper">
        <p>
        Hi username, </br>
        </br>
        We just need to verify your email address before you can access hotside. </br>
        </br>
        Verify your email address <a href="http://localhost/controllers/verify_email.php?token=' . $token . '">Verify Email!</a>
        </br></br>
        Thanks!
        </br> </br>
        – The hotside team
        </p>
      </div>
    </body>

    </html>